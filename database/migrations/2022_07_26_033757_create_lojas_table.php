<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLojasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lojas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rede_id');
            $table->string('nome', 100);
            $table->string('endereco', 150);
            $table->string('latitude', 30);
            $table->string('longitude', 30);
            $table->string('site', 60);
            $table->string('email', 40);
            $table->timestamps();

            $table->foreign('rede_id') -> references('id')->on('redes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lojas');
    }
}
