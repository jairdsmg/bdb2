<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['fabricante_id', 'nome', 'descricao', 'site', 'email'];

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
            'fabricante_id' => 'exists:fabricantes,id',
            'nome' => 'required|unique:fabricantes,nome,'.$this->id.'|min:3'
        ];
    }


    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.unique' => 'O nome da marca já existe',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres',
        ];
    }


    
    //APOS CRIARMOS E TESTARMOS TODOS OS ENDPOINTS, OS CONTROLERS, MODELS E CRUD EM GERAL, VAMOS DEFINIR OS RELACIONAMENTOS PARA QUE AS PESQUISAS FUTURAS TRAGAM DADOS DE MAIS DE UMA TABELA

    public function fabricante(){
       //Uma marca pertence a um fabricante
       return $this->belongsTo('App\Models\Fabricante');
    }
}
