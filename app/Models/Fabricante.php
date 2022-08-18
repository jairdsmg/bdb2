<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fabricante extends Model
{
    use HasFactory;
    protected $fillable = ['cnpj', 'nome', 'site', 'email'];

    public function rules(){
        /*O unique: abaixo, comporta 03 parametros, sendo
        1) tabela que se refere
        2) nome da coluna que será pesquisada na tabela3
        3) id do registro que será desconsiderado na pesquisa...necessário tipo no update


        */
        return [
            'cnpj' => 'required|unique:fabricantes,cnpj,'.$this->id,
            'nome' => 'required|unique:fabricantes,nome,'.$this->id.'|min:3'
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.unique' => 'O nome do fabricante já existe',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres',
            'cnpj.unique' => 'cnpj já cadastrado'
        ];
    }




    //APOS CRIARMOS E TESTARMOS TODOS OS ENDPOINTS, OS CONTROLERS, MODELS E CRUD EM GERAL, VAMOS DEFINIR OS RELACIONAMENTOS PARA QUE AS PESQUISAS FUTURAS TRAGAM DADOS DE MAIS DE UMA TABELA
    public function marcas(){
        //Um fabricante possui muitas marcas
        return $this->hasMany('App\Models\Marca');
        //feito isso voltamos aos metodos que retornam as pesquisas e adicionamos "with()->"
    }
}
