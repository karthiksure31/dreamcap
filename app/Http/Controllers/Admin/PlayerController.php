<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Players;
use App\Models\Positions;
use App\Models\Series;
use App\Models\Teams;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class PlayerController extends Controller
{
    //
    function playersIndex()
    {
        $series = Series::select('id', 'series_name')->get();
        $teams = Teams::select('id', 'team_name')->get();
        $positions = Positions::select('id', 'position_name')->get();
        return view(
            'admin.players.index',
            [
                'series' => $series,
                'teams' => $teams,
                'positions' => $positions
            ]
        );
    }
    // get list of players
    function getPlayerList(Request $request)
    {
        // $getPlayers = Players::all();
        // dd($getPlayers);
        $getPlayers =  DB::table('players as pl')
            ->select(
                'pl.id',
                'pl.player_name',
                'pl.image',
                'pl.credit_points',
                'ps.id as position_id',
                'ps.position_name',
                't.id as team_id',
                't.team_name',
                't.team_logo',
                's.id as series_id',
                's.series_name',
            )
            ->leftjoin('teams as t', 't.id', '=', 'pl.team_id')
            ->leftjoin('series as s', 's.id', '=', 'pl.series_id')
            ->leftjoin('positions as ps', 'ps.id', '=', 'pl.position_id')
            ->where('pl.status', '0')
            ->get();

        // $resultArray =   json_encode($getPlayers);
        // return $getPlayers;
        return DataTables::of(json_decode($getPlayers, true))
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group">
                                                <button class="btn btn-sm btn-primary" data-id="' . $row['id'] . '" id="editPlayerBtn">Update</button>
                                                <button class="btn btn-sm btn-danger" data-id="' . $row['id'] . '" id="deletePlayerBtn">Delete</button>
                                          </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    // get row details
    public function getPlayerDetails(Request $request)
    {
        $id = $request->id;
        $playerDetails = Players::find($id);
        return response()->json(['details' => $playerDetails]);
    }
    public function addPlayer(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'player_name'   => 'required|string|max:255',
            'credit_points' => 'required|numeric|min:0|max:10',
            'series_id'     => 'required|exists:series,id',
            'team_id'       => 'required|exists:teams,id',
            'position_id'   => 'required|exists:positions,id',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code'    => 422,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            // Create a new player instance
            $player = new Players();
            $player->player_name   = $request->player_name;
            $player->credit_points = $request->credit_points;
            $player->series_id     = $request->series_id;
            $player->team_id       = $request->team_id;
            $player->position_id   = $request->position_id;

            // Handle player image upload
            if ($request->hasFile('image')) {
                $file           = $request->file('image');
                $fileName       = 'player_' . time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('player_images');

                // Ensure the directory exists
                File::ensureDirectoryExists($destinationPath, 0755, true);

                // Move the file and store the path in the database
                $file->move($destinationPath, $fileName);
                $player->image      = 'player_images/' . $fileName;
                $player->image_name = $file->getClientOriginalName();
            }

            // Save the player record
            $player->save();

            return response()->json([
                'code'    => 200,
                'message' => 'New Player has been successfully saved'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code'    => 500,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ]);
        }
    }
    // updatePlayer
    public function updatePlayer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:players,id',
            'player_name' => 'required|string|max:255',
            'credit_points' => 'required|numeric|min:0|max:10',
            'series_id' => 'required|exists:series,id',
            'team_id' => 'required|exists:teams,id',
            'position_id' => 'required|exists:positions,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 422, 'message' => $validator->errors()->first()]);
        }

        $player = Players::find($request->id);

        $player->update([
            'player_name' => $request->player_name,
            'credit_points' => $request->credit_points,
            'series_id' => $request->series_id,
            'team_id' => $request->team_id,
            'position_id' => $request->position_id,
            'status' => $request->status ?? "0", // Default to "0" if not provided
        ]);

        // Handle image upload if a new file is provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if (!empty($player->image) && File::exists(public_path($player->image))) {
                File::delete(public_path($player->image));
            }

            $file = $request->file('image');
            $fileName = 'player_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('player_images');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $fileName);

            // Update image path
            $player->update([
                'image' => 'player_images/' . $fileName,
                'image_name' => $file->getClientOriginalName(),
            ]);
        }

        return response()->json(['code' => 200, 'message' => 'Player has been successfully updated']);
    }

    // deletePlayer
    public function deletePlayer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['code' => 422, 'message' => $validator->errors()->first()]);
        }
        $players = Players::find($request->id);
        $players->status = "1";
        $query = $players->save();

        if ($query) {
            return response()->json(['code' => 200, 'message' => 'New Player has been successfully deleted']);
        } else {
            return response()->json(['code' => 500, 'message' => 'Something went wrong']);
        }
    }
}
