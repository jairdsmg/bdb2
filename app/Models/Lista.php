<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    use HasFactory;
    protected $fillable = ['cliente_id', 'descricao'];

    public function rules(){
        /*O unique: abaixo, comporta 03 parametros, sendo
        1) tabela que se refere
        2) nome da coluna que será pesquisada na tabela3
        3) id do registro que será desconsiderado na pesquisa...necessário tipo no update


        */
        return [
            'cliente_id' => 'required',
            'descricao' => 'required'
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório'
        ];
    }


    //produtos e lojas - relação N:M
    public function produtos(){
        /* 1 ) A Model que queremos alcançar através da tabela pivot (Queremos alcançar Produto);
           2 ) O nome da tabela pivot (tabela pivô: produto_listas);
           3 ) O campo que, na tabela pivô, referencia o Model que estamos ('lista_id');
           4 ) O campo que, na tabela pivô, referencia o Model que queremos alcançar ('produto_id' referencia o Model Produto)*/
        return $this->belongsToMany('App\Models\Produto', 'produto_listas','lista_id','produto_id');
    }


    //FUNCIONOU PERFEITAMENTE
    public function cliente(){
        //Uma lista pertence a um cliente
        return $this->belongsTo('App\Models\Cliente');
     }







}
