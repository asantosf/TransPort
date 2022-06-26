<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departamento extends Model
{
    protected $table = 'departamento';
    protected $primaryKey = 'id';

    use HasFactory;

    public function getMunicipio()
    {
        return $this->hasMany('App\Models\Administracion\Municipio');
    }
}
