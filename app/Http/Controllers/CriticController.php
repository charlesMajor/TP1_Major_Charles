<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CriticResource;
use App\Models\Critic;

class CriticController extends Controller
{

     /**
     * @OA\Delete(
     *      path="/api/critics/{id}",
     *      tags={"Critics"},
     *      summary="Delete existing Critic",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id of critic to delete",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Ok"
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *       )
     * )
     */
    public function destroy($id)
    {
        try
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
        catch(Exception $ex)
        {
            abort(SERVER_ERROR, 'Server error');
        }
        
    }
}
