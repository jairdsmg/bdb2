<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $fillable = ['categoriamae_id', 'nome', 'descricao'];

    public function rules(){
        /*O unique: abaixo, comporta 03 parametros, sendo
        1) tabela que se refere
        2) nome da coluna que será pesquisada na tabela3
        3) id do registro que será desconsiderado na pesquisa...necessário tipo no update


        */
        return [
            'nome' => 'required|unique:categorias,nome,'.$this->id.'|min:3'
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.unique' => 'O nome da categoria já existe',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres',
        ];
    }


    //
    public function produtos(){
        //Uma categoria tem muitos produtos
        return $this->hasMany('App\Models\Produto');
        //feito isso voltamos aos metodos que retornam as pesquisas e adicionamos "with()->"
    }

    public function categoriamae(){
        //Uma categoria pode ter uma categoriamae
        return $this->belongsTo('App\Models\Categoria');
    }
    
}
