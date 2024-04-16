<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use App\Models\RoleClaim;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleClaimTest extends BaseModel
{
    use RefreshDatabase;

    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(new RoleClaim(), [], [], []);
    }

    public function test_reporter_relation()
    {
        $m = new RoleClaim();
        $r = $m->role();

        $this->assertBelongsToRelation($r, $m, new Role(), 'role_id');
    }
}
