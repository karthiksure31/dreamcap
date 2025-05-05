<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommonController extends Controller
{
    //
    function feedback(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'feedback' => 'required',
        ]);
        if (!$validator->passes()) {
            $response = [
                'code' => 422,
                'success' => false,
                'message' => $validator->errors()->toArray(),
            ];
            return response()->json($response);
        } else {
            $company = new Feedback();
            $company->name = $request->name;
            $company->email = $request->email;
            $company->feedback = $request->feedback;
            $query = $company->save();
            $success = [];
            if (!$query) {
                $response = [
                    'code' => 500,
                    'success' => false,
                    'message' => 'Something went wrong'
                ];
                return response()->json($response);
            } else {
                $response = [
                    'code' => 200,
                    'success' => true,
                    'message' => 'Feedback submit successfully'
                ];
                return response()->json($response);
            }
        }
    }
}
