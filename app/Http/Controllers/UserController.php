<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
 
    public function index()
    {
        return User::with('role')->paginate();
    }

  
    public function store(Request $request)
    {
        $user = User::create(
            $request->only('first-name','last-name','email')
            + ['password' => Hash::make(1234)]
        );
        return response($user,Response::HTTP_CREATED);
    }

    
    public function show($id)
    {
        return User::with('role')->find($id);
    }

   
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);
        $user->update($request->only('first-name','last-name','email'));
        return response($user,Response::HTTP_ACCEPTED);

    }

  
    public function destroy($id)
    {
        User::destroy($id);
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
