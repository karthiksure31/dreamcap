<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\TeamCretedByUsers;
use Exception;
use App\Helpers\CommonHelper;
use Illuminate\Support\Facades\Log;

class CapVcController extends Controller
{
    protected $counter = 0;
    protected $captainName;
    protected $captainConcatName;
    protected $vcCaptainName;
    protected $vcCaptainConcatName;
    protected $newPlayerList = array();
    protected $allPlayerList = array();
    protected $playerList = array();
    //
    protected CommonHelper $commonHelper;

    public function __construct(CommonHelper $commonHelper)
    {
        $this->commonHelper = $commonHelper;
    }
    function capVcTeam(Request $request)
    {
        try {
            // dd($request);
            // dd($request->player_details);
            // $seriesID = 1;
            // $cap_vc_details = ["15", "19"];
            // $player_details = ['4', '14', '3', '5', '12', '6', '21', '8', '10', '11', '22'];


            $validator = \Validator::make($request->all(), [
                'series_id' => 'required',
                'player_details' => 'required',
                'cap_vc_details' => 'required'
            ]);
            if (!$validator->passes()) {
                return response()->json(['error' => $validator->errors()->toArray()]);
            } else {
                $seriesID = $request->series_id;
                $cap_vc_details = $request->cap_vc_details;
                $player_details = $request->player_details;
                // $selectedPlayers = $request->player_details;
                // $capVcDetails = $request->cap_vc_details;
                $selectedPlayers = $player_details;
                $capVcDetails = $cap_vc_details;

                $playerListNames = array();
                $addIndexOnly = array();
                $addIndex = 1;

                $playerDetails =   $this->playerDetails($selectedPlayers, $seriesID);
                $capVcDetails =   $this->playerCapvcDetails($capVcDetails, $seriesID);
                // dd($playerDetails);
                $this->generateTeamSave($request);
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


                // echo "<pre>";
                // print_r($this->allPlayerList);
                // // print_r($addIndexOnly);
                // exit;
                $response = [
                    'code' => 200,
                    'success' => true,
                    'captain' => $this->captainName,
                    'vc' => $this->vcCaptainName,
                    'message' => "Player Details Fetch Successfully",
                    'data'    => $this->allPlayerList
                ];
                return response()->json($response);
            }
        } catch (Exception $error) {
            return $this->commonHelper->generalReturn('403', 'error', $error, 'Error in capVcTeam');
        }
    }

