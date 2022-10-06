<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash; // A função Hash (Resumo) é qualquer algoritmo que mapeie dados grandes e de tamanho variável para pequenos dados de tamanho fixo


class Usuario extends Controller
{
    public function criar(Request $request){
        
        // validando dados
        $validation = Validator::make($request->all(), [
            'cpf'=>'required|max:11', 
            'password'=>'required|max:255'
        ],[
            'required' => 'O :attribute é requerido.', // mensagem dizendo que aquele campo é obrigatório
            'max' => 'O :attribute atingiu o número máximo de caracteres.' // mensagem dizendo que atingiu o número máximo de caracteres
        ]);
        if ($validation->fails()) {
            
            return response()->json('Preencha corretamente os campos', 401);

        };

        // salvar dados no banco de dados
        $usuario = new User();
        $usuario->cpf = $request->cpf;
        $usuario->password = bcrypt($request->password); // bcrypt serve para esconder senhas criadas pelos usuários em forma de texto “puro” em dados indecifráveis, utilizando o algoritmo hash
        $usuario->save();

        $token = $usuario->createToken('primeiroToken')->plainTextToken;

        // retornar resposta json

        return response()->json(['mensagem' => 'Salvo com sucesso!', 'token' => $token], 201);
    }

// Estudar sobre 201, 401 do retorno do json (status servidor)
    
    // validando dados
    public function listarTudo(){
        // Alterar o retorno para response()
        return json_encode(User::all()); // este User é o Eloquent/ORM Laravel
    }

    public function listar($Id){
        // Verificar na internet como implantar like(MySQL) laravel https://dev.to/kingsconsult/how-to-implement-search-functionality-in-laravel-8-and-laravel-7-downwards-3g76
        // $usuario = User::find($Id); // só funciona com Id
        $usuario = User::where('id', $Id)->get();
        return response()->json($usuario, 201);
    }

    public function deletar($Id){
        $usuario = User::find($Id); // É necessário deletar pelo Id
        // Buscar na internet como saber se o usuário existe antes de deletar, usar a condição if e else
        $usuario->delete();
        return response()->json('Usuário deletado com sucesso!', 201);
    }

    public function logar(Request $request)
    {
        $user = User::where('cpf', $request->cpf)->first();
    
        if (!$user || Hash::check($request->password, $user->password) != true) {
            return response([
                'message' => 'Credenciais inválidas'
            ], 401);
        }

        $token = $user->createToken('primeiroToken')->plainTextToken;

        // retornar resposta json

        return response()->json(['mensagem' => 'Logado com sucesso!', 'token' => $token], 201);
    }
}