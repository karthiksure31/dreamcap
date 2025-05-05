<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MatchSchedules;
use App\Models\Players;
use App\Models\Positions;
use App\Models\Series;
use App\Models\Teams;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class MatchScheduleController extends Controller
{
    //
    function matchScheduleIndex()
    {
        $series = Series::select('id', 'series_name')->get();
        return view(
            'admin.match_schedule.index',
            [
                'series' => $series
            ]
        );
    }
    // getTeamList
    public function getTeamList(Request $request)
    {
        $series_id = $request->series_id;
        $teamDetails = Teams::select('id', 'team_name')->where('series_id', $series_id)->get();
        return response()->json(['details' => $teamDetails]);
    }
    // get schedule match
    function getMatchScheduleList(Request $request)
    {

        $getSchedule =  DB::table('match_schedules as ms')
            ->select(
                'ms.id',
                'ms.match_no',
                DB::raw('DATE_FORMAT(ms.schedule_date, "%d-%b-%Y %r") as schedule_date'),
                // 'date_format(ms.schedule_date, '%a %D %b %Y')',
                't1.team_name as team_id_one_name',
                't2.team_name as team_id_two_name',
                's.series_name',
                't1.team_logo as team_logo_one',
                't2.team_logo as team_logo_two',
            )
            ->join('teams as t1', 't1.id', '=', 'ms.team_id_one')
            ->join('teams as t2', 't2.id', '=', 'ms.team_id_two')
            ->join('series as s', 's.id', '=', 'ms.series_id')
            ->where('ms.status','0')
            ->orderBy('ms.schedule_date', 'desc')
            ->get();

        // $resultArray =   json_encode($getPlayers);
        // return $getPlayers;
        return DataTables::of(json_decode($getSchedule, true))
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group">
                            <button class="btn btn-sm btn-primary" data-id="' . $row['id'] . '" id="editMatchScheduleBtn">Update</button>
                            <button class="btn btn-sm btn-danger" data-id="' . $row['id'] . '" id="deleteMatchScheduleBtn">Delete</button>
                        </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    // get row details
    public function getMatchScheduleDetails(Request $request)
    {
        $id = $request->id;
        $rowDetails = MatchSchedules::find($id);
        return response()->json(['details' => $rowDetails]);
    }
    // add players
    public function addMatchSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'series_id' => 'required',
            'team_id_one' => 'required',
            'team_id_two' => 'required',
            'schedule_date' => 'required',
        ]);
        if (!$validator->passes()) {
            return response()->json('Validation error.', ['error' => $validator->errors()->toArray()]);
        } else {
            $MatchSchedules = new MatchSchedules();
            $MatchSchedules->series_id = $request->series_id;
            $MatchSchedules->team_id_one = $request->team_id_one;
            $MatchSchedules->team_id_two = $request->team_id_two;
            $MatchSchedules->schedule_date = $request->schedule_date;
            $MatchSchedules->match_no = isset($request->match_no) ? $request->match_no : 0;
            $query = $MatchSchedules->save();

            if (!$query) {
                return response()->json(['code' => 500, 'message' => 'Something went wrong']);
            } else {
                return response()->json(['code' => 200, 'message' => 'Add Match Schedule successfully']);
            }
        }
    }
    // updatePlayer
    public function updateMatchSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'series_id' => 'required',
            'team_id_one' => 'required',
            'team_id_two' => 'required',
            'schedule_date' => 'required',
        ]);
        if (!$validator->passes()) {
            return response()->json('Validation error.', ['error' => $validator->errors()->toArray()]);
        } else {

            $MatchSchedules = MatchSchedules::find($request->id);
            $MatchSchedules->series_id = $request->series_id;
            $MatchSchedules->team_id_one = $request->team_id_one;
            $MatchSchedules->team_id_two = $request->team_id_two;
            $MatchSchedules->schedule_date = $request->schedule_date;
            $MatchSchedules->match_no = isset($request->match_no) ? $request->match_no : 0;
            $query = $MatchSchedules->save();

            if (!$query) {
                return response()->json(['code' => 500, 'message' => 'Something went wrong']);
            } else {
                return response()->json(['code' => 200, 'message' => 'Updated Match Schedule successfully']);
            }
        }
    }
    // delete
    public function deleteMatchSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if (!$validator->passes()) {
            return response()->json('Validation error.', ['error' => $validator->errors()->toArray()]);
        } else {
            $MatchSchedules = MatchSchedules::find($request->id);
            $MatchSchedules->status = "1";
            $query = $MatchSchedules->save();

            if ($query) {
                return response()->json(['code' => 200, 'message' => 'Match Schedule has been successfully deleted']);
            } else {
                return response()->json(['code' => 500, 'message' => 'Something went wrong']);
            }
        }
    }
}
