<?php

namespace App\Services\Mail;

class ConfirmProjectMail extends BaseMail
{
    public $user;
    public $project;
    public $confirmationUrl;

    public function __construct($user, $project, $confirmationUrl)
    {
        $this->user = $user;
        $this->project = $project;
        $this->confirmationUrl = $confirmationUrl;
    }

    public function build(): ConfirmProjectMail
    {
        return $this->view('mails.invite-confirmation')
            ->subject('Confirm to join the project');
    }
}
