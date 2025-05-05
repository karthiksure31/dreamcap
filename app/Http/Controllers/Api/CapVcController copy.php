<?php

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Players;
use App\Models\Positions;
use Illuminate\Support\Facades\DB;

class CapVcController extends BaseController
{
    //
    //
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    function capVcTeam(Request $request)
    {
        $selectedPlayers = ['4', '14', '3', '5', '12', '6', '21', '8', '10', '11', '22'];

        $playerList = array();
        $addIndexOnly = array();
        $addIndex = 1;
        $playerDetails = DB::table('players')
            ->select(
                'players.id',
                'series.series_name',
                'teams.team_name',
                DB::raw('CONCAT(players.player_name," | ",players.credit_points," | ",positions.position_name) as player_details')
            )
            ->join('positions', 'players.position_id', '=', 'positions.id')
            ->join('series', 'players.series_id', '=', 'series.id')
            ->join('teams', 'players.team_id', '=', 'teams.id')
            ->whereIn('players.id', $selectedPlayers)
            ->orderBy('positions.id')
            ->get()->toArray();
        if (isset($playerDetails)) {
            foreach ($playerDetails as $value) {
                $playerList[$addIndex] = $value->player_details;
                array_push($addIndexOnly, $addIndex);
                $addIndex++;
            }
        }

        echo "<pre>";
        print_r($playerList);
        print_r($addIndexOnly);
        exit;
    }
}
