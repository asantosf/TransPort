<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Administracion\DetalleOrden;
use App\Models\Administracion\Lote;
use App\Models\Administracion\MateriaPrima;
use App\Models\Administracion\Producto;
use App\Models\Plantas\DetalleProduccion;
use App\Models\Plantas\Planta;
use App\Models\Plantas\Produccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables;

class ProductoController extends Controller
{
    //Inicio de manejo de MATERIA PRIMA
    public function indexMateriaPrima()
    {
        $planta = Planta::where('tipo_planta', '1')->where('activo', '1')->get();

        return view('main_views.materia_prima.homeMateriaPrima', compact('planta'));
    }

    public function materiaPrimaTabla(Request $request)
    {
        $data = MateriaPrima::select('materia_prima.id', 'materia_prima.nombre AS nombre_materia_prima', 'medida', 'cantidad_minima', 
                                     'p.nombre AS planta')
                            ->join('planta AS p', 'p.id', 'materia_prima.planta_id')
                            ->whereNull('materia_prima.deleted_at')
                            ->where('p.activo', '1');

        if ($request->planta == '')
        {
            $data = $data->get();
        } else {
            $data = $data->where('materia_prima.planta_id', $request->planta)->get();
        }

        return DataTables::of($data)->make(true);
    }        

    public function storeMateriaPrima(Request $request)
    {
        //
        DB::beginTransaction();
        
        $data = new MateriaPrima();
        $data->nombre = $request->nombreMateriaPrima;
        $data->cantidad_minima = $request->cantMinima;
        $data->medida = $request->medida; 
        $data->planta_id = $request->planta_save;
        $MateriaPrimaSave = $data->save();

        if ($MateriaPrimaSave)
        {
            DB::commit();
            return 'success';
        } else {
            DB::rollBack();
            return 'failed';
        }
    }

    public function showMateriaPrima(Request $MateriaPrima)
    {
        //
        $MateriaPrima = MateriaPrima::where('id', $MateriaPrima->idMateriaPrima)->first();
        $planta = Planta::where('tipo_planta', '1')->where('activo', '1')->get();

        return view('main_views.materia_prima.editarMateriaPrima', compact('MateriaPrima', 'planta'));
    }

    public function updateMateriaPrima(Request $request)
    {
        //
        DB::beginTransaction();
        
        $data = MateriaPrima::find($request->idMateriaPrima);
        $data->nombre = $request->nombreMateriaPrima;
        $data->medida = $request->medida;
        $data->cantidad_minima = $request->cantMinima;
        $data->planta_id = $request->planta;
        $materiaUpdate = $data->save();

        if ($materiaUpdate)
        {
            DB::commit();
            return 'success';
        } else {
            DB::rollBack();
            return 'failed';
        }
    }

    public function destroyMateriaPrima(Request $request)
    {
        //
        $data = MateriaPrima::find($request->idMateriaPrima);
        //$data = true;
        $data->delete();

        return 'success';
    }
    //Fin de manejo de MATERIA PRIMA

    /****************************************************************/

    //Inicio de manejo de PRODUCCION de PRODUCTOS
    public function indexProduccion()
    {
        $planta = Planta::where('tipo_planta', '2')->where('activo', '1')->get();
        $materiaPrima = MateriaPrima::whereNull('deleted_at')->get();

        return view('main_views.produccion.homeProduccion', compact('planta', 'materiaPrima'));
    }

    public function materiaPrimaDisponible(Request $request)
    {
        $materia_disponible = MateriaPrima::select(DB::raw('ROUND(COALESCE(cantidad_entrada,0) - COALESCE(cantidad_utilizada,0),2) AS disponible'))
                                            ->leftJoin('detalle_produccion AS b', 'b.materia_prima_id','materia_prima.id')
                                            ->whereNull('materia_prima.deleted_at')
                                            ->whereNull('b.deleted_at')
                                            ->groupBy('materia_prima.id','materia_prima.planta_id')
                                            ->first();

        return view('main_views.produccion.materiaPrimaDisponible', compact('materia_disponible'));
    }

    public function buscarProducto(Request $request)
    {
        $param = "%$request->producto%";
        $param = str_replace(' ', "%", $param);

        $query = Producto::select('producto.id','producto.nombre', 'valor_unitario', DB::raw('(producto.stock - COALESCE(td.stock,0)) AS stock'), 'descripcion')
                            ->leftJoin(DB::raw('(
                                SELECT idproducto, SUM(cantidad) AS stock
                                FROM temporal_detalle
                                GROUP BY idproducto
                            ) AS td'), function($join)
                            {
                                $join->on('td.idproducto','producto.id');
                            }) 
                            ->whereNull('deleted_at')
                            ->where(function ($q) use ($param){
                                $q->where('nombre', 'like', $param);
                                $q->orWhere('descripcion', 'like', $param);
                                $q->orWhere('id', 'like', $param);
                            })
                            ->distinct()
                            ->groupBy('id','nombre')
                            ->orderBy('nombre')
                            ->get();

        $c = $query->count();

        if ($query->count() > 0)
        {     
            $response = array();
            foreach($query as $value){
                $response[] = array(
                    'value' => $value->id,
                    'label' => $value->nombre,
                    'precio' => $value->valor_unitario,
                    'descripcion' => $value->descripcion,
                    'stock' => $value->stock);
            }

            return response()->json($response);
        } else {
            $c = 0;
        }

        if ($c == 0)
        {
            $response[] = array(
                'value' => '',
                'label' => 'Producto no existe, conserve el nombre escrito.');
        }

        return response()->json($response);
    }

