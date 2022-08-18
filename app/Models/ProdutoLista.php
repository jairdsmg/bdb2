<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoLista extends Model
{
    //protected $primaryKey = ('lista_id, produto_codbarras');
    //public $incrementing = false;
    
    use HasFactory;
    protected $fillable = ['lista_id', 'produto_id'];

    public function rules(){
        /*O unique: abaixo, comporta 03 parametros, sendo
        1) tabela que se refere
        2) nome da coluna que será pesquisada na tabela3
        3) id do registro que será desconsiderado na pesquisa...necessário tipo no update
        */
        
        return [
            'lista_id' => 'required',
            'produto_id' => 'required'
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório'
        ];
    }



    //FUCIONOU
    public function lista(){
        //Um produtolista pertence a uma lista
        return $this->belongsTo('App\Models\Lista');
     }


}
