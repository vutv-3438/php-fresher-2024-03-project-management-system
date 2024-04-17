<?php

namespace App\Providers;

use App\Jobs\Mails\SendMailJob;
use App\Models\User;
use App\Services\Mail\EnsuringSoftwareProjectSuccessMail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Schedule::macro('sendHintForAllUsers', function () {
            $users = User::all();
            foreach ($users as $user) {
                $this->job(new SendMailJob(new EnsuringSoftwareProjectSuccessMail($user)))
                    ->monthly()
                    ->withoutOverlapping();
            }

            return $this;
        });
    }
}
