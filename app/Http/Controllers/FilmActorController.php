<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ActorResource;
use App\Models\Film;

class FilmActorController extends Controller
{
    public function index($id)
    {
        try
        {
            return ActorResource::collection((Film::findOrFail($id))->actors()->paginate(PAGINATION))->response()->setStatusCode(OK);
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
