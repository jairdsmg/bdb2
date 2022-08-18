<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class AuthController extends Controller
{
  public function login(Request $request){

    $credenciais = $request->all(['email','password']);

    $token = auth('api')->attempt($credenciais);

    if ($token){

      return response()->json(['token' =>$token]);

    }else{

      return response()->json(['erro'=>'Usuário e/ou senha inválido(s)!'], 403);
    }

  }



  public function logout(){

    auth('api')->logout();
    return response()->json(['msg' =>'Logout efetuado com sucesso!']);
  }




  public function refresh(){

     $token = auth('api')->refresh(); //cliente tem que encaminhar um jwt valido para que seja renovado
     return response()->json(['token' => $token]);

  }




  public function me(){
    return response()->json(auth()->user());
  }
    

}
