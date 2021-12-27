<?php

namespace App\Http\Controllers;

use App\Models\ResponseApi;
use App\Models\User;
use GrahamCampbell\ResultType\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{

    public function register(Request $request) {

        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);


        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [

            'result' => $user,
            'token' => $token

        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24); // 1 day
        $response = new ResponseApi();
        $result = [
            'idUser' => $user->id,
            'message' => $token
        ];
        $response->result = $result;

        return response()->json(
            $response);

        /*return response([
            'idUser' => $user->id,
            'message' => $token
        ])->withCookie($cookie);*/


    }

    public function logout(Request $request) {
        auth()->user()->tokens->each(function($token, $key) {
            $token->delete();
        });

        return [
            'message' => 'Logged out'
        ];
    }
}
