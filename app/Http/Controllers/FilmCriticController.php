<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CriticResource;
use App\Models\Film;

class FilmCriticController extends Controller
{
    /**
    *@OA\GET(
    *path="/api/films/{id}/critics",
    *tags={"Films"},
    *summary="Gets a movie's critics",
    *@OA\Parameter(
    *   description="Id of movie",
    *   in="path",
    *   name="id",
    *   required=true,
    *   @OA\Schema(type="integer")),
    *@OA\Response(
    *    response = 200,
    *    description = "OK"),
    *@OA\Response(
    *    response = 404,
    *    description = "Not found")
    *)
    */
    public function show($id)
    {
        try
        {
            return CriticResource::collection((Film::findOrFail($id))->critics()->paginate(PAGINATION))->response()->setStatusCode(OK);
        }
        catch(QueryException $ex)
        {
            abort(NOT_FOUND, 'Invalid Id');
        }
        catch(Exception $ex)
        {
            abort(SERVER_ERROR, 'Server error');
        }
    }
}
