<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function user(Request $request)
    {
        // El middleware 'auth:sanctum' ya ha autenticado al usuario.
        $user = $request->user();

        // Devolver la información esencial del usuario.
        return response()->json([
            'user_id' => $user->user_id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ]);
    }
    //
    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            //throw ValidationException::withMessages(['email'=>['wrong user or password.']]);
            return response()->json(['message'=>'wrong user or password.']);
        }
        $user->tokens()->delete();
        $abilities = $user->role ==='admin'?['admin','client','book:create','book:update','book:delete']:['client'];
        $token = $user->createToken('authToken',$abilities)->plainTextToken;

        return response()->json([
            'message'=>'successful login',
            'user'=> [
                'user_id'=>$user->user_id,
                'name'=>$user->name,
                'email'=>$user->email,
                'role'=>$user->role,
            ],
            'token'=>$token,
            'token_type'=>'Bearer'
        ]);
    }
    /**
     * Handle user logout (revokes the current token).
     */
    public function logout(Request $request)
    {  
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'closed session (revoked token)']);
    }
}