    public function selectPlantaProducto(Request $request)
    {
        $planta = Planta::where('tipo_planta', '2')->where('activo', '1')->get();
        $productoInfo = Produccion::where('producto_id', $request->idProducto)->first();

        return view('main_views.produccion.currentPlantaProducto', compact('planta', 'productoInfo'));
    }

    public function produccionTabla()
    {
        $data = Producto::select('producto.id', 'producto.nombre', 'producto.descripcion', 'valor_unitario',
                                DB::raw('(producto.stock - COALESCE(td.stock,0)) AS stock'))
                        ->leftJoin(DB::raw('(
                            SELECT idproducto, SUM(cantidad) AS stock
                            FROM temporal_detalle
                            GROUP BY idproducto
                        ) AS td'), function($join)
                        {
                            $join->on('td.idproducto','producto.id');
                        })
                        ->whereNull('deleted_at')->get();

        return DataTables::of($data)->make(true);
    }

    public function cargarGuardarProducto()
    {
        $planta = Planta::where('tipo_planta', '2')->where('activo', '1')->get();
        $materiaPrima = MateriaPrima::whereNull('deleted_at')->get();

        return view('main_views.produccion.guardarProduccion', compact('planta', 'materiaPrima'));
    }

    public function storeProduccion(Request $request)
    {
        DB::beginTransaction();

        if (is_null($request->idproducto)) //Producto nuevo
        {
            $producto = new Producto();
            $producto->nombre = $request->producto;
            $producto->descripcion = $request->descripcion;
            $producto->valor_unitario = $request->precio;
            $producto->stock = $request->cantidad;
            $saveProducto = $producto->save();

            if ($saveProducto)
            {
                $produccion = new Produccion();
                $produccion->producto_id = $producto->id;
                $produccion->cantidad_producida = $request->cantidad;
                $produccion->planta_produccion_id = $request->planta_produccion;
                $produccion->ingresado_por = Auth::user()->id;
                $saveProduccion = $produccion->save();

                if ($saveProduccion)
                {
                    foreach ($request->detallMateria as $value) 
                    {
                        $detalleProduccion = new DetalleProduccion();
                        $detalleProduccion->producto_id = $producto->id;
                        $detalleProduccion->materia_prima_id = $value['idmateria'];
                        $detalleProduccion->cantidad_utilizada = $value['cantidad_utilizada'];
                        $saveDetalle = $detalleProduccion->save();
                    }
                }
            }

            if ($saveDetalle)
            {
                DB::commit();

                return 'success';
            } else {
                DB::rollBack();

                return 'error';
            }

        } else { // Actualziar produccion de producto existente
            $producto = Producto::find($request->idproducto);
            $producto->nombre = $request->producto;
            $producto->descripcion = $request->descripcion;
            $producto->valor_unitario = $request->precio;

            $newStock = $producto->stock + $request->cantidad;
            $producto->stock = $newStock;

            $saveProducto = $producto->save();

            if ($saveProducto)
            {
                $produccion = new Produccion();
                $produccion->producto_id = $request->idproducto;
                $produccion->cantidad_producida = $request->cantidad;
                $produccion->planta_produccion_id = $request->planta_produccion;
                $saveProduccion = $produccion->save();

                if ($saveProduccion)
                {
                    foreach ($request->detallMateria as $value) 
                    {
                        $detalleProduccion = new DetalleProduccion();
                        $detalleProduccion->producto_id = $value['idproducto'];
                        $detalleProduccion->materia_prima_id = $value['idmateria'];
                        $detalleProduccion->cantidad_utilizada = $value['cantidad_utilizada'];
                        $saveDetalle = $detalleProduccion->save();
                    }
                }
            }

            if ($saveDetalle)
            {
                DB::commit();

                return 'success';
            } else {
                DB::rollBack();

                return 'error';
            }
        }
    }

    public function destroyProduccion(Request $request)
    {
        $data = Producto::find($request->idProducto);
        $data->delete();

        return 'success';
    }

    public function showProduccion(Request $request)
    {
        $producto = Producto::find($request->idProducto);

        return view('main_views.produccion.editarProducto', compact('producto'));
    }

    public function updateProducto(Request $request)
    {
        $producto = Producto::find($request->idProducto);

        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->valor_unitario = $request->precio;
        $producto->save();

        return 'success';
    }

    //Fin de manejo de PRODUCCION de PRODUCTOS 

}
