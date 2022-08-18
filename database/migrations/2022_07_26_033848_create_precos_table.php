<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loja_id');
            $table->unsignedBigInteger('produto_id');
            $table->date('data');
            $table->double('valor',8,2);
            $table->timestamps();

            //$table->primary(['loja_id', 'produto_codbarras', 'data']); mudado no alter
            $table->foreign('loja_id') -> references('id')->on('lojas')->onDelete('cascade');
            $table->foreign('produto_id') -> references('id')->on('produtos')->onDelete('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('precos');
    }
}
