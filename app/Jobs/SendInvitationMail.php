<?php

namespace App\Jobs;

use App\Services\Mail\ConfirmProjectMailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendInvitationMail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public ConfirmProjectMailService $mailService;

    /**
     * Create a new job instance
     *
     * @param ConfirmProjectMailService $mailService
     */
    public function __construct(ConfirmProjectMailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->mailService->user->email)
            ->send($this->mailService);
    }
}
