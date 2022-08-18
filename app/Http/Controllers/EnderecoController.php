<?php

namespace App\Http\Controllers;
use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    public function __construct(Endereco $endereco){
        $this->endereco = $endereco;
   }
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enderecos = $this->endereco->with('cliente')->get();
        return response()->json($enderecos, 200);
    }

    



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->endereco->rules(), $this->endereco->feedback());

        $endereco = $this->endereco->create($request->all());
        return response()->json($endereco, 201);
    }





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $endereco = $this->endereco->with('cliente')->find($id);
        if($endereco === null){
            return response()->json(['erro' => 'O recurso pesquisado não existe'], 404) ;
        }
        return response()->json($endereco, 200);
    }

   




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $endereco = $this->endereco->find($id);

        if($endereco === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso pesquisado não existe'], 404) ;
        }

        if ($request->method() === 'PATCH'){
            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($endereco->rules() as $input => $regra){
    
                //coletar apenas as regras apicaveis aos parametros parciais da requisição
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
           // dd($regrasDinamicas);
            $request->validate($regrasDinamicas, $endereco->feedback());
        }else{
            $request->validate($endereco->rules(), $endereco->feedback());
        }
        

        $endereco->update($request->all());
        return response()->json($endereco, 200);
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $endereco = $this->endereco->find($id);
        if($endereco === null){
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso pesquisado não existe'], 404) ;
        }
        $endereco->delete();
        return response()->json(['msg' => 'A marca foi removida com sucesso!'], 200);
    }
}
