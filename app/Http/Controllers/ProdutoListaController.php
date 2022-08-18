<?php

namespace App\Http\Controllers;

use App\Models\ProdutoLista;
use App\Http\Requests\StoreProdutoListaRequest;
use Illuminate\Http\Request;

class ProdutoListaController extends Controller
{
    public function __construct(ProdutoLista $produtoLista){
        $this->produtoLista = $produtoLista;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtosLista = $this->produtoLista->all();
        return response()->json($produtosLista, 200);
    }

    



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProdutoListaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->produtoLista->rules(), $this->produtoLista->feedback());

        $produtoLista = $this->produtoLista->create($request->all());
        return response()->json($produtoLista, 201);
    }




    
    /**
     * Display the specified resource.
     *
     * @param  Integer  $produtoLista
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produtoLista = $this->produtoLista->with('lista')->find($id);
        if($produtoLista === null){
            return response()->json(['erro' => 'O recurso pesquisado não existe'], 404) ;
        }
        return response()->json($produtoLista, 200);
    }





    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProdutoListaRequest  $request
     * @param  \App\Models\ProdutoLista  $produtoLista
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produtoLista = $this->produtoLista->find($id);

        if($produtoLista === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso pesquisado não existe'], 404) ;
        }

        if ($request->method() === 'PATCH'){
            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($produtoLista->rules() as $input => $regra){
    
                //coletar apenas as regras apicaveis aos parametros parciais da requisição
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
           // dd($regrasDinamicas);
            $request->validate($regrasDinamicas, $produtoLista->feedback());
        }else{
            $request->validate($produtoLista->rules(), $produtoLista->feedback());
        }

        $produtoLista->update($request->all());
        return response()->json($produtoLista, 200);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer  $produtoLista
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produtoLista = $this->produtoLista->find($id);
        if($produtoLista === null){
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso pesquisado não existe'], 404) ;
        }
        $produtoLista->delete();
        return response()->json(['msg' => ' O produto foi removido da lista com sucesso!'], 200);
    }
    
}
