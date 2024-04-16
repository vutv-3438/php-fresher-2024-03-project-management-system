<?php

namespace Tests\Unit\Models;

use App\Models\Issue;
use App\Models\LogTime;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogTimeTest extends BaseModel
{
    use RefreshDatabase;

    public function test_model_configuration()
    {
        $this->runConfigurationAssertions(new LogTime(), [], [], []);
    }

    public function test_issue_relation()
    {
        $m = new LogTime();
        $r = $m->issue();

        $this->assertBelongsToRelation($r, $m, new Issue(), 'issue_id');
    }

    public function test_user_relation()
    {
        $m = new LogTime();
        $r = $m->user();

        $this->assertBelongsToRelation($r, $m, new User(), 'user_id');
    }
}
