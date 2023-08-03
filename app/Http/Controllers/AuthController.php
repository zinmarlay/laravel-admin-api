<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'first-name' => $request->input('first-name'),
            'last-name' => $request->input('last-name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response($user,Response::HTTP_CREATED);
    }
    public function login (Request $request)
    {
        //Unsuccessful Login
        if(!Auth::attempt($request->only('email','password'))){
            return \response([
                'error' => 'Invalid credentials'
            ],Response::HTTP_UNAUTHORIZED);
        }
        /**
         * @var User $user
         */
        $user = Auth::user();
        $jwt = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $jwt, 60 * 24);
        return \response([
            'jwt' => $jwt,
        ])->withCookie($cookie);
    }

    public function user(Request $request)
    {
        return $request->user();
    }
}
