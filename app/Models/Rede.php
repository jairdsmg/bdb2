<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rede extends Model
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
            'cnpj' => 'required|unique:redes,cnpj,'.$this->id,
            'nome' => 'required|unique:redes,nome,'.$this->id.'|min:3'
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.unique' => 'O nome da rede já existe',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres',
            'cnpj.unique' => 'cnpj já cadastrado'
        ];
    }



    public function lojas(){
        //Uma rede possui muitas lojas
        return $this->hasMany('App\Models\Loja');
        //feito isso voltamos aos metodos que retornam as pesquisas e adicionamos "with()->"
    }


}
