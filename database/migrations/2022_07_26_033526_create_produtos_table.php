<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('codbarras');
            $table->unsignedBigInteger('marca_id');
            $table->unsignedBigInteger('categoria_id');
            $table->string('nome', 100);
            $table->string('descricao', 100);
            $table->enum('unidade',['kg','g','l','ml','m','cm','mm']);
            $table->string('quantidade', 10);
            $table->string('imagem', 120);
            $table->timestamps();

           
            $table->foreign('marca_id') -> references('id')->on('marcas')->onDelete('cascade');
            $table->foreign('categoria_id') -> references('id')->on('categorias')->onDelete('cascade');
           // $table->primary('codbarras');
        });
    }

     //PRECISO TESTAR O SET NULL  DO CATEGORIA_ID ACIMA
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
