<?php

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Players;
use App\Models\Positions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CricketController extends BaseController
{
    protected $counter = 0;
    protected $captainName;
    protected $captainConcatName;
    protected $vcCaptainName;
    protected $vcCaptainConcatName;
    protected $newPlayerList = array();
    protected $allPlayerList = array();
    protected $playerList = array();

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    function capVcTeam(Request $request)
    {

        // dd($request->player_details);
        // $selectedPlayers = ['4', '14', '3', '5', '12', '6', '21', '8', '10', '11', '22'];
        $validator = \Validator::make($request->all(), [
            'player_details' => 'required',
            'cap_vc_details' => 'required'
        ]);
        if (!$validator->passes()) {
            return $this->send422Error('Validation error.', ['error' => $validator->errors()->toArray()]);
        } else {
            $selectedPlayers = $request->player_details;
            $capVcDetails = $request->cap_vc_details;

            $playerListNames = array();
            $addIndexOnly = array();
            $addIndex = 1;

            $playerDetails =   $this->playerDetails($selectedPlayers);
            $capVcDetails =   $this->playerDetails($capVcDetails);

            $this->captainConcatName = $capVcDetails[0]->player_details;
            $this->vcCaptainConcatName = $capVcDetails[1]->player_details;

            if (isset($playerDetails)) {
                foreach ($playerDetails as $value) {
                    $playerListNames[$addIndex] = $value->player_details;
                    array_push($addIndexOnly, $addIndex);
                    $addIndex++;
                }
            }

            $totalNoOfPlayers = $addIndexOnly;
            $noOfChoosingPlayer = 9;
            // count size array
            $sizeOfArr = sizeof($totalNoOfPlayers);
            $this->playerList = $playerListNames;

            $this->printCombination($totalNoOfPlayers, $sizeOfArr, $noOfChoosingPlayer);

            $response = [
                'code' => 200,
                'success' => true,
                'captain' => $this->captainName,
                'vc' => $this->vcCaptainName,
                'message' => "Player Details Fetch Successfully",
                'data'    => $this->allPlayerList
            ];
            return response()->json($response);
            // echo "<pre>";
            // print_r($this->playerList);
            // print_r($addIndexOnly);
            // exit;
        }
    }

    // 
    function printCombination($totalNoOfPlayers, $sizeOfArr, $noOfChoosingPlayer)
    {
        // A temporary array to
        // store all combination    
        // one by one
        $data = array();

        // Print all combination
        // using temprary array 'data[]'
        // 6 arguments
        $this->combinationUtil($totalNoOfPlayers, $data, 0, $sizeOfArr - 1, 0, $noOfChoosingPlayer);
    }
    //
    function combinationUtil($totalNoOfPlayers, $data, $start, $end, $index, $noOfChoosingPlayer)
    {
        // Current combination is ready
        // to be printed, print it
        // $inc = 0;

        if ($index == $noOfChoosingPlayer) {
            $this->counter;
            $this->newPlayerList;

            $captain = $this->captainConcatName;
            $viceCaptain = $this->vcCaptainConcatName;

            // player positions
            $positions = DB::table('positions')
                ->select('position_name')
                ->where('game_name', 1)
                ->orderBy(DB::raw('FIELD(position_name, "Wk","Bat", "All", "Bowl")'))
                ->get();
            $Wk = $positions[0]->position_name;
            $Bat  = $positions[1]->position_name;
            $All  = $positions[2]->position_name;
            $Bowl = $positions[3]->position_name;
            

            $captanDetails = explode('|', $captain);
            $viceCaptanDetails = explode('|', $viceCaptain);
            $captanCreditPoint = (float) $captanDetails[1];
            $viceCaptanCreditPoint = (float) $viceCaptanDetails[1];

            $captanPositions = $captanDetails[2];
            $vicePositions = $viceCaptanDetails[2];

            // add cap vc names
            $this->captainName = $captanDetails[0] . '(' . $captanDetails[2] . ')';
            $this->vcCaptainName = $viceCaptanDetails[0] . '(' . $viceCaptanDetails[2] . ')';

            for ($j = 0; $j < $noOfChoosingPlayer; $j++) {
                $this->matchValues($data[$j]);
            }

            if (!empty($this->newPlayerList)) {
                $totalCredit = 0;
                $wkCount = 0;
                $batCount = 0;
                $allCount = 0;
                $bowlCount = 0;
                // captain position increment
                if (trim($captanPositions) == trim($Wk)) {
                    $wkCount++;
                }
                if (trim($captanPositions) == trim($Bat)) {
                    $batCount++;
                }
                if (trim($captanPositions) == trim($All)) {
                    $allCount++;
                }
                if (trim($captanPositions) == trim($Bowl)) {
                    $bowlCount++;
                }
                // vccaptain position increment
                if (trim($vicePositions) == trim($Wk)) {
                    $wkCount++;
                }
                if (trim($vicePositions) == trim($Bat)) {
                    $batCount++;
                }
                if (trim($vicePositions) == trim($All)) {
                    $allCount++;
                }
                if (trim($vicePositions) == trim($Bowl)) {
                    $bowlCount++;
                }
                $totalCredit += $captanCreditPoint;
                $totalCredit += $viceCaptanCreditPoint;

                foreach ($this->newPlayerList as $player) {

                    $playerDetails = explode('|', $player);

                    $creditPoint = (float) $playerDetails[1];
                    $playerPositions = $playerDetails[2];

                    if (trim($playerPositions) == trim($Wk)) {
                        $wkCount++;
                    }
                    if (trim($playerPositions) == trim($Bat)) {
                        $batCount++;
                    }
                    if (trim($playerPositions) == trim($All)) {
                        $allCount++;
                    }
                    if (trim($playerPositions) == trim($Bowl)) {
                        $bowlCount++;
                    }

                    $totalCredit += $creditPoint;
                }

                if ($totalCredit <= 100 && ($wkCount > 0 && $wkCount <= 4) && ($batCount >= 3 && $batCount <= 6) && ($allCount > 0 && $allCount <= 4) && ($bowlCount >= 3 && $bowlCount <= 6)) {
                    $this->counter++;
                    $object = new \stdClass();

                    $i = 0;

                    foreach ($this->newPlayerList as $key => $value) {
                        $playerDetails = explode('|', $value);
                        $name = $playerDetails[0] . '(' . $playerDetails[2] . ')';
                        $object->names[$i] = $name;
                        $i++;
                    }
                    $this->allPlayerList[] = $object;
                }
            }

            $this->newPlayerList = [];
        }

        // replace index with all
        // possible elements. The
        // condition "end-i+1 >=
        // r-index" makes sure that
        // including one element at
        // index will make a combination
        // with remaining elements at
        // remaining valueitionsvalue
        for ($i = $start; $i <= $end && $end - $i + 1 >= $noOfChoosingPlayer - $index; $i++) {
            $data[$index] = $totalNoOfPlayers[$i];
            $this->combinationUtil($totalNoOfPlayers, $data, $i + 1, $end, $index + 1, $noOfChoosingPlayer);
        }
    }
    function matchValues($matchvalues)
    {
        $this->playerList;
        $this->newPlayerList;

        foreach ($this->playerList as $key => $value) {
            if ($key == $matchvalues) {
                array_push($this->newPlayerList, $value);
            }
        }
    }
    // return query for players details 
    function playerDetails($playerIN)
    {
        $playerDetails = DB::table('players')
            ->select(
                'players.id',
                'series.series_name',
                'teams.team_name',
                'teams.team_name',
                DB::raw('CONCAT(players.player_name," | ",players.credit_points," | ",positions.position_name) as player_details')
            )
            ->join('positions', 'players.position_id', '=', 'positions.id')
            ->join('series', 'players.series_id', '=', 'series.id')
            ->join('teams', 'players.team_id', '=', 'teams.id')
            ->whereIn('players.id', $playerIN)
            ->orderBy('positions.id')
            ->get()->toArray();
        return $playerDetails;
    }
}
