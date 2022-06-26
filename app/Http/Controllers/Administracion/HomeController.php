<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Empleado;
use App\Models\Administracion\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rols = Rol::all();

        return view('welcome', compact('rols'));
    }

    public function usuariosTabla()
    {
        $data = User::select('users.id', 'empid', 'name', 'email', 'rol',
                            DB::raw('DATE_FORMAT(users.created_at, "%d-%m-%Y") AS fecha_creacion'),
                            DB::raw('CONCAT_WS(" ", primer_nombre, primer_apellido) AS creado_por'))
                            ->join('rol AS r', 'r.id','users.rol_id')
                            ->join('empleado AS e', 'e.id','users.creado_por')
                            ->where('users.activo', '1')
                            ->get();

        return DataTables::of($data)->make(true);
    }

    public function homeUsuario()
    {
        //
        $rol = Rol::all();
        
        return view('main_views.administrador.homeUsuario', compact('rol'));
    }

    public function buscarEmpleado(Request $request)
    {
        $param = "%$request->search%";
        $param = str_replace(' ', "%", $param);

        $query = Empleado::withTrashed()->select('empleado.id', 'puesto', 'fecha_ingreso',
                            DB::raw('CONCAT_WS(" ", primer_nombre, primer_apellido) as name'),
                            DB::raw('CONCAT_WS(" ", primer_nombre, segundo_nombre, tercer_nombre, primer_apellido, segundo_apellido) AS full_name'),
                            DB::raw('LOWER(CONCAT(primer_nombre,".",primer_apellido,empleado.id,"@transport.com")) AS usuario'))
                            ->join('empleado_employment AS ee', 'ee.empleado_id', 'empleado.id')
                            ->where('activo', '1')
                            ->where(function ($q) use ($param){
                                $q->whereRaw('CONCAT_WS(" ", primer_nombre, segundo_nombre, tercer_nombre, primer_apellido, segundo_apellido) like ?', $param);
                                $q->orWhere('empleado.id', 'like', $param);
                            })
                            ->distinct()
                            ->groupBy('empleado.id')
                            ->orderBy('empleado.id')
                            ->get();

        $c = $query->count();

        if ($query->count() > 0)
        {
            $response = array();
            foreach($query as $value){
                $response[] = array(
                    'value' => $value->id,
                    'label' => $value->full_name,
                    'puesto' => $value->puesto,
                    'fecha_ingreso' => $value->fecha_ingreso,
                    'usuario' => $value->usuario,
                    'name' => $value->name);
            }

            return response()->json($response);
        } else {
            $c = 0;
        }

        if ($c == 0)
        {
            $response[] = array(
                'value' => '',
                'label' => 'Empleado no encontrado');
        }

        return response()->json($response);
    }

    public function guardarUsuario(Request $request)
    {
        $password = 'secret';
        $empid = Auth::user()->empid;
        
        $usuarioActivo = User::where('empid', $request->idempleado)->get();

        if (sizeof($usuarioActivo) > 0)
        {
            return 'activo';
        } else {
            DB::beginTransaction();

            $data = new User();

            $data->name = $request->name;
            $data->empid = $request->idempleado;
            $data->email = $request->usuario;
            $data->password = Hash::make($password);
            $data->rol_id = $request->rol;
            $data->creado_por = $empid;
            $data->activo = 1;
            $dataSave = $data->save();

            if ($dataSave)
            {
                DB::commit();
                return 'exito';
            } else {
                DB::rollBack();
                return 'error';
            }
        }
    } 

    public function eliminarUsuario(Request $request)
    {
        $user = User::where('id', $request->iduser)->forcedelete();

        return 'success';
    }

    public function resetPassword(Request $request)
    {
        $password = 'secret';

        $data = User::find($request->iduser);

        $data->password = Hash::make($password);
        $dataSave = $data->save();

        return 'success';
    }

    public function actualizarPassword(Request $request)
    {
        $empid = Auth::user()->empid;
        $userid = User::select('id as iduser')
                        ->where('activo', '1')
                        ->where('empid', $empid)
                        ->first();

        $contraseña = $request->confirma;

        $data = User::find($userid->iduser);
        $data->password = Hash::make($contraseña); 
        $data->save();

        return 'exito';
    }
}
