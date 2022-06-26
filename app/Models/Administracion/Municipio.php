<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'municipio';
    protected $primaryKey = 'id';

    use HasFactory;
}
