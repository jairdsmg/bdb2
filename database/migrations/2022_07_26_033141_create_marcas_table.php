<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fabricante_id');
            $table->string('nome', 60) -> unique();
            $table->string('descricao', 50);
            $table->string('site', 30);
            $table->string('email', 35);
            $table->timestamps();

            $table->foreign('fabricante_id') -> references('id')->on('fabricantes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marcas');
    }
}
