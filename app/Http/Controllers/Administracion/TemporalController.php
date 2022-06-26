<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Temporal;
use App\Models\Administracion\Ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemporalController extends Controller
{
    public function temporal(Request $request)
    {
        $tempOrden = new Ventas();

        $tempOrden->cliente_id  = $request->idcliente;
        $tempOrden->empleado_id = Auth::user()->empid;
        $tempOrden->activo = null;
        $tempOrden->save();

        return $tempOrden->id;
    }

    public function detalleTemp(Request $request)
    {
        $detalleTem = new Temporal();

        $detalleTem->idproducto = $request->idproducto;
        $detalleTem->cantidad   = $request->cantidad;
        $detalleTem->idorden    = $request->idordenTemp;
        $detalleTem->idcliente  = $request->idcliente;
        $detalleTem->save();
    }

    public function borrarPendiente(Request $request)
    {
        $orden = Ventas::where('id', $request->idorden)->forcedelete();
        $tempDetalle = Temporal::where('idorden', $request->idorden)->forcedelete();
    }
}
