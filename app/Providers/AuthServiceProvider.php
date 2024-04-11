<?php

namespace App\Providers;

use App\Models\Issue;
use App\Models\IssueType;
use App\Models\LogTime;
use App\Models\Member;
use App\Models\Project;
use App\Models\Role;
use App\Models\RoleClaim;
use App\Models\User;
use App\Models\WorkFlow;
use App\Models\WorkFlowStep;
use App\Policies\IssuePolicy;
use App\Policies\IssueTypePolicy;
use App\Policies\LogTimePolicy;
use App\Policies\MemberPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\RoleClaimPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Policies\WorkFlowPolicy;
use App\Policies\WorkFlowStepPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Issue::class => IssuePolicy::class,
        IssueType::class => IssueTypePolicy::class,
        LogTime::class => LogTimePolicy::class,
        Project::class => ProjectPolicy::class,
        Role::class => RolePolicy::class,
        RoleClaim::class => RoleClaimPolicy::class,
        User::class => UserPolicy::class,
        WorkFlow::class => WorkFlowPolicy::class,
        WorkFlowStep::class => WorkFlowStepPolicy::class,
        Member::class => MemberPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->registerPassport();
    }

    private function registerPassport()
    {
        // Create routes for oauth
        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }

        // Token life-time
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
