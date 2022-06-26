<?php

namespace App\Models\Plantas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleProduccion extends Model
{
    protected $table = 'detalle_produccion';
    protected $primaryKey = 'id';
    public $timestamps = true;

    use SoftDeletes;
    use HasFactory;
}
