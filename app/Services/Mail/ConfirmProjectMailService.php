<?php

namespace App\Services\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmProjectMailService extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $project;
    public $confirmationUrl;

    public function __construct($user, $project, $confirmationUrl)
    {
        $this->user = $user;
        $this->project = $project;
        $this->confirmationUrl = $confirmationUrl;
    }

    public function build(): ConfirmProjectMailService
    {
        return $this->view('mails.invite-confirmation')
            ->subject('Confirm to join the project');
    }
}
