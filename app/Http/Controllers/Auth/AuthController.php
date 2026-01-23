<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{LoginRequest,RegisterRequest};
use App\Http\Resources\UserResource;
use App\Mail\TestMail;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\{Auth,Mail};
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    use ResponseAPI;

    public function register(RegisterRequest $request) {

        try {
            DB::beginTransaction();
            $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone_number' => $request->phone_number
            ]);

            if ($request->role) {
                $user->assignRole($request->role);
            }
            event(new Registered($user));

            DB::commit();    

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('An error occured: ' . $e);
        }
        
        return $this->success("User registered", new UserResource($user), 201);
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


