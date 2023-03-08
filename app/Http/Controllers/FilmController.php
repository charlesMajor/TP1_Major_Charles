<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\FilmResource;
use App\Http\Resources\CriticResource;
use App\Models\Film;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
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
