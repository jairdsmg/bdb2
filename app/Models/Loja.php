<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loja extends Model
{
    use HasFactory;
    protected $fillable = ['rede_id', 'nome', 'endereco', 'latitude', 'longitude', 'site','email'];

    public function rules(){
         /*O unique: abaixo, comporta 03 parametros, sendo
        1) tabela que se refere
        2) nome da coluna que será pesquisada na tabela3
        3) id do registro que será desconsiderado na pesquisa...necessário tipo no update
        */
        
        return [
            'rede_id' => 'required',
            'nome' => 'required|unique:lojas,nome,'.$this->id.'|min:3'
        ]; 

    }



    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.unique' => 'O nome da loja já existe',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres'
        ];

    }



    public function produtos(){
        return $this->belongsToMany('App\Models\Produto', 'precos','loja_id','produto_id');
        //Perceba que a declaração deste tipo de relacionamento é diferente, usamos um outro método, o belongsToMany() e informamos quatro argumentos, em sequência:
        /* 1 ) A Model que queremos alcançar através da tabela pivot (Queremos alcançar Produto);
           2 ) O nome da tabela pivot (tabela pivô: precos);
           3 ) O campo que, na tabela pivô, referencia o Model que estamos ('loja_id'...na tabela pivõ esse campo referencia o Model que estamos, Loja);
           4 ) O campo que, na tabela pivô, referencia o Model que queremos alcançar ('produto_codbarras' referencia o Model Produtos)
        Fazendo dessa forma nós encurtamos o caminho, sem precisar passar da 'loja' para a 'precos' (loja_produtos -antigo nome), e depois para a 'produtos', pois o Laravel já está fazendo isso de forma oculta. */
    }




    public function rede(){
        //Uma loja pertence a uma rede
        return $this->belongsTo('App\Models\Rede');
     }



}
