<?php

namespace App\Http\Controllers\Plantas;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Departamento;
use App\Models\Administracion\RolNegocio;
use App\Models\Plantas\Planta;
use App\Models\Plantas\Ubicaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables;

class PlantasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rolNegocio = RolNegocio::all();
        $deptos = Departamento::all();

        return view('main_views.plantas.homePlantas', compact('rolNegocio', 'deptos'));
    }

    public function homeUbicaciones()
    {
        $rolNegocio = RolNegocio::all();
        $deptos = Departamento::all();

        return view('main_views.plantas.tableUbicaciones', compact('rolNegocio', 'deptos'));
    }

    public function tablaUbicaciones(Request $request)
    {
        $data = Ubicaciones::select('ubicaciones_planta.id', 'negocio', 'departamento', 'municipio')
                            ->join('departamento as d', 'd.id', 'ubicaciones_planta.departamento_id')
                            ->join('municipio as m', 'm.id', 'ubicaciones_planta.municipio_id')
                            ->join('rol_negocio as n', 'n.id', 'ubicaciones_planta.rol_negocio')
                            ->where('ubicaciones_planta.activo','1');

        if ($request->negocio == '')
        {
            $data = $data->get();
        } else {
            $data = $data->where('ubicaciones_planta.rol_negocio', $request->negocio)->get();
        }

        return DataTables::of($data)->make(true);
    }

    public function storeUbicacion(Request $request)
    {
        $data = new Ubicaciones();
        $data->rol_negocio = $request->negocio;
        $data->departamento_id = $request->departamento_id;
        $data->municipio_id = $request->municipio;
        $data->save();

        return 'exito';
        
    }

    public function deleteUbicacion(Request $request)
    {
        $data = Ubicaciones::find($request->idUbicacion);
        $data->activo = 0;
        $data->save();

        return 'exito';
    }

    public function selectMunicipioUbicacion(Request $request)
    {
        $municipios = Departamento::find($request->deptoid)->getMunicipio;

        return view('layouts.ubicacionesMunicipio', compact('municipios'));
    }

    public function ubicacionesPlanta(Request $request)
    {
        $ubicaciones = Ubicaciones::select('ubicaciones_planta.id',
                                            DB::raw('CONCAT_WS(" - ", departamento, municipio) AS ubicacion'))
                                    ->join('departamento as d', 'd.id', 'ubicaciones_planta.departamento_id')
                                    ->join('municipio as m', 'm.id', 'ubicaciones_planta.municipio_id')
                                    ->where('ubicaciones_planta.rol_negocio', $request->rol_negocio)
                                    ->where('ubicaciones_planta.activo', '1')
                                    ->get();

        return view('layouts.ubicacionesPlanta', compact('ubicaciones'));
    }

    public function plantasTable(Request $request)
    {
        $data = Planta::select('planta.id', 'nombre', 'telefono', 'correo', 'zona', 'negocio as rol_negocio',
                                DB::raw('CONCAT_WS(" - ", d.departamento, m.municipio) AS ubicacion'))
                        ->join('ubicaciones_planta AS up', 'up.id', 'planta.ubicaciones_planta_id')
                        ->join('departamento as d', 'd.id', 'up.departamento_id')
                        ->join('municipio as m', 'm.id', 'up.municipio_id')
                        ->join('rol_negocio as n', 'n.id', 'planta.tipo_planta')
                        ->where('planta.activo', '1');

        if ($request->negocio == '')
        {
            $data = $data->get();
        } else {
            $data = $data->where('planta.tipo_planta', $request->negocio)->get();
        }

        return DataTables::of($data)->make(true);
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
        $data = new Planta();
        $data->nombre = $request->nombre;
        $data->telefono = $request->telefono;
        $data->correo = $request->correo;
        $data->direccion = $request->direccion;
        $data->zona = $request->zona;
        $data->ubicaciones_planta_id = $request->ubicacion_id;
        $data->tipo_planta = $request->negocio;
        $data->save();

        return 'exito';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $rolNegocio = RolNegocio::all();
        $deptos = Departamento::all();
        $data = Planta::where('id', $request->idPlanta)->first();
        $ubicaciones = Ubicaciones::select('ubicaciones_planta.id',
                                            DB::raw('CONCAT_WS(" - ", departamento, municipio) AS ubicacion'))
                                    ->join('departamento as d', 'd.id', 'ubicaciones_planta.departamento_id')
                                    ->join('municipio as m', 'm.id', 'ubicaciones_planta.municipio_id')
                                    ->where('ubicaciones_planta.rol_negocio', $data->tipo_planta)
                                    ->where('ubicaciones_planta.activo', '1')
                                    ->get();

        return view('main_views.plantas.editarPlantas', compact('rolNegocio', 'deptos', 'data', 'ubicaciones'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $data = Planta::find($request->idPlanta);
        $data->nombre = $request->nombre;
        $data->telefono = $request->telefono;
        $data->correo = $request->correo;
        $data->direccion = $request->direccion;
        $data->zona = $request->zona;
        $data->ubicaciones_planta_id = $request->ubicacion_id;
        $data->tipo_planta = $request->negocio;
        $data->save();
        
        return 'exito';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $data = Planta::find($request->idPlanta);
        $data->activo = 0;
        $data->save();
        $data->delete();
        
        return 'exito';
    }
}
