<?php

namespace App\Services\Mail;

class EnsuringSoftwareProjectSuccessMail extends BaseMail
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build(): EnsuringSoftwareProjectSuccessMail
    {
        return $this->view('mails.ensuring-software-project-success');
    }
}
