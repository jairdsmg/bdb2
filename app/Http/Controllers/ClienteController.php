<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use Illuminate\Http\Request;
use App\Repositories\ClienteRepository;



class ClienteController extends Controller
{
   public function __construct(Cliente $cliente){
    $this->cliente = $cliente;
   }
   
   
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $clienteRepository = new ClienteRepository($this->cliente);


        if($request->has('atributos_endereco')){
            $atributos_endereco = 'enderecos:cliente_id,'.$request->atributos_endereco;
            $clienteRepository->selectAtributosRegistrosRelacionados($atributos_endereco);
        }else{
            $clienteRepository->selectAtributosRegistrosRelacionados('enderecos');
        }



        if($request->has('filtro')){
            $clienteRepository->filtro($request->filtro);  
        }

        
        if($request->has('atributos')){
            $clienteRepository->selectAtributos($request->atributos); 
        }


        return response()->json($clienteRepository->getResultado(), 200);
    }

        


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->cliente->rules(), $this->cliente->feedback());
        $cliente = $this->cliente->create($request->all());

        return response()->json($cliente, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer $cliente
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = $this->cliente->find($id);
        if($cliente === null){
            return response()->json(['erro' => 'O recurso pesquisado não existe!'], 404);
        }
        return response()->json($cliente, 200);
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  Integer $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cliente = $this->cliente->find($id);

        if($cliente === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso pesquisado não existe'], 404) ;
        }

        if ($request->method() === 'PATCH'){
            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($cliente->rules() as $input => $regra){
    
                //coletar apenas as regras apicaveis aos parametros parciais da requisição
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
           // dd($regrasDinamicas);
            $request->validate($regrasDinamicas, $cliente->feedback());
        }else{
            $request->validate($cliente->rules(), $cliente->feedback());
        }
        

        $cliente->update($request->all());
        return response()->json($cliente, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = $this->cliente->find($id);

        if ($cliente === null){
            return response()->json(['erro' => 'Impossivel excluir. O recurso pesquisado não existe!'], 404);
        }
        $cliente->delete();
        return response()->json(['msg' => 'Cliente removido com sucesso!'], 200);
    }
}
