<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use function PHPUnit\Framework\isNull;

class LoteController extends Controller
{

    public function index()
    {
        return view('main_views.lotes.homeLotes');
    }

    public function loteTabla(Request $request)
    {
        //
        $desde = $request->desde;
        $hasta = $request->hasta;

        if ($desde == '' && $hasta == '')
        {
            $lote = Lote::select('lote.id', 'fecha_produccion', 'fecha_vencimiento', 'descripcion',
                    DB::raw('lote.cantidad - COALESCE(SUM(dor.cantidad),0) - COALESCE(SUM(coc.cantidad),0) AS cantidad'),
                    DB::raw('DATE_FORMAT(fecha_vencimiento, "%d-%m-%Y") AS vencimiento'))
                    ->leftJoin('detalle_orden AS dor', 'dor.lote_id','lote.id')
                    ->leftJoin('cant_orden_control AS coc', 'coc.idlote','lote.id')
                    ->groupBy('lote.cantidad', 'fecha_vencimiento', 'lote.id', 'fecha_produccion', 'fecha_vencimiento', 'descripcion')
                    ->get();
        } else {
            $lote = Lote::select('lote.id', 'fecha_produccion', 'fecha_vencimiento', 'descripcion',
                    DB::raw('lote.cantidad - COALESCE(SUM(dor.cantidad),0) - COALESCE(SUM(coc.cantidad),0) AS cantidad'),
                    DB::raw('DATE_FORMAT(fecha_vencimiento, "%d-%m-%Y") AS vencimiento'))
                    ->leftJoin('detalle_orden AS dor', 'dor.lote_id','lote.id')
                    ->leftJoin('cant_orden_control AS coc', 'coc.idlote','lote.id')
                    ->whereRaw('lote.fecha_produccion BETWEEN ? AND ? + INTERVAL 1 DAY', [$desde, $hasta])
                    ->groupBy('lote.cantidad', 'fecha_vencimiento', 'lote.id', 'fecha_produccion', 'fecha_vencimiento', 'descripcion')
                    ->get();
        }
                
        return DataTables::of($lote)->make(true);
    }

    public function store(Request $request)
    {
        //

        $validacion = Lote::where('id', $request->noLote)->get();

        if (sizeof($validacion) > 0)
        {
            return 'existe';
        } else {
            DB::beginTransaction();
        
            $data = new Lote();
            $data->id = $request->noLote;
            $data->fecha_produccion = $request->MyDate;
            $data->fecha_vencimiento = $request->MyDate3;
            $data->cantidad = $request->cant;
            $data->control_calidad = $request->calidad;
            $data->descripcion = $request->descripcion;
            $loteSave = $data->save();

            if ($loteSave)
            {
                DB::commit();
                return 'success';
            } else {
                DB::rollBack();
                return 'failed';
            }

        }
    }

    public function show(Request $request)
    {
        //
        $lote = Lote::where('id', $request->idlote)->first();

        return view('main_views.lotes.editarLote', compact('lote'));
    }

    public function update(Request $request)
    {
        //
        DB::beginTransaction();
        
        $data = Lote::find($request->idlote);
        $data->cantidad = $request->cant_;
        $data->control_calidad = $request->calidad_;
        $data->descripcion = $request->descripcion_;
        $loteUpdate = $data->save();

        if ($loteUpdate)
        {
            DB::commit();
            return 'success';
        } else {
            DB::rollBack();
            return 'failed';
        }
    }

    public function destroy(Request $request)
    {
        //
        DB::beginTransaction();

        $data = Lote::find($request->idLote);
        if ($data->id == $request->idLote)
        {
            $data_ = Lote::withTrashed()->whereNotNull('deleted_at')->orderBy('id', 'desc')->limit(1)->get();
            
            if (sizeof($data_) > 0) 
            {                
                $delID_ = $data_[0]->id + 1;
            }
        }
        $data->id = $delID_;
        $data->descripcion = $data->descripcion." No lote al eliminar = ".$request->idLote;
        $dataSave = $data->save();
        $data->delete();

        if ($dataSave)
        {
            DB::commit();
            return 'success';
        } else {
            DB::rollBack();
            return 'failed';
        }
    }

    public function getReportView()
    {
        return view('main_views.lotes.reportLotes');
    }

    public function reporteLote(Request $request)
    {

    }
}
