<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(AuthRequest $request)
    {
        $data = $request->validated();
        $user_email = User::where('email', '=', $data['email'])->first();
        if ($user_email != null) {
            return response()->json(['errors' => ['error' => 'Este email já está em uso. Modifique-o e tente novamente']]);
        }
       
        $user = new User();
        $user->fill($data);
        $user->fill(['password' => bcrypt($data['password'])]);
        $user->save();

        return response()->json([
            'success'   =>  true,
        ], 200);
    }

    public function login (AuthRequest $request){

        $data =$request->validated();

        $user = User::where('email', '=', $data['email'])->first();
        Log::info($user);
        if(!$user){
            return response()->json(['errors' => ['error'=> 'Este email não consta em nossa base de dados.']]);
        }
        if(!password_verify($data['password'], $user->password)){
            return response()->json(['errors'=>['error' => 'Email ou senha incorretos!']]);
        }
        $tokenResult = $user->createToken('Personal Access Token');
        Log::info($tokenResult);
        $token = $tokenResult->token;
        $token->save();
        return response()->json([
            'access_token'=> $tokenResult->accessToken,
            'token_type'=> 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->format('d/m/Y H:i'),
            'user' => UserResource::make($user)
        ]);
    }

 
}
