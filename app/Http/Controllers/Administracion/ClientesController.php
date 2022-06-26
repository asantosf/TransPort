<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Clientes;
use App\Models\Administracion\Departamento;
use App\Models\Administracion\Municipio;
use App\Models\Administracion\Ventas;
use Facade\FlareClient\Http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscarCliente(Request $request)
    {

        $param = "%$request->search%";
        $param = str_replace(' ', "%", $param);

        $query = Clientes::withTrashed()->select('cliente.id AS idcliente_','nombre_comercial', 'nit', 'telefono',
                            DB::raw('CONCAT(nombre_comercial, ", ", departamento, ", ", municipio, ", ", "zona ", zona) AS munDep'))
                            ->join('departamento AS d', 'd.id','cliente.departamento_id')
                            ->join('municipio AS m', 'm.id','cliente.municipio_id')
                            ->where('activo', '1')
                            ->where(function ($q) use ($param){
                                $q->where('nombre_comercial', 'like', $param);
                                $q->orWhere('nit', 'like', $param);
                                $q->orWhere('telefono', 'like', $param);
                            })
                            ->distinct()
                            ->groupBy('cliente.id', 'nombre_comercial', 'nit', 'departamento', 'municipio', 'zona', 'telefono')
                            ->orderBy('nombre_comercial')->get();

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
                    'label' => $value->munDep,
                    'nit' => $value->nit,
                    'nombre_comercial' => $value->nombre_comercial,
                    'telefono' => $value->telefono,
                    'orden_pendiente' => $idOrdenPend);
            }

            return response()->json($response);
        } else {
            $c = 0;
        }

        if ($c == 0)
        {
            $response[] = array(
                'value' => '',
                'label' => 'Cliente no encontrado');
        }

        return response()->json($response);
    }

    public function index()
    {
        //
        $deptos = Departamento::all();
        
        return view('main_views.clientes.homeClientes', compact('deptos'));
    }

    public function selectMunicipio(Request $request)
    {
        $municipios = Departamento::find($request->deptoid)->getMunicipio;

        return view('layouts.municipioSelected', compact('municipios'));
    }

    public function clientesTabla()
    {
        $clientes = Clientes::whereNotIn('id', [2,3])->get();

        return DataTables::of($clientes)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        DB::beginTransaction();

        $data = new Clientes();

        $data->nombre_cliente= $request->nombre_comercial;
        $data->representante = $request->intermediario;
        $data->no_tributario = $request->nit;
        $data->telefono = $request->telefono;
        $data->correo = $request->correo;
        $data->direccion = $request->direccion;
        $data->zona = $request->zona;
        $data->departamento_id = $request->departamento_id;
        $data->municipio_id = $request->municipio_id;
        $saveCliente = $data->save();

        if ($saveCliente)
        {
            DB::commit();
            return 'exito';
        } else {
            DB::rollBack();
            return 'error';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bakery\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show(Request $clientes)
    {
        //
        $cliente = Clientes::where('id', $clientes->idCliente)->first();
        $munClinete = Municipio::where('departamento_id', $cliente->departamento_id)->get();
        $deptos = Departamento::all();

        return view('main_views.clientes.editarCliente', compact('cliente', 'deptos', 'munClinete'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bakery\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function edit(Clientes $clientes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bakery\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        DB::beginTransaction();

        $data = Clientes::find($request->id);

        $data->nombre_cliente = $request->nombre_comercial;
        $data->representante = $request->intermediario;
        $data->no_tributario = $request->nit;
        $data->telefono = $request->telefono;
        $data->correo = $request->correo;
        $data->direccion = $request->direccion;
        $data->zona = $request->zona;
        $data->departamento_id = $request->departamento_id;
        $data->municipio_id = $request->municipio_id;
        $updateCliente = $data->save();

        if ($updateCliente)
        {
            DB::commit();
            return 'exito';
        } else {
            DB::rollBack();
            return 'error';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bakery\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $clientes)
    {
        //
        $data = Clientes::find($clientes->idCliente);
        $data->delete();

        return 'success';
    }
}
