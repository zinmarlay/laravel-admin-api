<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Resources\UserResource;
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
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'rol_id'=>1,

        ]);

        return response(new UserResource($user),Response::HTTP_CREATED);
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

        /**
         * We don’t want the token to be stored in the front end as above because of security
         *To fix that, we have to send a token differently via cookies. 
         */
        
        $cookie = cookie('jwt', $jwt, 60 * 24);
        return \response([
            'jwt' => $jwt,
        ])->withCookie($cookie);
    }

    public function user(Request $request)
    {
        return new UserResource($request->user());
    }

    public function logout()
    {
        $cookie = \Cookie::forget('jwt');
        return \response([
            'message' => 'success'
        ])->withCookie($cookie);
    }
    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = $request->user();
        $user->update($request->only('first_name','last_name','email'));
        return response(new UserResource($user),Response::HTTP_ACCEPTED);
    }
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->input('password'))   
        ]);
        return response(new UserResource($user),Response::HTTP_ACCEPTED);
    }
}
