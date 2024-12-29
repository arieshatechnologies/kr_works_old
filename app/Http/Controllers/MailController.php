<?php

namespace App\Http\Controllers;

use App\Services\PHPMailerService;
use Illuminate\Http\Request;

class MailController extends Controller
{
    protected $mailService;

    public function __construct(PHPMailerService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function sendEmail()
    {
        $to = 'rajaganesansubramani@gmail.com';
        $subject = 'Test Email';
        $body = '<p>This is a test email.</p>';

        $success = $this->mailService->send($to, $subject, $body);

        if ($success) {
            return response()->json(['message' => 'Email sent successfully']);
        } else {
            return response()->json(['message' => 'Failed to send email'], 500);
        }
    }
}
