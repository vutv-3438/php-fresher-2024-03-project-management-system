<?php

namespace App\Providers;

use App\Services\Repositories\Contracts\IIssueRepository;
use App\Services\Repositories\Contracts\ILogTimeRepository;
use App\Services\Repositories\Contracts\IProjectRepository;
use App\Services\Repositories\Contracts\IRoleRepository;
use App\Services\Repositories\Contracts\IUserRoleRepository;
use App\Services\Repositories\Contracts\IWorkFlowRepository;
use App\Services\Repositories\Contracts\IWorkFlowStepRepository;
use App\Services\Repositories\IssueRepository;
use App\Services\Repositories\LogTimeRepository;
use App\Services\Repositories\ProjectRepository;
use App\Services\Repositories\RoleRepository;
use App\Services\Repositories\UserRoleRepository;
use App\Services\Repositories\WorkFlowRepository;
use App\Services\Repositories\WorkFlowStepRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IProjectRepository::class, ProjectRepository::class);
        $this->app->singleton(IIssueRepository::class, IssueRepository::class);
        $this->app->singleton(ILogTimeRepository::class, LogTimeRepository::class);
        $this->app->singleton(IRoleRepository::class, RoleRepository::class);
        $this->app->singleton(IUserRoleRepository::class, UserRoleRepository::class);
        $this->app->singleton(IWorkFlowRepository::class, WorkFlowRepository::class);
        $this->app->singleton(IWorkFlowStepRepository::class, WorkFlowStepRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
