<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoEmploymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado_employment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('empleado_id');
            $table->unsignedBigInteger('rol_negocio');
            $table->unsignedBigInteger('ubicacion');
            $table->foreign('empleado_id')->references('id')->on('empleado')->onDelete('cascade');
            $table->foreign('rol_negocio')->references('id')->on('rol_negocio')->onDelete('cascade');
            $table->foreign('ubicacion')->references('id')->on('ubicaciones_planta')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleado_employment');
    }
}
