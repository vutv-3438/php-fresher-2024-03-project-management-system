<?php

namespace Tests\Unit\Models;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Common\Enums\Role;
use App\Models\Project;
use App\Models\User;
use App\Models\UserRole;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends BaseModel
{
    use RefreshDatabase;

    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(
            new User(),
            [
                'email',
                'password',
                'user_name',
                'first_name',
                'last_name',
                'avatar',
                'phone_number',
            ],
            ['password', 'remember_token'],
            ['is_admin'],
            [],
            [
                'email_verified_at' => 'datetime',
                'is_locked' => 'boolean',
                'id' => 'int',
                'deleted_at' => 'datetime',
            ],
            ['full_name', 'is_deleted']
        );
    }

    public function test_assigned_issues_relation()
    {
        $m = new User();
        $r = $m->assignedIssues();
        $this->assertHasRelation($r, $m, 'assignee_id');
    }

    public function test_reported_issues_relation()
    {
        $m = new User();
        $r = $m->reportedIssues();
        $this->assertHasRelation($r, $m, 'reporter_id');
    }

    public function test_user_roles_relation()
    {
        $m = new User();
        $r = $m->userRoles();
        $this->assertHasRelation($r, $m, 'user_id');
    }

    public function test_roles_relation()
    {
        $m = new User();
        $r = $m->roles();
        $this->assertBelongsToManyRelation($r, $m, new UserRole(), 'user_id', 'role_id');
    }

    public function test_is_deleted_accessor()
    {
        $user = new User();
        $user->setRawAttributes([
            'deleted_at' => now(),
        ]);

        $this->assertTrue($user->getAttributeValue('is_deleted'));
    }

    public function test_full_name_accessor()
    {
        $user = new User();
        $user->setRawAttributes([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        $this->assertEquals('John Doe', $user->getAttributeValue('full_name'));
    }

    public function test_user_name_mutator()
    {
        $user = new User();
        $user->user_name = 'john weed';

        $this->assertEquals('john-weed', $user->getAttributeValue('user_name'));
    }

    public function test_admin_scope()
    {
        $this->seed(UserSeeder::class);

        $adminCount = User::admin()->count();

        $this->assertEquals(1, $adminCount);
    }

    public function test_global_scope()
    {
        User::factory()
            ->count(2)
            ->withUnActiveStatus()
            ->create();
        User::factory()->count(1)->create();
        $activeUsers = User::all();
        $allUser = User::withoutGlobalScopes()->get();

        $this->assertCount(1, $activeUsers);
        $this->assertCount(3, $allUser);
    }

    public function test_user_has_role_in_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $roleName = 'role_name';
        $user->roles()->create([
            'name' => $roleName,
            'project_id' => $project->id,
        ]);
        $testRole = 'test role';

        $this->assertTrue($user->hasRoleInProject($roleName, $project->id));
        $this->assertFalse($user->hasRoleInProject($testRole, $project->id));
    }

    public function test_user_has_permission_in_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();
        $role = $user->roles()->create([
            'name' => Role::MEMBER,
            'project_id' => $project->id,
        ]);
        $role->roleClaims()->create([
            'claim_type' => Resource::PROJECT,
            'claim_value' => Action::CREATE,
        ]);

        $this->assertTrue($user->hasPermissionInProject($project->id, Resource::PROJECT, Action::CREATE));
        $this->assertFalse($user->hasPermissionInProject($project->id, Resource::PROJECT, Action::VIEW_ANY));
    }
}
