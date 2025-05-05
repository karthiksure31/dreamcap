<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Series;
use App\Models\Teams;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TeamsController extends Controller
{
    function teamsIndex()
    {
        $series = Series::select('id', 'series_name')->get();
        return view(
            'admin.teams.index',
            [
                'series' => $series
            ]
        );
    }
    // Get List of Teams
    public function getTeamsList(Request $request)
    {
        $getTeams = Teams::query()
            ->leftJoin('series', 'teams.series_id', '=', 'series.id')
            ->select('teams.*', 'series.series_name');
        return DataTables::of($getTeams)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group">
                        <button class="btn btn-sm btn-primary" data-id="' . $row->id . '" id="editTeamsBtn">Update</button>
                        <button class="btn btn-sm btn-danger" data-id="' . $row->id . '" id="deleteTeamsBtn">Delete</button>
                    </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    // get row details
    public function getTeamsDetails(Request $request)
    {
        $id = $request->id;
        $playerDetails = Teams::find($id);
        return response()->json(['details' => $playerDetails]);
    }
    // Add Teams
    public function addTeams(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'team_name' => 'required|string|max:255',
            'series_id' => 'required|exists:series,id',
            'team_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 422, 'message' => $validator->errors()->first()]);
        }

        // Create a new team instance
        $team = new Teams();
        $team->team_name = $request->team_name;
        $team->series_id = $request->series_id;

        // Handle the team logo upload
        if ($request->hasFile('team_logo')) {
            $file = $request->file('team_logo');
            $fileName = 'team_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('team_logos');

            // Ensure the directory exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            // Move the file to the destination path
            $file->move($destinationPath, $fileName);

            // Save the file path and original name in the database
            $team->team_logo = 'team_logos/' . $fileName;
            $team->team_logo_name = $file->getClientOriginalName();
        }

        // Save the team instance to the database
        if ($team->save()) {
            return response()->json(['code' => 200, 'message' => 'New Team has been successfully saved']);
        }

        return response()->json(['code' => 500, 'message' => 'Something went wrong']);
    }
    public function updateTeams(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:teams,id',
            'team_name' => 'required|string|max:255',
            'series_id' => 'required|exists:series,id',
            'team_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 422, 'message' => $validator->errors()->first()]);
        }

        // Fetch the existing team record
        $team = Teams::findOrFail($request->id);

        // Update team details
        $team->team_name = $request->team_name;
        $team->series_id = $request->series_id;

        // Handle team logo update
        if ($request->hasFile('team_logo')) {
            $file = $request->file('team_logo');
            $fileName = 'team_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('team_logos');

            // Ensure the directory exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Move the file to the public folder
            $file->move($destinationPath, $fileName);

            // Delete old team logo if exists
            if (!empty($team->team_logo) && File::exists(public_path($team->team_logo))) {
                File::delete(public_path($team->team_logo));
            }

            // Update database with new image path
            $team->team_logo = 'team_logos/' . $fileName;
            $team->team_logo_name = $file->getClientOriginalName();
        }

        // Save updated team details
        if ($team->save()) {
            return response()->json([
                'code' => 200,
                'message' => 'Team has been successfully updated',
                'team_logo_url' => asset($team->team_logo) // Return new logo URL
            ]);
        }

        return response()->json(['code' => 500, 'message' => 'Something went wrong']);
    }
    // Delete Teams
    public function deleteTeams(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:teams,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 422, 'message' => $validator->errors()->first()]);
        }

        $teams = Teams::find($request->id);
        $teams->delete();

        return response()->json(['code' => 200, 'message' => 'Teams has been successfully deleted']);
    }
}
