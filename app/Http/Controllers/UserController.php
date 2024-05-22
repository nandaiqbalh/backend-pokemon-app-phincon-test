<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->only('username', 'password'), [
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8|max:20',
        ]);

        if ($validator->fails()) {
            return $this->failedResponse($validator->errors()->first());
        }

        // Create and save the new user
        $user = new User();
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();

        return $this->successResponse($user);
    }

    public function login(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->only('username', 'password'), [
            'username' => 'required',
            'password' => 'required|min:8|max:20',
        ]);

        if ($validator->fails()) {
            return $this->failedResponse($validator->errors()->first());
        }

        // Attempt authentication
        if (Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();

            return $this->successResponse($user);
        }

        return $this->failedResponse('Invalid credentials.');
    }

    private function failedResponse($errorMessage)
    {
        return response()->json([
            'success' => false,
            'status' => $errorMessage,
            'data' => null,
        ]);
    }

    private function successResponse($user)
    {
        return response()->json([
            'success' => true,
            'status' => 'Authentication successful.',
            'data' => $user,
        ]);
    }
}
