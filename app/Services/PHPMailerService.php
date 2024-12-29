<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

class PHPMailerService
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->setup();
    }

    protected function setup()
    {
        try {
            // Server settings
            $this->mailer->isSMTP();
            $this->mailer->Host = "mail.ariesha.com";
            $this->mailer->SMTPAuth = true;
            $this->mailer->SMTPSecure = "tls";
            $this->mailer->Username = "support@sbtextiles.ariesha.com";
            $this->mailer->Password = "y.jW)gh9j=.O";
            $this->mailer->Port = 587;

            // Disable certificate verification temporarily
            $this->mailer->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];

            // Sender info
            $fromAddress = "support@sbtextiles.ariesha.com";
            $fromName = 'SB TEXTILES';

            if (empty($fromAddress)) {
                throw new \Exception('MAIL_FROM_ADDRESS is not set in the .env file.');
            }

            $this->mailer->setFrom($fromAddress, $fromName);
        } catch (Exception $e) {
            // Handle the error or log it as needed
            Log::error('Could not set up PHPMailer: ' . $e->getMessage());
            throw new \Exception('Could not set up PHPMailer: ' . $e->getMessage());
        }
    }

    public function send($to, $subject, $body)
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            $this->mailer->send();
            Log::info("Email sent successfully to {$to}");
            return true;
        } catch (Exception $e) {
            Log::error("Email could not be sent to {$to}. PHPMailer Error: " . $e->getMessage());
            return false;
        }
    }
}
