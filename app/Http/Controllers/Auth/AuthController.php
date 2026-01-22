<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ResponseAPI;

    public function register(RegisterRequest $request) {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone_number' => $request->phone_number
        ]);

        if ($request->role) {
            $user->assignRole($request->role);
        }

        $userData = [
            'name' => $user->name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'role' => $user->getRoleNames()->first() ?? null
        ];

        return $this->success("User registered", $userData, 201);
    }

    public function login(LoginRequest $request) {
        if (! Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {

            return $this->error('Invalid Credentials', 401);

        } else {

            $user = $request->user();
            $token = $user->createToken(uniqid())->plainTextToken;

        }

        return $this->success('User logged in', [
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token,
            'role' => $user->getRoleNames()->first() ?? null
        ]);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return $this->success('Logged out');
    }
}
