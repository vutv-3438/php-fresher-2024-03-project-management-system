<?php

namespace App\Jobs\Mails;

use App\Jobs\BaseJob;
use App\Services\Mail\BaseMail;
use Illuminate\Support\Facades\Mail;

class SendMailJob extends BaseJob
{
    public BaseMail $mail;

    /**
     * Create a new job instance
     *
     * @param BaseMail $mail
     */
    public function __construct(BaseMail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->mail->user->email)->send($this->mail);
    }
}
