<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'numeric', 'digits_between:10,15', 'unique:' . User::class],
            'password' => ['nullable', 'string', Password::defaults()], // Password rule

        ]);  

        $mobile = $request->input('mobile');

        // Check if the device is already associated with an account
        $existingUser = User::where('mobile', $mobile)->first();
        if ($existingUser) {
            return response()->json(
                [
                    'success' => false,
                    'message' =>
                        'This user has already registered!',
                ],
                401
            );
        }

        $user = User::create([ 
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password), 
        ]);

        return response()->json([
            'data' => $user,
            'status' => 200,
            'message' => 'Successfully Registered',
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'numeric', 'digits_between:10,15'],
            'password' => ['required', 'string'],
        ]);

        $credential = $request->only(['mobile', 'password']);

        if (auth()->attempt($credential)) {
            $user = Auth::user();
            $token = $user->createToken('laravel');

            return response()->json([
                'user' => $user,
                'status' => 200,
                'message' => 'Successfully Login',
                'token' => $token->plainTextToken,
            ]);
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Invalid mobile or password',
                ],
                401
            );
        }
    }

    public function logout()
    {
        try {
            $user = Auth::guard('api')->user();

            if ($user) {
                PersonalAccessToken::where('tokenable_id', $user->id)->delete(); // Revoke all tokens for the user
            }
            return response()->json(['message' => 'Logged out successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error logging out'], 500);
        }
    }
}
