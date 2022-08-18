<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preco extends Model
{
   // protected $primaryKey = ('loja_id, produto_id, data');
   // public $incrementing = false;
    
    use HasFactory;
    protected $fillable = ['loja_id', 'produto_id', 'data', 'valor'];

    public function rules(){
        /*O unique: abaixo, comporta 03 parametros, sendo
        1) tabela que se refere
        2) nome da coluna que será pesquisada na tabela3
        3) id do registro que será desconsiderado na pesquisa...necessário tipo no update
        */
        return [
            'loja_id' => 'required',
            'produto_id' => 'required',
            'data' => 'required',
            'valor' => 'required'
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório'
        ];
    }

    public function produto(){
        //um preço pertence a um produto
        return $this->belongsTo('App\Models\Produto');
    }
}
