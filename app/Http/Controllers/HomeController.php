<?php

namespace App\Http\Controllers;

use App\Models\Bakery\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $lotesCount = Lote::select(DB::raw('COUNT(*) AS countLotes')) 
                            ->whereRaw('WHERE MONTH(created_at) = MONTH(NOW())')
                            ->whereNull('deleted_at')->first();

        return view('index', compact('lotesCount'));
    }
}
