<?php

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;

class AuthController extends BaseController
{
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

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->send400Error('Validation Error.', $validator->errors());
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return $this->send400Error('Unauthorized.', ['error' => 'Unauthorized']);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'unique:users,email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->send400Error('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['role_id'] = 2;
        $user = User::create($input);
        return $this->successResponse($user, 'User successfully registered');

    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        $data = [
            'user' => auth()->user()
        ];
        // return response()->json(auth()->user());
        return $this->successResponse($data, 'User data');

    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        $data = [
            'access_token' => $token,
            // 'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ];
        return $this->successResponse($data, 'User successfully registered');

    }
}
