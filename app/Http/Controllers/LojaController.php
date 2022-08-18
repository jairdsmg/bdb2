<?php

namespace App\Http\Controllers;

use App\Models\Loja;
use App\Http\Requests\StoreLojaRequest;
use Illuminate\Http\Request;

class LojaController extends Controller
{
    public function __construct(Loja $loja){
        $this->loja = $loja;
    }
    
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lojas = $this->loja->with(['rede','produtos'])->get();
        return response()->json($lojas, 200);
    }
    

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLojaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->loja->rules(), $this->loja->feedback());
        $loja = $this->loja->create($request->all());
        return response()->json($loja, 200);
    }



    /**
     * Display the specified resource.
     *
     * @param  Integer  $loja
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loja = $this->loja->with('produtos')->find($id);

        if($loja === null){
            return response()->json(['erro' =>'O recurso pesquisado não existe'], 404);
        }
        return response()->json($loja, 200);
    }

   


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLojaRequest  $request
     * @param  \App\Models\Loja  $loja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $loja = $this->loja->find($id);

        if($loja === null){
            return response()->json(['erro' => 'Impossível atualizar. O recurso pesquisado não existe!']);
        }
        
        if($request->method() === 'PATCH'){
            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($loja->rules() as $input => $regra){
    
                //coletar apenas as regras apicaveis aos parametros parciais da requisição
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
           // dd($regrasDinamicas);
            $request->validate($regrasDinamicas, $loja->feedback());

        }else{
            $request->validate($loja->rules(), $loja->feedback());
        }


        $loja->update($request->all());
        return response()->json($loja, 200);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer  $loja
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loja = $this->loja->find($id);
        if($loja === null){
            return response()->json(['erro' => 'Impossível realizar exclusão. O recurso pesquisado não existe!', 404]);
        }
        $loja->delete();
        return response()->json('Loja excluída com sucesso!', 200);
    }
}
