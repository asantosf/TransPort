<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Departamento;
use App\Models\Administracion\Empleado;
use App\Models\Administracion\EmpleadoEmployment;
use App\Models\Administracion\Municipio;
use App\Models\Administracion\RolNegocio;
use App\Models\Plantas\Planta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $deptos = Departamento::all();

        $negocios = Planta::where('activo', '1')->get();

        return view('main_views.empleados.homeEmpleado', compact('deptos', 'negocios') );
    }

    public function empleadoTabla()
    {
        $data = Empleado::select('empleado.id', DB::raw('CONCAT_WS(" ", primer_nombre, segundo_nombre, primer_apellido, segundo_apellido) AS full_name'),
                                'no_identificacion', 'empleado.telefono', 'fecha_ingreso', 'p.nombre AS planta', DB::raw('CONCAT_WS(" - ", d.departamento, m.municipio) AS ubicacion'))
                        ->join('empleado_employment AS ee', 'ee.empleado_id', 'empleado.id')
                        ->join('planta AS p', 'p.id', 'ee.planta_id')
                        ->join('ubicaciones_planta AS up', 'up.id', 'p.ubicaciones_planta_id')
                        ->join('departamento as d', 'd.id', 'up.departamento_id')
                        ->join('municipio as m', 'm.id', 'up.municipio_id')
                        ->whereNull('efectivo_hasta')
                        ->where('empleado.activo','1')
                        ->get();

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
        DB::beginTransaction();

        $data = new Empleado();

        $data->primer_nombre = $request->primer_nombre;
        $data->segundo_nombre = $request->segundo_nombre;
        $data->tercer_nombre = $request->tercer_nombre;
        $data->primer_apellido = $request->primer_apellido;
        $data->segundo_apellido = $request->segundo_apellido;
        $data->apellido_casada = $request->apellido_casada;
        $data->no_identificacion = $request->dpi;
        $data->no_tributario = $request->nit;
        $data->telefono = $request->telefono;
        $data->fecha_ingreso = $request->fecha_ingreso;
        $data->direccion = $request->direccion;
        $data->zona = $request->zona;
        $data->departamento_id = $request->departamento_id;
        $data->municipio_id = $request->municipio_id;
        $data->activo = 1;
        $saveEmpleado = $data->save();

        if ($saveEmpleado)
        {
            $employment = new EmpleadoEmployment();
            $employment->effectivo_desde = $request->fecha_ingreso;
            $employment->puesto = $request->puesto;
            $employment->empleado_id = $data->id;
            $employment->planta_id = $request->negocio;
            $saveEmployment = $employment->save();
        }

        if ($saveEmployment)
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
     * @param  \App\Models\Bakery\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $empleado = Empleado::where('id', $request->idEmpleado)->first();
        $munEmpleado = Municipio::where('departamento_id', $empleado->departamento_id)->get();
        $deptos = Departamento::all();
        $negocios = Planta::where('activo', '1')->get();
        $employment = EmpleadoEmployment::where('empleado_id', $empleado->id)->first();
        
        return view('main_views.empleados.editarEmpleado', compact('empleado', 'deptos', 'munEmpleado', 'negocios', 'employment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bakery\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleado $empleado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bakery\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        DB::beginTransaction();

        $data = Empleado::find($request->id);

        $data->primer_nombre = $request->primer_nombre;
        $data->segundo_nombre = $request->segundo_nombre;
        $data->tercer_nombre = $request->tercer_nombre;
        $data->primer_apellido = $request->primer_apellido;
        $data->segundo_apellido = $request->segundo_apellido;
        $data->apellido_casada = $request->apellido_casada;
        $data->no_identificacion = $request->dpi;
        $data->no_tributario = $request->nit;
        $data->telefono = $request->telefono;
        $data->fecha_ingreso = $request->fecha_ingreso;
        $data->direccion = $request->direccion;
        $data->zona = $request->zona;
        $data->departamento_id = $request->departamento_id;
        $data->municipio_id = $request->municipio_id;
        $saveEmpleado = $data->save();

        if ($saveEmpleado)
        {
            $findEmployment = EmpleadoEmployment::where('empleado_id', $request->id)->first();

            $employment = EmpleadoEmployment::find($findEmployment->id);
            $employment->effectivo_desde = $request->fecha_ingreso;
            $employment->puesto = $request->puesto;
            $employment->empleado_id = $data->id;
            $employment->planta_id = $request->negocio;
            $saveEmployment = $employment->save();
        }

        if ($saveEmployment)
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
     * @param  \App\Models\Bakery\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $empleado)
    {
        //
        $data = Empleado::find($empleado->idEmpleado);
        $data->activo = 0;
        $data->save();
        $data->delete();

        return 'success';
    }
}
