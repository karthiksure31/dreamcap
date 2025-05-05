<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Series;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class SeriesController extends Controller
{
    //
    function seriesIndex()
    {
        return view(
            'admin.series.index'
        );
    }
    // Get List of Series
    public function getSeriesList(Request $request)
    {
        $getSeries = Series::query();
        return DataTables::of($getSeries)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group">
                            <button class="btn btn-sm btn-primary" data-id="' . $row->id . '" id="editSeriesBtn">Update</button>
                            <button class="btn btn-sm btn-danger" data-id="' . $row->id . '" id="deleteSeriesBtn">Delete</button>
                        </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    // get row details
    public function getSeriesDetails(Request $request)
    {
        $id = $request->id;
        $playerDetails = Series::find($id);
        return response()->json(['details' => $playerDetails]);
    }
    // add series
    public function addSeries(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'series_name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['code' => 422, 'message' => $validator->errors()->first()]);
        }
        $series = new Series();
        $series->series_name = $request->series_name;
        $query = $series->save();

        if (!$query) {
            return response()->json(['code' => 500, 'message' => 'Something went wrong']);
        } else {
            return response()->json(['code' => 200, 'message' => 'New Series has been successfully saved']);
        }
    }
    // updateSeries
    public function updateSeries(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'series_name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['code' => 422, 'message' => $validator->errors()->first()]);
        }
        $series = Series::find($request->id);
        $series->series_name = $request->series_name;
        $query = $series->save();

        if ($query) {
            return response()->json(['code' => 200, 'message' => 'New Series has been successfully updated']);
        } else {
            return response()->json(['code' => 500, 'message' => 'Something went wrong']);
        }
    }
    // Delete Series
    public function deleteSeries(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:series,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 422, 'message' => $validator->errors()->first()]);
        }

        $series = Series::find($request->id);
        $series->delete();

        return response()->json(['code' => 200, 'message' => 'Series has been successfully deleted']);
    }
}
