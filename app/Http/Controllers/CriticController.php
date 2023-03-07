<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CriticResource;
use App\Models\Critic;

class CriticController extends Controller
{
    public function destroy($id)
    {
        try
        {
            $critic = Critic::findOrFail($id);
            $critic->delete();
        }
        catch(QueryException $ex)
        {
            abort(NOT_FOUND, 'Invalide Id');
        }
    }
}
