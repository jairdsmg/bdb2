<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutoListasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto_listas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lista_id');
            $table->unsignedBigInteger('produto_id');
            $table->timestamps();

            $table->foreign('lista_id') -> references('id')->on('listas');
            $table->foreign('produto_id') -> references('id')->on('produtos');
           // $table->primary(['lista_id', 'produto_codbarras']);
        });
    }

    //TENHO QUE ESTUDAR SOBRE O ON DELETE DOS FOREIGN ACIMA

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produto_listas');
    }
}
