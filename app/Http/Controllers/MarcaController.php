<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Http\Requests\StoreMarcaRequest;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function __construct(Marca $marca){
         $this->marca = $marca;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas = $this->marca->with('fabricante')->get();
        return response()->json($marcas, 200);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->marca->rules(), $this->marca->feedback());

        $marca = $this->marca->create($request->all());
        return response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer  $marca
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->with('fabricante')->find($id);
        if($marca === null){
            return response()->json(['erro' => 'O recurso pesquisado não existe'], 404) ;
        }
        return response()->json($marca, 200);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  Integer  $request
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);

        if($marca === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso pesquisado não existe'], 404) ;
        }

        if ($request->method() === 'PATCH'){
            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($marca->rules() as $input => $regra){
    
                //coletar apenas as regras apicaveis aos parametros parciais da requisição
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
           // dd($regrasDinamicas);
            $request->validate($regrasDinamicas, $marca->feedback());
        }else{
            $request->validate($marca->rules(), $marca->feedback());
        }
        

        $marca->update($request->all());
        return response()->json($marca, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso pesquisado não existe'], 404) ;
        }
        $marca->delete();
        return response()->json(['msg' => 'A marca foi removida com sucesso!'], 200);
    }
}
