<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleOrden extends Model
{
    protected $table = 'detalle_factura';
    protected $primaryKey = 'id';
    public $timestamps = true;

    use SoftDeletes;
    use HasFactory;
}
