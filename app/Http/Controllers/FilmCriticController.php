<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CriticResource;
use App\Models\Film;

class FilmCriticController extends Controller
{
    public function index($id)
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
