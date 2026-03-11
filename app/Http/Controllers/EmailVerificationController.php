<?php

namespace App\Http\Controllers;

use App\Jobs\SendVerificationEmail;
use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class EmailVerificationController extends Controller
{
    public function send(Request $request) {

        $code = rand(100000, 999999);

        $user = $request->user();

        if ($user->email_verified_at) {
            return $this->error("User's email is already verified", statusCode: 400);
        }

        $latestVerification = $user->emailVerification()->latest()->first();

        if ($latestVerification && $latestVerification->created_at->diffInSeconds() < 20) {
            return $this->error('Please wait for a while before requesting another verification code', statusCode: 429);
        }

        $user->emailVerification?->delete();

        $expirationTime = 300; //seconds 
        
        DB::transaction(function() use ($user, $code, $expirationTime) {
            $user->emailVerification()->create([
                'code_hash' => Hash::make($code),
                'expires_at' => Carbon::now()->addSecond($expirationTime)
            ]);
        });

        SendVerificationEmail::dispatch($user->email, $code, $expirationTime);

        return $this->success('Verification code sent via email', [
            'expires_in' => $expirationTime,
            'resend_available_in' => 60
        ]);
    }

    public function verify(Request $request) {
        $request->validate([
            'code' => 'required'
        ]);

        $user = $request->user();

        $verification = EmailVerification::where('user_id', $user->id)->latest()->first();

        if (! $verification) {
            return $this->error('No verification request', statusCode: 400);
        }

        if (Carbon::now() > $verification->expires_at) {
            return $this->error('Verification code expired', statusCode: 400);
        }

        if (! Hash::check($request->code, $verification->code_hash)) {
            return $this->error('Invalid verification code', statusCode: 400);
        }

        $user->markEmailAsVerified();
        $user->emailVerification()->delete();

        return $this->success('Email verified successfully');
    }
}
