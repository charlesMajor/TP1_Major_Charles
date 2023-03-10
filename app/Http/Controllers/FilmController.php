<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\FilmResource;
use App\Http\Resources\CriticResource;
use App\Models\Film;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    /**
    *@OA\GET(
    *path="/api/films",
    *tags={"Films"},
    *summary="Gets list of movies",
    *@OA\Parameter(
    *   description="Keyword in wanted movie's name",
    *   name="keyword",
    *   in="query"),
    *@OA\Parameter(
    *   description="Rating of the wanted movie",
    *   name="rating",
    *   in="query"),
    *@OA\Parameter(
    *   description="Minimum length of the wanted movie",
    *   name="minLength",
    *   in="query"),
    *@OA\Parameter(
    *   description="Maximum length of the wanted movie",
    *   name="maxLength",
    *   in="query"),
    *@OA\Response(
    *    response = 200,
    *    description = "OK")
    *)
    */
    public function index(Request $request)
    {
        try
        {
            return FilmResource::collection(FILM::title($request)->rating($request)->min($request)->max($request)->paginate(PAGINATION))->response()->setStatusCode(OK);
        }
        catch(Exception $ex)
        {
            abort(SERVER_ERROR, 'Server error');
        }
    }

    /**
    *@OA\GET(
    *path="/api/films/{id}/average_score",
    *tags={"Films"},
    *summary="Gets a movie's average score",
    *@OA\Parameter(
    *   description="Id of movie",
    *   in="path",
    *   name="id",
    *   required=true,
    *   @OA\Schema(type="integer")),
    *@OA\Response(
    *    response = 200,
    *    description = "OK")
    *)
    */
    public function averageScore($id)
    {
        try
        {
            $average = DB::table('critics')->where('film_id', $id)->avg('score');
            return (response()->json(['score' => $average]))->setStatusCode(OK);
        }
        catch(Exception $ex)
        {
            abort(SERVER_ERROR, 'Server error');
        }
    }
}
