<?php

namespace App\Modules\User\Mail;

use App\Modules\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public User $user
    ) {
    }

    public function build()
    {
        return $this->subject('Welcome!')->view('user::emails.welcome');
    }
}
