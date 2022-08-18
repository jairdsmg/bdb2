<?php

namespace App\Http\Controllers;

use App\Models\Lista;
use App\Http\Requests\StoreListaRequest;
use Illuminate\Http\Request;

class ListaController extends Controller
{
    public function __construct(Lista $lista){
        $this->lista = $lista;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listas = $this->lista->all();
        return response()->json($listas, 200);
    }

   



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreListaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->lista->rules(), $this->lista->feedback());

        $lista = $this->lista->create($request->all());
        return response()->json($lista, 201);
    }





    /**
     * Display the specified resource.
     *
     * @param  Integer  $lista
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$lista = $this->lista->with('produtos')->find($id);
        $lista = $this->lista->with(['cliente','produtos'])->find($id);
        if($lista === null){
            return response()->json(['erro' => 'O recurso pesquisado não existe!'], 404);
        }
        return response()->json($lista, 200);
    }

   


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateListaRequest  $request
     * @param  \App\Models\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lista = $this->lista->find($id);

        if($lista === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso pesquisado não existe'], 404) ;
        }

        if ($request->method() === 'PATCH'){
            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($lista->rules() as $input => $regra){
    
                //coletar apenas as regras apicaveis aos parametros parciais da requisição
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
           // dd($regrasDinamicas);
            $request->validate($regrasDinamicas, $lista->feedback());
        }else{
            $request->validate($lista->rules(), $lista->feedback());
        }
        

        $lista->update($request->all());
        return response()->json($lista, 200);
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param Integer $lista
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lista = $this->lista->find($id);
        if($lista === null){
            return response()->json(['erro' => 'Impossível excluir. O recurso pesquisado não existe!'], 404);
        }
        $lista->delete();
        return response()->json(['msg' => 'Lista excluída com sucesso!'], 200);
    }
}
