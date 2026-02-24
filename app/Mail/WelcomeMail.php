<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $actionUrl;
    public $actionText;
    public $token;

    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
        $this->actionUrl = url('/api/verify-email/' . $this->token);
        $this->actionText = 'Verify Email';
    }

    public function build()
    {
        return $this->subject('Welcome!')
            ->view('emails.welcome')
            ->with([
                'email' => $this->email,
                'actionUrl' => $this->actionUrl,
                'actionText' => $this->actionText,
            ]);
    }
}
