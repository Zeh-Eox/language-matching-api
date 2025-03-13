<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): Collection
    {
        return User::all();
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password, [
                'round' => 12
            ]);

            $user->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'User successfully registered',
                'data' => $user
            ]);
        } catch(Exception $e)
        {
            return response()->json($e);
        }
    }

    public function login(LogUserRequest $request)
    {
        try {
            if (auth()->attempt($request->only(['email', 'password']))) 
            {
                $user = auth()->user();
                $_token = $user
                            ->createToken('my_secret_token_only_visible_in_the_backend')
                            ->plainTextToken;
                
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'User connected',
                    'data' => $user,
                    'token' => $_token
                ]);
            } else 
            {
                return response()->json([
                    'status_code' => 403,
                    'status_message' => 'Invalid Informations',
                ]);
            }
        } catch (Exception $e) 
        {
            return response()->json($e);
        }
    }
}
