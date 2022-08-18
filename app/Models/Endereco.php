<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;
    protected $fillable = ['cliente_id', 'logradouro', 'numero', 'bairro', 'municipio', 'cep','uf','complemento','entrega'];

    public function rules(){
        /*O unique: abaixo, comporta 03 parametros, sendo
        1) tabela que se refere
        2) nome da coluna que será pesquisada na tabela3
        3) id do registro que será desconsiderado na pesquisa...necessário tipo no update


        Exemplos de regras:
        'imagem' => 'required|file|mimes:png,jpeg,jpg',
        'lugares' => 'required|integer|digits_between:1,20',
        'air_bag' => 'required|boolean

        Exemplo de feedback
        'fabricante.exists' => 'Nao encontrado o fabricante'

        */
        return [
            'cliente_id' => 'exists:clientes,id',
            'logradouro' => 'required',
            'numero' => 'required',
            'bairro' => 'required'
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório'
        ];
    }


    //APOS CRIARMOS E TESTARMOS TODOS OS ENDPOINTS, OS CONTROLERS, MODELS E CRUD EM GERAL, VAMOS DEFINIR OS RELACIONAMENTOS PARA QUE AS PESQUISAS FUTURAS TRAGAM DADOS DE MAIS DE UMA TABELA

    public function cliente(){
        //Uma marca pertence a um fabricante
        return $this->belongsTo('App\Models\Cliente');
     }
}