    // 
    function printCombination($totalNoOfPlayers, $sizeOfArr, $noOfChoosingPlayer)
    {
        try {
            // A temporary array to
            // store all combination    
            // one by one
            $data = array();

            // Print all combination
            // using temprary array 'data[]'
            // 6 arguments
            $this->combinationUtil($totalNoOfPlayers, $data, 0, $sizeOfArr - 1, 0, $noOfChoosingPlayer);
        } catch (Exception $error) {
            return $this->commonHelper->generalReturn('403', 'error', $error, 'Error in printCombination');
        }
    }
    //
    function combinationUtil($totalNoOfPlayers, $data, $start, $end, $index, $noOfChoosingPlayer)
    {
        // Current combination is ready
        // to be printed, print it
        // $inc = 0;
        try {
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
                // Log::info($captanDetails);
                // Log::info($viceCaptanDetails);
                // $this->captainName = $captanDetails[0] . '(' . $captanDetails[2] . ')';
                // $this->vcCaptainName = $viceCaptanDetails[0] . '(' . $viceCaptanDetails[2] . ')';
                $this->captainName = $captanDetails;
                $this->vcCaptainName = $viceCaptanDetails;
                
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

                    if ($totalCredit <= 100 && ($wkCount > 0) && ($batCount > 0) && ($allCount > 0) && ($bowlCount > 0)) {
                        $object = new \stdClass();
                        $newArry = array();
                        $i = 0;
                        $countFirstTeam = 0;
                        $countSecondTeam = 0;

                        $firstTeamID = "";
                        $secondTeamID = "";
                        if (trim($captanDetails[3]) == trim($viceCaptanDetails[3])) {
                            $countFirstTeam += 2;
                            $firstTeamID = trim($captanDetails[3]); // here save teamID
                        } else {
                            $countFirstTeam += 1;
                            $countSecondTeam += 1;
                            $firstTeamID = trim($captanDetails[3]); // here save teamID
                            $secondTeamID = trim($viceCaptanDetails[3]); // here save teamID
                        }

                        // $object->captain = $this->captainName;
                        // $object->vc = $this->vcCaptainName;
                        // $object->totalCredit = $totalCredit;
                        // dd(count($this->newPlayerList));
                        $countPlayer = count($this->newPlayerList);
                        // $newArry['captain'] = $this->captainName;
                        // $newArry['vc'] = $this->vcCaptainName;
                        // count 
                        foreach ($this->newPlayerList as $key => $value) {
                            $playerDetails = explode('|', $value);
                            // dd($playerDetails);
                            // $name = $playerDetails[0] . '(' . $playerDetails[2] . ')';
                            if (trim($playerDetails[3]) == $firstTeamID) {
                                $countFirstTeam += 1;
                            } else {
                                $countSecondTeam += 1;
                            }
                            // $object->names[$i] = $this->captainName;
                            // $object->names[$i] = $this->vcCaptainName;
                            // if (($countPlayer - 1) == $i) {
                            //     $object->countFirstTeam = $countFirstTeam;
                            //     $object->countSecondTeam = $countSecondTeam;
                            // }
                            // $object->names[$i] = $name;
                            $newArry[$key] = $value;


                            $i++;
                        }
                        // print_r($countFirstTeam);
                        // print_r($countSecondTeam);exit;
                        if (($countFirstTeam >= 1 && $countFirstTeam <= 10) && ($countSecondTeam >= 1 && $countSecondTeam <= 10)) {
                            // $this->allPlayerList[] = $object;
                            // Log::info($this->allPlayerList);
                            $this->counter++;
                            array_unshift($newArry, $this->counter);
                            $this->allPlayerList[] = $newArry;
                        }
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
        } catch (Exception $error) {
            return $this->commonHelper->generalReturn('403', 'error', $error, 'Error in combinationUtil');
        }
    }
    function matchValues($matchvalues)
    {
        try {
            $this->playerList;
            $this->newPlayerList;

            foreach ($this->playerList as $key => $value) {
                if ($key == $matchvalues) {
                    array_push($this->newPlayerList, $value);
                }
            }
        } catch (Exception $error) {
            return $this->commonHelper->generalReturn('403', 'error', $error, 'Error in matchValues');
        }
    }
    // return query for players details 
    function playerDetails($playerIN, $seriesID)
    {
        try {
            $playerDetails = DB::table('players')
                ->select(
                    'players.id',
                    'series.series_name',
                    'teams.team_name',
                    'teams.team_name',
                    // DB::raw('CONCAT(players.player_name," | ",players.credit_points," | ",positions.position_name," | ",players.team_id) as player_details')
                    DB::raw('CONCAT(players.player_name, " | ", players.credit_points, " | ", positions.position_name, " | ", players.team_id, " | ", players.image) as player_details')
                )
                ->join('positions', 'players.position_id', '=', 'positions.id')
                ->join('series', 'players.series_id', '=', 'series.id')
                ->join('teams', 'players.team_id', '=', 'teams.id')
                ->whereIn('players.id', $playerIN)
                ->where('players.series_id', $seriesID)
                ->orderBy('positions.id')
                ->get()->toArray();
            return $playerDetails;
        } catch (Exception $error) {
            return $this->commonHelper->generalReturn('403', 'error', $error, 'Error in playerDetails');
        }
    }
    // player capvc
    function playerCapvcDetails($playerIN, $seriesID)
    {
        try {
            $ids_ordered = implode(',', $playerIN);

            $playerDetails = DB::table('players')
                ->select(
                    'players.id',
                    'series.series_name',
                    'teams.team_name',
                    'teams.team_name',
                    // DB::raw('CONCAT(players.player_name," | ",players.credit_points," | ",positions.position_name," | ",players.team_id) as player_details')
                    DB::raw('CONCAT(players.player_name, " | ", players.credit_points, " | ", positions.position_name, " | ", players.team_id, " | ", players.image) as player_details')
                )
                ->join('positions', 'players.position_id', '=', 'positions.id')
                ->join('series', 'players.series_id', '=', 'series.id')
                ->join('teams', 'players.team_id', '=', 'teams.id')
                ->whereIn('players.id', $playerIN)
                ->where('players.series_id', $seriesID)
                // ->orderBy('positions.id')
                ->orderByRaw("FIELD(players.id, $ids_ordered)")
                ->get()->toArray();
            return $playerDetails;
        } catch (Exception $error) {
            return $this->commonHelper->generalReturn('403', 'error', $error, 'Error in playerCapvcDetails');
        }
    }
    // Function to get the client IP address
    function get_client_ip()
    {
        try {
            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP'))
                $ipaddress = getenv('HTTP_CLIENT_IP');
            else if (getenv('HTTP_X_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else if (getenv('HTTP_X_FORWARDED'))
                $ipaddress = getenv('HTTP_X_FORWARDED');
            else if (getenv('HTTP_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if (getenv('HTTP_FORWARDED'))
                $ipaddress = getenv('HTTP_FORWARDED');
            else if (getenv('REMOTE_ADDR'))
                $ipaddress = getenv('REMOTE_ADDR');
            else
                $ipaddress = 'UNKNOWN';
            return $ipaddress;
        } catch (Exception $error) {
            return $this->commonHelper->generalReturn('403', 'error', $error, 'Error in get_client_ip');
        }
    }
    // save to db for generate teams
    function generateTeamSave($req)
    {
        try {
            // save to db in given request
            $get_client_ip = $this->get_client_ip();
            $capVcStr = implode(',', $req->cap_vc_details);
            $seriesID = $req->series_id;
            $playerDetailStr = implode(',', $req->player_details);

            $teams = new TeamCretedByUsers();
            $teams->user_ip = $get_client_ip;
            $teams->series_id = $seriesID;
            $teams->cap_vc_details = $capVcStr;
            $teams->players_details = $playerDetailStr;
            $teams->save();
        } catch (Exception $error) {
            return $this->commonHelper->generalReturn('403', 'error', $error, 'Error in get_client_ip');
        }
    }
}
