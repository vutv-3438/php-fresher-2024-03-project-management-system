<?php

namespace Tests\Unit\Models;

use App\Common\Enums\Role as RoleEnum;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Database\Factories\RoleFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRoleTest extends BaseModel
{
    use RefreshDatabase;

    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(new UserRole(), [], []);
    }

    public function test_user_relation()
    {
        $m = new UserRole();
        $r = $m->user();

        $this->assertBelongsToRelation($r, $m, new User(), 'user_id');
    }

    public function test_role_relation()
    {
        $m = new UserRole();
        $r = $m->role();

        $this->assertBelongsToRelation($r, $m, new Role(), 'role_id');
    }

    public function test_count_manager_in_project_scope()
    {
        $project = Project::factory()->create();
        $managerRole = $project->roles()->create([
           'name' => RoleEnum::MANAGER,
           'description' => 'the manager role',
           'project_id' => $project->id,
        ]);
        $memberRole = $project->roles()->create([
            'name' => RoleEnum::MEMBER,
            'description' => 'the member role',
        ]);
        $user = User::factory()->create();
        $managerRole->users()->attach($user->id);
        $memberRole->users()->attach($user->id);

        $this->assertEquals(1, UserRole::countManagerRoleInProject($project->id));
    }
}
