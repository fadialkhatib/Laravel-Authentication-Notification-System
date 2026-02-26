<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendWelcomeEmail;

class EmailController extends Controller
{
    /*
     * Send a welcome email to a user.
     */
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        SendWelcomeEmail::dispatch($request->email);

        return response()->json([
            'status' => 'queued',
            'message' => 'Email has been queued successfully.'
        ], 202);
    }
}
