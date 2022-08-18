<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use Illuminate\Http\Request;
use App\Repositories\CategoriaRepository;

class CategoriaController extends Controller
{
    public function __construct(Categoria $categoria){
        $this->categoria = $categoria;
    }
    


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $categoriaRepository = new CategoriaRepository($this->categoria);


        if($request->has('atributos_produto')){
            $atributos_produto = 'produtos:categoria_id,'.$request->atributos_produto;
            $categoriaRepository->selectAtributosRegistrosRelacionados($atributos_produto);
        }else{
            $categoriaRepository->selectAtributosRegistrosRelacionados('produtos');
        }


        if($request->has('filtro')){
            $categoriaRepository->filtro($request->filtro);  
        }

        
        if($request->has('atributos')){
            $categoriaRepository->selectAtributos($request->atributos); 
        }


        return response()->json($categoriaRepository->getResultado(), 200);



        
        
        /*
        $categorias = $this->categoria->all();
        return response()->json($categorias, 200);  */
    }

   


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoriaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->categoria->rules(), $this->categoria->feedback());

       $categoria = $this->categoria->create($request->all());
       return response()->json($categoria, 201);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  Integer $categoria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $categoria = $this->categoria->with(['categoriamae','produtos'])->find($id);

            if($categoria === null){
                return response()->json(['erro' => 'O recurso pesquisado não existe'], 404);
            }
            return response()->json($categoria, 200);
        
    }

    



    /**
     * Update the specified resource in storage.
     *
     * @param  Integer  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $categoria = $this->categoria->find($id);

        if($categoria === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso pesquisado não existe'], 404) ;
        }

        if ($request->method() === 'PATCH'){
            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($categoria->rules() as $input => $regra){
    
                //coletar apenas as regras apicaveis aos parametros parciais da requisição
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
           // dd($regrasDinamicas);
            $request->validate($regrasDinamicas, $categoria->feedback());
        }else{
            $request->validate($categoria->rules(), $categoria->feedback());
        }
        
        $categoria->update($request->all());
        return response()->json($categoria, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = $this->categoria->find($id);

        if($categoria === null){
            return response()->json(['erro' => 'Impossível excluir. O recurso pesquisado não existe!']);
        }
        $categoria->delete();
        return response()->json(['msg' => 'Categoria removida com sucesso!'], 200);
    }
}
