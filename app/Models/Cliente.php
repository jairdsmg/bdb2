<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = ['email', 'senha', 'cpf', 'nome', 'sobrenome', 'apelido', 'celular'];

    public function rules(){
        /*O unique: abaixo, comporta 03 parametros, sendo
        1) tabela que se refere
        2) nome da coluna que será pesquisada na tabela3
        3) id do registro que será desconsiderado na pesquisa...necessário tipo no update
        */
        return [
            'email' => 'required|unique:clientes,email,'.$this->id, //poderia ter a validação 'email'
            'senha' => 'required',                        //em que o laravel saberia tratar como email
            'cpf' => 'required|unique:clientes,cpf,'.$this->id,
            'nome' => 'required|min:3'
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres',
            'cpf.unique' => 'cpf já cadastrado',
            'email.unique' => 'email já cadastrado'
        ];
    }


    //APOS CRIARMOS E TESTARMOS TODOS OS ENDPOINTS, OS CONTROLERS, MODELS E CRUD EM GERAL, VAMOS DEFINIR OS RELACIONAMENTOS PARA QUE AS PESQUISAS FUTURAS TRAGAM DADOS DE MAIS DE UMA TABELA
    public function enderecos(){
        //Um cliente possui muitos enderecos
        return $this->hasMany('App\Models\Endereco');
        //feito isso voltamos aos metodos que retornam as pesquisas e adicionamos "with()->"
    }
}
