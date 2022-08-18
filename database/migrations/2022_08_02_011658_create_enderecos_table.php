<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->string('logradouro', 180);
            $table->string('numero', 8);
            $table->string('bairro', 50);
            $table->string('municipio', 50)->default('Itaquaquecetuba');
            $table->string('cep', 8);
            $table->string('uf', 2)->default('SP');
            $table->string('complemento', 50)->nullable();
            $table->boolean('entrega');
            $table->timestamps();


            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
}
