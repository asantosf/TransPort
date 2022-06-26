<?php

namespace App\Models\Plantas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicaciones extends Model
{
    protected $table = 'ubicaciones_planta';
    protected $primaryKey = 'id';
    public $timestamps = true;

    use HasFactory;
}
