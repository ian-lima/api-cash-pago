<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class Usuario extends Controller
{
    public function criar(Request $request){
        
        // validando dados
        $validation = Validator::make($request->all(), [
            'cpf'=>'required|max:11', 
            'password'=>'required|max:255'
        ],[
            'required' => 'O :attribute é requerido.',
            'max' => 'O :attribute atingiu o número máximo de caracteres.'
        ]);
        if ($validation->fails()) {
            
            return response()->json('Preencha corretamente os campos', 401);

        };

        // salvar dados no banco de dados
        $usuario = new User();
        $usuario->cpf = $request->cpf;
        $usuario->password = $request->password;
        $usuario->save();

        // retornar resposta json

        return response()->json('Salvo com sucesso!', 201);
    }

    public function listarTudo(){
        return json_encode(User::all());
    }

    public function listar($Id){
        // $usuario = User::find($Id); // só funciona com Id
        $usuario = User::where('id', $Id)->get();
        return response()->json($usuario, 201);
    }

    public function deletar($Id){
        $usuario = User::find($Id);
        $usuario->delete();
        return response()->json('Usuário deletado com sucesso!', 201);
    }
}
