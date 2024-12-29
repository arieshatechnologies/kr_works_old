<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Otp;
use App\Services\PHPMailerService;
use App\Models\User;

class OtpController extends Controller
{
    protected $mailService;

    public function __construct(PHPMailerService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $exists = User::where('email', $request->email)->exists();

        if (!$exists) {
            return response()->json([
                'status' => 'failure',
                'message' => 'This email not registered with us.',
            ]);
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        // Save or update OTP for the email
        Otp::updateOrCreate(
            ['email' => $request->email],
            ['otp' => $otp]
        );

        // Send OTP via email (implement your email sending logic here)
        $to = $request->email;
        $subject = 'Your OTP for Verification';
        $body = OtpController::buildOtpEmailBody($otp);

        $success = $this->mailService->send($to, $subject, $body);

        if ($success) {
            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'failure',
                'message' => 'Failed to send OTP.',
            ]);
        }

        
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);

        $otpRecord = Otp::where('email', $request->email)->latest()->first();

        if ($otpRecord && $otpRecord->otp === $request->otp) {
            // OTP matched, perform further actions like user authentication
            return response()->json([
                'status' => 'success',
                'message' => 'OTP verified successfully',
            ]);
        } else {
            // OTP not matched
            return response()->json([
                'status' => 'failure',
                'message' => 'Invalid OTP',
            ], 422);
        }
    }
    public static function buildOtpEmailBody($otp)
    {
        // Company name
        $companyName = "SB Tex";

        // Generate unique HTML content
        $htmlContent = "
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f5f5f5;
                        color: #333;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #fff;
                        border-radius: 8px;
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    }
                    h1 {
                        color: #009688;
                    }
                    .otp {
                        background-color: #ffeb3b;
                        padding: 10px;
                        border-radius: 4px;
                        font-weight: bold;
                        color: #333;
                    }
                    p {
                        margin-bottom: 15px;
                    }
                    .footer {
                        font-size: 12px;
                        color: #666;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>Welcome to <span style='color: #009688;'>$companyName</span></h1>
                    <p>Your OTP for verification is: <span class='otp'>$otp</span></p>
                    <p>Thank you for using our services.</p>
                </div>
                <p class='footer'>This is an automated email. Please do not reply.</p>
            </body>
            </html>
        ";

        return $htmlContent;
    }
}
