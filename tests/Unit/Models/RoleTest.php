<?php

namespace Tests\Unit\Models;

use App\Models\Project;
use App\Models\Role;
use App\Models\UserRole;
use App\Common\Enums\Role as RoleEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends BaseModel
{
    use RefreshDatabase;

    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(new Role(), [], [], [], [], ['id' => 'int'], ['is_manager']);
    }

    public function test_project_relation()
    {
        $m = new Role();
        $r = $m->project();

        $this->assertBelongsToRelation($r, $m, new Project(), 'project_id');
    }

    public function test_users_relation()
    {
        $m = new Role();
        $r = $m->users();

        $this->assertBelongsToManyRelation($r, $m, new UserRole(), 'role_id', 'user_id');
    }

    public function test_user_roles_relation()
    {
        $m = new Role();
        $r = $m->userRoles();

        $this->assertHasRelation($r, $m, 'role_id');
    }

    public function test_role_claims_relation()
    {
        $m = new Role();
        $r = $m->roleClaims();

        $this->assertHasRelation($r, $m, 'role_id');
    }

    public function test_is_manager_scope()
    {
        $project = Project::factory()->create();
        $role = Role::factory()->create([
            'name' => RoleEnum::MANAGER,
            'description' => 'the manager role',
            'project_id' => $project->id,
        ]);

        $this->assertTrue($role->is_manager);
    }

    public function test_is_manager_accessor()
    {
        $project = Project::factory()->create();
        $role = Role::factory()->create([
            'name' => RoleEnum::MANAGER,
            'description' => 'the manager role',
            'project_id' => $project->id,
        ]);

        $this->assertTrue($role->getAttributeValue('is_manager'));
    }
}
