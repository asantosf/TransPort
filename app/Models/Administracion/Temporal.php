<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temporal extends Model
{
    protected $table = 'temporal_detalle';
    public $timestamps = false;

    use HasFactory;
}
