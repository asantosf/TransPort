<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    protected $table = 'empleado';
    protected $primaryKey = 'id';
    public $timestamps = true;

    use SoftDeletes;
    use HasFactory;

    public function getUbicacion()
    {
        return EmpleadoEmployment::where('empleado_id', $this->id)->withTrashed()->first();
    }
}
