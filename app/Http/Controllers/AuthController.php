<?php

namespace App\Http\Controllers;

use App\Events\UserVerified;
use Illuminate\Http\Request;
use App\Jobs\SendWelcomeEmail;
use App\Mail\ResetPasswordMail;
use App\Models\Log;
use App\Models\Password_resets;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        $validate = $request->validate([
            'name'         => 'required|string',
            'email'        => 'required|string|unique:users,email',
            'password'     => 'required|between:8,16',
            'verification_token' => 'required|string|unique:users,verification_token',
        ]);

        $user = User::create([
            'name'         => $validate['name'],
            'email'        => $validate['email'],
            'password'     => Hash::make($validate['password']),
            'verification_token' => Str::random(40),
        ]);

        SendWelcomeEmail::dispatch($user->email, $user->verification_token);
        return response()->json([
            'message' => 'Registered successfully. Please verify your email.'
        ], 201);
    }

    public function Login(Request $request)
    {
        try {
            $validate = $request->validate([
                'email'    => 'required|string',
                'password' => 'required|between:8,16'
            ]);

            //Check Email
            $user = User::where('email', $validate['email'])->first();

            if (!$user) {
                return response()->json(['message' => 'User Email not found! ']);
            }
            //Check Pass
            if (!Hash::check($validate['password'], $user->password)) {
                return response()->json(['message' => 'Password incorrect!']);
            }
            $token    = $user->createToken('mytoken@FO123')->accessToken;
            $response = [
                'User Details' => $user,
                'The Token'   => $token
            ];
        } catch (\Exception $e) {
            return response()->json(['message' => 'an error uccured in login!']);
        }

        Log::create([
            'action' => 'user_login',
            'email'  => $user->email,
            'details' => 'User logged in via Sanctum'
        ]);
        return $response;
    }


    public function Logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }


    public function verifyEmail(Request $request)
    {
        $user = auth()->user();
        event(new UserVerified("Your account has been verified"));
        if (! $user) {
            return response()->json(['message' => 'Invalid token'], 400);
        }



        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->save();
        $this->sendPushNotification(
            $user,
            "Account Verified",
            "Your email has been successfully verified"
        );

        return response()->json(['message' => 'Email verified successfully']);
    }
    public function forgotPassword(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email'
        ]);
        $user = User::where('email', $request->email)->first();

        $token    = $user->createToken('mytoken@FO123')->accessToken;
        $response = [
            'User Details' => $user,
            'The Token'   => $token
        ];
        Password_resets::updateOrInsert(
            [
                'email' => $validate['email'],

                'token' => $token,
                'created_at' => now()
            ]
        );

        // إرسال الإيميل
        Mail::to($request->email)->send(new ResetPasswordMail($token));

        return response()->json([
            'message' => 'Reset link sent to your email.'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:6'
        ]);

        $record = Password_resets::where('token', $request->token)->first();

        if (! $record) {
            return response()->json(['message' => 'Invalid token'], 400);
        }

        $user = User::where('email', $record->email)->first();

        $user->password = Hash::make($request->password);
        $user->save();
        $user->tokens()->delete();


        Password_resets::where('email', $record->email)->delete();
        $this->sendPushNotification(
            $user,
            "Password Changed",
            "Your password has been updated successfully"
        );

        return response()->json(['message' => 'Password updated successfully']);
    }


    public function saveDeviceToken(Request $request)
    {
        $request->validate([
            'device_token' => 'required'
        ]);

        $request->user()->update([
            'device_token' => $request->device_token
        ]);

        return response()->json(['message' => 'Device token saved']);
    }


    public function sendPushNotification($user, $title, $body)
    {
        $token = $user->device_token;

        if (!$token) {
            return "User has no device token";
        }

        $data = [
            "to" => $token,
            "notification" => [
                "title" => $title,
                "body" => $body,
                "sound" => "default"
            ]
        ];

        $headers = [
            "Authorization: key=" . env('FCM_SERVER_KEY'),
            "Content-Type: application/json"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
