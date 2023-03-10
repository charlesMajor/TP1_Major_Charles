<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\CriticResource;
use App\Models\User;
use App\Models\Critic;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
   /** 
   *@OA\Post(
   *    path="/api/users",
   *    tags={"Users"},
   *    summary="Creates a user",
   *    @OA\RequestBody(
   *        @OA\MediaType(
   *            mediaType="application\json",
   *            @OA\Schema(
   *                @OA\Property(
   *                    property="login",
   *                    type="string"),
   *                @OA\Property(
   *                    property="password",
   *                    type="string"),
   *                @OA\Property(
   *                    property="email",
   *                    type="string"),
   *                @OA\Property(
   *                    property="last_name",
   *                    type="string"),
   *             @OA\Property(
   *                    property="first_name",
   *                    type="string"),
   *            )
   *        )
   *    ),
   *    @OA\Response(
   *        response = 201,
   *        description = "Created"),
   *    @OA\Response(
    *       response = 422,
    *       description = "Invalid data")
   *)
   */
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

     /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Updates a user",
     *     @OA\Parameter(
    *           description="Id of user to update",
    *           in="path",
    *           name="id",
    *           required=true,
    *           @OA\Schema(type="integer")),
     *     @OA\RequestBody(
   *            @OA\MediaType(
   *                mediaType="application\json",
   *                @OA\Schema(
   *                    @OA\Property(
   *                        property="login",
   *                        type="string"),
   *                    @OA\Property(
   *                        property="password",
   *                        type="string"),
   *                    @OA\Property(
   *                        property="email",
   *                        type="string"),
   *                    @OA\Property(
   *                        property="last_name",
   *                        type="string"),
   *                    @OA\Property(
   *                        property="first_name",
   *                        type="string"),
   *                )   
   *            )
   *        ),
   *        @OA\Response(
     *         response=200,
     *         description="OK"),
     *      @OA\Response(
    *           response = 404,
    *           description = "Not found"),
    *       @OA\Response(
    *           response = 422,
    *           description = "Invalid data")
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
        }
        catch(QueryException $ex)
        {
            abort(NOT_FOUND, 'Invalid id');
        }  

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

            $user->delete();
            $user->insert($request->all());
        }
        catch(Exception $ex)
        {
            abort(SERVER_ERROR, 'Server error');
        }
    }

    /**
    *@OA\GET(
    *path="/api/users/{id}/favorite_language",
    *tags={"Users"},
    *summary="Gets a user's favorite language",
    *@OA\Parameter(
    *   description="Id of user",
    *   in="path",
    *   name="id",
    *   required=true,
    *   @OA\Schema(type="integer")),
    *@OA\Response(
    *    response = 200,
    *    description = "OK")
    *)
    */
    public function favoriteLanguage($id)
    {
        try
        {
            $languagesArray = array();
            $filmsid = DB::table('critics')->where('user_id', $id)->get('film_id')->all();
            foreach($filmsid as $filmid)
            {
                $languageid = DB::table('films')->where('id', $filmid->film_id)->get('language_id')[0];
                array_push($languagesArray, $languageid->language_id);
            }
            $values = array_count_values($languagesArray);
            arsort($values);
            $mostPopular = array_slice(array_keys($values), 0, 1, true);
            
            $language = DB::table('languages')->where('id', $mostPopular)->get('name')[0];
            return (response()->json(['language' => $language]))->setStatusCode(OK);
        }
        catch(Exception $ex)
        {
            abort(SERVER_ERROR, 'Server error');
        }
    }
}
