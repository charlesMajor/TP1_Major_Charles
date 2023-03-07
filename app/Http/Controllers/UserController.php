<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function create(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
               'login' => 'required',
               'password' => 'required',
               'email' => 'required',
               'last_name' => 'required',
               'first_name' => 'required' 
            ]);

            if($validator->fails())
            {
                abort(INVALID_DATA, 'Invalid data');
            }

            $user = User::create($request->all());
            return (new UserResource($user))->response()->setStatusCode(CREATED);
        }
        catch(Exception $ex)
        {
            abort(SERVER_ERROR, 'Server error');
        }
    }

    public function update(Request $request, $id)
    {
        try
        {
            $validator = Validator::make($request->all(), [
               'login' => 'required',
               'password' => 'required',
               'email' => 'required',
               'last_name' => 'required',
               'first_name' => 'required' 
            ]);

            if($validator->fails())
            {
                abort(INVALID_DATA, 'Invalid data');
            }

            $user = User::findOrFail($id);
            $user->delete();
            $user->insert($request->all());
        }
        catch(QueryException $ex)
        {
            abort(NOT_FOUND, 'Invalid id');
        }
        catch(Exception $ex)
        {
            abort(SERVER_ERROR, 'Server error');
        }
    }

    public function favoriteLanguage($id)
    {
        try
        {
            
        }
        catch(QueryException $ex)
        {
            abort(NOT_FOUND, 'Invalid id');
        }
        catch(Exception $ex)
        {
            abort(SERVER_ERROR, 'Server error');
        }
    }
}
