<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;
    //protected $primaryKey = 'codbarras'; essas anotações estavam atrapalhando as consultas relacionadas
    //public $incrementing = false;

    protected $fillable = ['codbarras', 'marca_id', 'categoria_id', 'nome', 'descricao', 'unidade','quantidade','imagem'];

    public function rules(){
        /*O unique: abaixo, comporta 03 parametros, sendo
        1) tabela que se refere
        2) nome da coluna que será pesquisada na tabela
        3) id do registro que será desconsiderado na pesquisa...necessário tipo no update
        */

        return [
           
            'codbarras' => 'required|unique:produtos,codbarras,'.$this->id.'|min:3',
            'marca_id' => 'required|exists:marcas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'nome' => 'required',
            'descricao' => 'required',
            'unidade' => 'required',
            'quantidade' => 'required',
            'imagem' => 'required|file|mimes:png,jpeg,jpg'
        ];
    }

    
    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório',
            'codbarras.unique' => 'Este código de barras já existe!',
            'imagem.mimes' => 'As extensões aceitas são png, jpg ou jpeg',
            'marca_id.exists' => 'Não encontrada marca com o id informado',
            'categoria_id.exists' => 'Não encontrada categoria com o id informado'
        ];
    }



   //produtos e lojas - relação N:M
   //FUNCIONOU PERFEITAMENTE
    public function lojas(){
        return $this->belongsToMany('App\Models\Loja', 'precos','produto_id','loja_id');
    }

    //FUNCIONOU PERFEITAMENTE
    public function precos(){
        //Um produto possui muitos precos
        return $this->hasMany('App\Models\Preco');
        //feito isso voltamos aos metodos que retornam as pesquisas e adicionamos "with()->"
    }


    //FUNCIONOU PERFEITAMENTE
    public function marca(){
        //Uma produto pertence a uma marca
        return $this->belongsTo('App\Models\Marca');
     }


     //NAO FUNCIONOU AINDA
     public function categoria(){
        //Uma produto pertence a um categoria
        return $this->belongsTo('App\Models\Categoria');
     }


    

    
}
 

        
       