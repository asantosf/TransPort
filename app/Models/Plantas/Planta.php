<?php

namespace App\Models\Plantas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Planta extends Model
{
    protected $table = 'planta';
    protected $primaryKey = 'id';
    public $timestamps = true;

    use SoftDeletes;
    use HasFactory;
}
