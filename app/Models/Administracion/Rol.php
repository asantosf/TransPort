<?php

namespace App\Models\Administracion;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'id';
    public $timestamps = true;

    use SoftDeletes;
    use HasFactory;
}
