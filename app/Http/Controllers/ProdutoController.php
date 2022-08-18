<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Loja;
use App\Http\Requests\StoreProdutoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;  //para possibilitar excluir as imagens
use App\Repositories\ProdutoRepository;



class ProdutoController extends Controller
{
    public function __construct(Produto $produto){
        $this->produto = $produto;
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $produtoRepository = new ProdutoRepository($this->produto);


        if($request->has('atributos_preco')){
            $atributos_preco = 'precos:produto_id,'.$request->atributos_preco;
            $produtoRepository->selectAtributosRegistrosRelacionados($atributos_preco);
        }else{
            $produtoRepository->selectAtributosRegistrosRelacionados('precos');
        }



        if($request->has('filtro')){
            $produtoRepository->filtro($request->filtro);  
        }

        
        if($request->has('atributos')){
            $produtoRepository->selectAtributos($request->atributos); 
        }


        return response()->json($produtoRepository->getResultado(), 200);
       /*
        $produtos = array();
        
        if($request->has('atributos')){
            $atributos = $request->atributos;
            $atributos_loja = $request->atributos_loja;

            $produtos = $this->produto->selectRaw($atributos)->with('lojas:id,
            nome,email')->get();
        }else{
            //$produtos = $this->produto->with('lojas')->get();
            $produtos = $this->produto->get();
        }
        
        return response()->json($produtos, 200);
        */



        /*
        
        $produtos = $this->produto->with(['categoria','lojas'])->get();
        return response()->json($produtos, 200);  
        */
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProdutoRequest  $r equest
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->produto->rules(), $this->produto->feedback());

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens','public');

        $produto = $this->produto->create([
            'codbarras' => $request->codbarras, 
            'marca_id' => $request->marca_id,
            'categoria_id' => $request->categoria_id, 
            'nome' => $request->nome,
            'descricao' => $request->descricao, 
            'unidade' => $request->unidade,
            'quantidade' => $request->quantidade,
            'imagem' => $imagem_urn
        ]);
        return response()->json($produto, 201);
    }





    /**
     * Display the specified resource.
     *
     * @param  BigInteger  $produto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produto = $this->produto->with(['categoria','marca','precos','lojas'])->find($id);
        //$produto = $this->produto->with('precos')->find($id);

        if($produto === null){
            return response()->json(['erro' => 'O recurso pesquisado não existe'], 404);
        }
        return response()->json($produto, 200);
    }

    



    /**
     * Update the specified resource in storage.
     *
     * @param  BigInteger  $request
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $codbarras)
    {
        $produto = $this->produto->find($codbarras);

        if($produto === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso pesquisado não existe'], 404) ;
        }

        if ($request->method() === 'PATCH'){
            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($produto->rules() as $input => $regra){
    
                //coletar apenas as regras apicaveis aos parametros parciais da requisição
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
           // dd($regrasDinamicas);
            $request->validate($regrasDinamicas, $produto->feedback());
        }else{
            $request->validate($produto->rules(), $produto->feedback());
        }
        
        
        //Se for enviada nova imagem, antes deletamos a que se encontra arquivada.Para tanto, usamos a Facades Storage, importando-a antes
        if($request->file('imagem')){
            Storage::disk('public')->delete($produto->imagem);
        }

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens','public');


        //preencher o objeto $produto com os dados do request
        $produto->fill($request->all());
        $produto->imagem = $imagem_urn;

        $produto->save();


        /*
        $produto->update([
            'codbarras' => $request->codbarras, 
            'marca_id' => $request->marca_id,
            'categoria_id' => $request->categoria_id, 
            'nome' => $request->nome,
            'descricao' => $request->descricao, 
            'unidade' => $request->unidade,
            'quantidade' => $request->quantidade,
            'imagem' => $imagem_urn
        ]); */
        
        return response()->json($produto, 200);
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  BigInteger  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy($codbarras)
    {
        $produto = $this->produto->find($codbarras);

        if($produto === null){
            return response()->json(['erro' => 'Impossível excluir. O recurso pesquisado não existe!'], 404);
        }

        //Removendo o arquivo imagem antes dos dados. Para tanto, usamos a Facades Storage, importando-a antes
        Storage::disk('public')->delete($produto->imagem);
        

        $produto->delete();
        return response()->json(['msg' => 'Produto excluído com sucesso!'], 200);
    }
}
