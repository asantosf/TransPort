<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleProduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_produccion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('produccion_id');
            $table->foreign('produccion_id')->references('id')->on('produccion');
            $table->unsignedBigInteger('materia_prima_id');
            $table->foreign('materia_prima_id')->references('id')->on('materia_prima');
            $table->decimal('cantidad_utilizada');
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
        Schema::dropIfExists('detalle_produccion');
    }
}
