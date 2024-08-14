<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendWelcomeMail($email)
    {
        $details = [
            'title' => 'Welcome to our website!',
            'body' => 'Thank you for registering with us.'
        ];

        Mail::to($email)->send(new WelcomeEmail($details));

        return response()->json([
            'message' => 'Welcome email sent successfully.'
        ], 200);
    }
}