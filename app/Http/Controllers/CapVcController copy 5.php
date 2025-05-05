<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\TeamCretedByUsers;

class CapVcController extends Controller
{
    protected $allPlayerList = [];
    protected $playerList = [];
    protected $newPlayerList = [];
    protected $captain;
    protected $viceCaptain;

    public function capVcTeam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'series_id' => 'required|integer',
            'player_details' => 'required|array|size:11',
            'cap_vc_details' => 'required|array|size:2',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()], 400);
        }

        $seriesID = $request->series_id;
        $selectedPlayers = $request->player_details;
        $capVcDetails = $request->cap_vc_details;

        $playerDetails = $this->playerDetails($selectedPlayers, $seriesID);
        $capVcDetails = $this->playerCapvcDetails($capVcDetails, $seriesID);

        $this->captain = $capVcDetails[0];
        $this->viceCaptain = $capVcDetails[1];

        $positions = DB::table('positions')
            ->select('position_name')
            ->where('game_name', 1)
            ->orderByRaw('FIELD(position_name, "Wk", "Bat", "All", "Bowl")')
            ->get()
            ->pluck('position_name')
            ->toArray();

        $teamCombinations = $this->generateCombinations($playerDetails, $positions);

        $this->saveGeneratedTeam($request);

        return response()->json([
            'code' => 200,
            'success' => true,
            'captain' => $this->captain,
            'vice_captain' => $this->viceCaptain,
            'message' => 'Player details fetched successfully',
            'data' => $teamCombinations,
        ]);
    }

    private function generateCombinations($players, $positions)
    {
        $validTeams = [];
        foreach ($this->getCombinations(array_keys($players), 9) as $combination) {
            $team = [$this->captain, $this->viceCaptain];
            $positionCounts = array_fill_keys($positions, 0);

            foreach ($combination as $index) {
                $player = $players[$index];
                $team[] = $player;
                $positionCounts[$player->position]++;
            }

            if ($this->isValidTeam($positionCounts)) {
                $validTeams[] = $team;
            }
        }
        return $validTeams;
    }

    private function isValidTeam($counts)
    {
        return $counts['Wk'] > 0 && $counts['Bat'] > 0 && $counts['All'] > 0 && $counts['Bowl'] > 0;
    }

    private function getCombinations($elements, $size)
    {
        if ($size === 0) return [[]];
        if (empty($elements)) return [];

        $first = array_shift($elements);
        $withFirst = array_map(fn($combo) => array_merge([$first], $combo), $this->getCombinations($elements, $size - 1));
        $withoutFirst = $this->getCombinations($elements, $size);

        return array_merge($withFirst, $withoutFirst);
    }

    private function playerDetails($playerIds, $seriesID)
    {
        return DB::table('players')
            ->join('positions', 'players.position_id', '=', 'positions.id')
            ->join('series', 'players.series_id', '=', 'series.id')
            ->join('teams', 'players.team_id', '=', 'teams.id')
            ->whereIn('players.id', $playerIds)
            ->where('players.series_id', $seriesID)
            ->orderBy('positions.id')
            ->get();
    }

    private function playerCapvcDetails($playerIds, $seriesID)
    {
        return DB::table('players')
            ->join('positions', 'players.position_id', '=', 'positions.id')
            ->join('series', 'players.series_id', '=', 'series.id')
            ->join('teams', 'players.team_id', '=', 'teams.id')
            ->whereIn('players.id', $playerIds)
            ->where('players.series_id', $seriesID)
            ->orderByRaw("FIELD(players.id, " . implode(',', $playerIds) . ")")
            ->get();
    }

    private function saveGeneratedTeam($request)
    {
        TeamCretedByUsers::create([
            'user_ip' => $request->ip(),
            'series_id' => $request->series_id,
            'cap_vc_details' => implode(',', $request->cap_vc_details),
            'players_details' => implode(',', $request->player_details),
        ]);
    }
}
