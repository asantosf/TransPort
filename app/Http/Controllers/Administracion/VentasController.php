<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Clientes;
use App\Models\Administracion\DetalleOrden;
use App\Models\Administracion\Lote;
use App\Models\Administracion\MetodoPago;
use App\Models\Administracion\Producto;
use App\Models\Administracion\Temporal;
use App\Models\Administracion\Ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class VentasController extends Controller
{
    public function index()
    {
        //
        $metodo_pago = MetodoPago::all();

        return view('main_views.ventas.homeVentas', compact('metodo_pago'));
    }

    public function validaNIT(Request $request)
    {

        $param = "%$request->search%";
        $param = str_replace(' ', "%", $param);

        $query = Clientes::withTrashed()->select('cliente.id AS idcliente_','nombre_cliente', 'no_tributario', 'direccion')
                            ->where('activo', '1')
                            ->where(function ($q) use ($param){
                                $q->where('nombre_cliente', 'like', $param);
                                $q->orWhere('no_tributario', 'like', $param);
                                $q->orWhere('telefono', 'like', $param);
                            })
                            ->distinct()
                            ->groupBy('cliente.id')
                            ->orderBy('nombre_cliente')
                            ->get();

        $c = $query->count();

        if ($query->count() > 0)
        {
            $ordenPendiente = Ventas::where('cliente_id', $query[0]->idcliente_)
                                        ->whereNull('total')->get();
                                       
            if (sizeof($ordenPendiente) > 0)
            {
                $idOrdenPend = $ordenPendiente[0]->id;
            } else {
                $idOrdenPend = 0;
            }

            $response = array();
            foreach($query as $value){
                $response[] = array(
                    'value' => $value->idcliente_,
                    'label' => $value->nombre_cliente,
                    'nit' => $value->no_tributario,
                    'direccion' => $value->direccion,
                    'orden_pendiente' => $idOrdenPend);
            }

            return response()->json($response);
        } else {
            $c = 0;
        }

        if ($c == 0)
        {
            $response[] = array(
                'value' => 3,
                'label' => 'Cliente no encontrado, click para crear.',
                'nit' => $request->search);
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        //
        DB::beginTransaction();

        $idCliente = $request->idcliente;

        if ($idCliente == 3)
        {
            $nuevoCliente = new Clientes();
            $nuevoCliente->no_tributario = $request->nuevoNit;
            $nuevoCliente->nombre_cliente = $request->cliente;
            $nuevoCliente->direccion = $request->direccion;
            $nuevoCliente->save();

            $idCliente = $nuevoCliente->id;
        } 

        $factura = Ventas::find($request->idorden);
        $factura->total = $request->total;
        $factura->cliente_id = $idCliente;
        $factura->empleado_id = Auth::user()->empid;
        $factura->metodo_pago_id = $request->metodo_pago;
        $facturaUpdate = $factura->save();

        if ($facturaUpdate)
        {
            foreach ($request->detallOrden as $value) 
            {
                $facturaOrden = new DetalleOrden();
                
                $facturaOrden->factura_id = $request->idorden;
                $facturaOrden->producto_id = $value['idproducto'];
                $facturaOrden->cantidad = $value['cantidad'];
                $facturaOrden->precio = $value['precio'];
                $detalleSave = $facturaOrden->save();

                if ($detalleSave)
                {
                    $updateStock = Producto::find($value['idproducto']);
                    $updateStock->stock = ($updateStock->stock - $value['cantidad']);
                    $saveFinal = $updateStock->save();
                }
            }
        }

        if ($saveFinal)
        {
            //$tempDetalle = Temporal::where('idorden', $request->idorden)->forcedelete();
            DB::commit();
            return 'success';
        } else {
            DB::rollBack();
            return 'fail';
        }
    }

    public function getReportView()
    {
        return view('main_views.ventas.reporteVentas');
    }

    public function tablaVentas(Request $request)
    {
        $desde = $request->desde;
        $hasta = $request->hasta;
        $estado = $request->estado;

        $query = Ventas::select('factura.id AS idorden', 'nombre_cliente', 'c.no_tributario AS nit', 'total',
                            DB::raw('CONCAT_WS(" ",primer_nombre, primer_apellido) AS creado_por'),
                            DB::raw('
                            CASE
                                WHEN factura.activo = 1 THEN "Procesada"
                                WHEN factura.activo = 2 THEN "Devolución"
                                WHEN factura.activo IS NULL THEN "Cancelada"
                            END AS estado'),
                            DB::raw('DATE_FORMAT(factura.created_at, "%d-%m-%Y") AS fecha_orden'))
                        ->join('cliente AS c', 'c.id','factura.cliente_id')
                        ->join('empleado AS e', 'e.id','factura.empleado_id');

        if ($desde == '' && $hasta == '' && $estado == '')
        {
            //dump('a');
            $data = $query->get();

        } else if ($desde != '' && $hasta != '' && $estado == '') {
            //dump('b');
            $data = $query->whereRaw('factura.created_at BETWEEN ? AND ? + INTERVAL 1 DAY', [$desde, $hasta])
                        ->get();

        } else if ($desde != '' && $hasta != '' && $estado != '') {
            //dump('c');
            if ($estado == 'nulo')
            {
                $data = $query->whereRaw('factura.created_at BETWEEN ? AND ? + INTERVAL 1 DAY', [$desde, $hasta])
                        ->whereNull('factura.activo')
                        ->get();
            } else {
                $data = $query->whereRaw('factura.created_at BETWEEN ? AND ? + INTERVAL 1 DAY', [$desde, $hasta])
                        ->where('factura.activo', $estado)
                        ->get();
            }
        } else if ($desde == '' && $hasta == '' && $estado != '') {
            //dump('d');
            if ($estado == 'nulo')
            {
                $data = $query->whereNull('factura.activo')
                        ->get();
            } else {
                $data = $query->where('factura.activo', $estado)
                        ->get();
            }
        }

        return DataTables::of($data)->make(true);
    }
    
    public function orderDetail(Request $request)
    {
        $detalle = DetalleOrden::select('producto_id', 'descripcion', 'detalle_factura.cantidad', 'precio',
                                        DB::raw('ROUND(detalle_factura.cantidad * precio,2) AS subtotal'))
                                    ->join('producto AS p', 'p.id','detalle_factura.producto_id')
                                    ->where('factura_id', $request->idorden)
                                    ->get();
        
        $devolucion = Ventas::where('id', $request->idorden)->first();

        return view('main_views.ventas.detalleOrden', compact('detalle', 'devolucion'));
                                    
    }

    public function finalizarOrden(Request $request)
    {
        $orden = Ventas::where('id', $request->idorden)->forcedelete();
        $tempDetalle = Temporal::where('idorden', $request->idorden)->forcedelete();
    }

    public function devolucionOrdenView(Request $request)
    {
        $query = Ventas::select('factura.id AS idorden', 'nombre_cliente', 'c.no_tributario AS nit', 'total',
                            DB::raw('DATE_FORMAT(factura.created_at, "%d-%m-%Y") AS fecha_orden'))
                        ->join('cliente AS c', 'c.id','factura.cliente_id')
                        ->where('factura.id', $request->idorden)
                        ->first();
        
        return view('main_views.ventas.devolucion', compact('query'));
    }

    public function devolucionOrden(Request $request)
    {
        $devueltoPor = Auth::user()->name;
        $idorden = $request->idorden;
        $comentarios = $request->comentarios;
        $texto = "Orden devuelta por: ".$devueltoPor.".\n\nRazon de devolución:\n ".$comentarios;

        $data = Ventas::find($idorden);
        $data->activo = 2;
        $data->comentarios = $texto;
        $data->save();

        return 'success';

    }

    public function removerUlitmo(Request $request)
    {
        if ($request->tipo == 1)
        {
            $removeLast = Temporal::where('idorden', $request->idorden)
                                ->groupBy('id', 'idproducto', 'idcliente', 'cantidad')
                                ->orderBy('id', 'DESC')
                                ->forcedelete();
        } else {
            $removeLast = Temporal::where('idorden', $request->idorden)
                                ->groupBy('id', 'idproducto', 'idcliente', 'cantidad')
                                ->orderBy('id', 'DESC')
                                ->first()
                                ->forcedelete();
        }
        
        return true;
    }
}
