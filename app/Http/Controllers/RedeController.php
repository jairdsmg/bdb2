<?php

namespace App\Http\Controllers;

use App\Models\Rede;
use App\Http\Requests\StoreRedeRequest;
use Illuminate\Http\Request;

class RedeController extends Controller
{
    public function __construct(Rede $rede){
         $this->rede = $rede;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redes = $this->rede->all();
        return response()->json($redes, 200);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRedeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->rede->rules(), $this->rede->feedback());

        $rede = $this->rede->create($request->all());
        return response()->json($rede, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Integer  $rede
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rede = $this->rede->with('lojas')->find($id);
        if($rede === null){
            return response()->json(['erro' => 'O recurso pesquisado não existe'], 404) ;
        }
        return response()->json($rede, 200);
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  Integer  $request
     * @param  \App\Models\Rede  $rede
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rede = $this->rede->find($id);

        if($rede === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso pesquisado não existe'], 404) ;
        }

        if ($request->method() === 'PATCH'){
            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($rede->rules() as $input => $regra){
    
                //coletar apenas as regras apicaveis aos parametros parciais da requisição
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
           // dd($regrasDinamicas);
            $request->validate($regrasDinamicas, $rede->feedback());
        }else{
            $request->validate($rede->rules(), $rede->feedback());
        }
        

        $rede->update($request->all());
        return response()->json($rede, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer  $rede
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rede = $this->rede->find($id);
        if($rede === null){
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso pesquisado não existe'], 404) ;
        }
        $rede->delete();
        return response()->json(['msg' => 'A rede foi removida com sucesso!'], 200);
    }
}
