<?php

namespace App\Http\Controllers;

use App\Models\Fabricante;
use Illuminate\Http\Request;
/*use App\Http\Requests\StoreFabricanteRequest;
use App\Http\Requests\UpdateFabricanteRequest;*/

class FabricanteController extends Controller
{
    public function __construct(Fabricante $fabricante){
        $this->fabricante = $fabricante;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fabricantes = array();
        
        if($request->has('atributos')){
            $atributos = $request->atributos;
            $fabricantes = $this->fabricante->selectRaw($atributos)->with('marcas')->get();
        }else{
            $fabricantes = $this->fabricante->with('marcas')->get();
        }
        
       // $fabricantes = $this->fabricante->with('marcas')->get();
        return response()->json($fabricantes, 200);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $request->validate($this->fabricante->rules(), $this->fabricante->feedback());

       $fabricante = $this->fabricante->create($request->all());
       return response()->json($fabricante, 201);
    }



    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fabricante = $this->fabricante->with('marcas')->find($id);
        if($fabricante === null){
            return response()->json(['erro' => 'O recurso pesquisado não existe'], 404) ;
        }
        return response()->json($fabricante, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Integer
     * @param  \App\Models\Fabricante  $fabricante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fabricante = $this->fabricante->find($id);

        if($fabricante === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso pesquisado não existe'], 404) ;
        }

        if ($request->method() === 'PATCH'){
            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($fabricante->rules() as $input => $regra){
    
                //coletar apenas as regras apicaveis aos parametros parciais da requisição
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
           // dd($regrasDinamicas);
            $request->validate($regrasDinamicas, $fabricante->feedback());
        }else{
            $request->validate($fabricante->rules(), $fabricante->feedback());
        }
        
       

        $fabricante->update($request->all());
        return response()->json($fabricante, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fabricante = $this->fabricante->find($id);
        if($fabricante === null){
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso pesquisado não existe'], 404) ;
        }
        $fabricante->delete();
        return response()->json(['msg' => 'O fabricante foi removido com sucesso!'], 200);
    }
}
