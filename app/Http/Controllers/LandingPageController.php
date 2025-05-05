<?php

namespace App\Http\Controllers;

use App\Models\MatchSchedules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LandingPageController extends Controller
{
    //
    public function index()
    {
        $dateNow = Carbon::now();
        $dateStart = $dateNow->toDateTimeString();

        $daysToAdd = 2;
        $end = $dateNow->addDays($daysToAdd);
        $dateEnd = $end->toDateTimeString();

        $getScheduleMatch =  DB::table('match_schedules as ms')
            ->select('ms.id', 'ms.series_id','ms.schedule_date', 'ms.team_id_one', 'ms.team_id_two', 'ms.match_no', 't1.team_name as team1','t1.team_logo as team1_logo', 't2.team_name as team2','t2.team_logo as team2_logo')
            ->leftjoin('teams as t1', 't1.id', '=', 'ms.team_id_one')
            ->leftjoin('teams as t2', 't2.id', '=', 'ms.team_id_two')
            ->whereBetween(DB::raw('ms.schedule_date'), [$dateStart, $dateEnd])
            ->get();
            // dd($getScheduleMatch);
        return view('landing-pages.index', ['match_details' => $getScheduleMatch]);
    }
    public function createTeam($id)
    {
        $matchSchedules = MatchSchedules::find($id);

        $teamOne =  DB::table('players as pl')
            ->select('pl.id', 'pl.player_name','pl.image', 'pl.credit_points','pl.team_id', 'ps.position_name', 't.team_name')
            ->leftjoin('teams as t', 't.id', '=', 'pl.team_id')
            ->leftjoin('positions as ps', 'ps.id', '=', 'pl.position_id')
            ->where([
                ['pl.series_id', '=', $matchSchedules->series_id],
                ['pl.team_id', '=', $matchSchedules->team_id_one]
            ])
            ->orderBy('ps.id')
            ->get();
        $teamTwo =  DB::table('players as pl')
            ->select('pl.id', 'pl.player_name','pl.image', 'pl.credit_points','pl.team_id', 'ps.position_name', 't.team_name')
            ->leftjoin('teams as t', 't.id', '=', 'pl.team_id')
            ->leftjoin('positions as ps', 'ps.id', '=', 'pl.position_id')
            ->where([
                ['pl.series_id', '=', $matchSchedules->series_id],
                ['pl.team_id', '=', $matchSchedules->team_id_two]
            ])
            ->orderBy('ps.id')
            ->get();
        $team_one_name = isset($teamOne[0]->team_name) ? $teamOne[0]->team_name : '';
        $team_two_name = isset($teamTwo[0]->team_name) ? $teamTwo[0]->team_name : '';
        $team_one_id = $teamOne[0]->team_id;
        $team_two_id = $teamTwo[0]->team_id;
        $series_id = $matchSchedules->series_id;

        //         +"id": 1
        //   +"player_name": "Rohit Sharma "
        //   +"credit_points": 10.5
        //   +"position_name": "Bat"
        //   +"team_name": "India"
        // dd($teamOne);
        return view('landing-pages.create_team', [
            'team_one' => $teamOne,
            'team_one_name' => $team_one_name,
            'team_one_id' => $team_one_id,
            'team_two' => $teamTwo,
            'team_two_name' => $team_two_name,
            'team_two_id' => $team_two_id,
            'series_id' => $series_id,
            
        ]);
    }
}
