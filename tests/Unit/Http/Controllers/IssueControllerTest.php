<?php

namespace Tests\Unit\Http\Controllers;

use App\Common\Enums\Action;
use App\Common\Enums\Status;
use App\Http\Controllers\IssueController;
use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Models\Issue;
use App\Models\Project;
use App\Services\Repositories\Contracts\IIssueRepository;
use App\Services\Repositories\Contracts\IIssueTypeRepository;
use App\Services\Repositories\Contracts\IUserRepository;
use App\Services\Repositories\Contracts\IWorkFlowStepRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Mockery;
use PDOException;
use Tests\TestCase;

class IssueControllerTest extends TestCase
{
    use WithoutMiddleware;
    use RefreshDatabase;

    private IssueController $issueController;
    private IIssueRepository $issueRepository;
    private IIssueTypeRepository $issueTypeRepository;
    private IWorkFlowStepRepository $stepRepository;
    private IUserRepository $userRepository;
    private $gateMock;
    private $queryBuilderMock;

    protected function setUp(): void
    {
        $this->afterApplicationCreated(function () {
            $this->issueRepository = Mockery::mock(IIssueRepository::class)->makePartial();
            $this->issueTypeRepository = Mockery::mock(IIssueTypeRepository::class)->makePartial();
            $this->stepRepository = Mockery::mock(IWorkFlowStepRepository::class)->makePartial();
            $this->userRepository = Mockery::mock(IUserRepository::class)->makePartial();
            $this->issueController = new IssueController(
                $this->issueRepository,
                $this->issueTypeRepository,
                $this->stepRepository,
                $this->userRepository
            );
            $this->gateMock = Mockery::mock('Illuminate\Contracts\Auth\Access\Gate');
            $this->app->instance('Illuminate\Contracts\Auth\Access\Gate', $this->gateMock);
            $this->queryBuilderMock = Mockery::mock('Illuminate\Database\Query\Builder');
            $this->app->instance(Builder::class, $this->queryBuilderMock);
        });
        parent::setUp();
    }

    protected function tearDown(): void
    {
        unset($this->issueController);
        Mockery::close();
        parent::tearDown();
    }

    public function test_index()
    {
        $this->gateMock
            ->shouldReceive('authorize')
            ->with(Action::VIEW_ANY, Issue::class)
            ->once()
            ->andReturn(true);
        $view = $this->issueController->index(1);
        $this->assertEquals('issues.index', $view->getName());
    }

    public function test_get_project_by_project_id()
    {
        $this->gateMock
            ->shouldReceive('authorize')
            ->with(Action::VIEW_ANY, Issue::class)
            ->andReturn(true);
        $draw = 1;
        $start = 0;
        $length = 10;
        $totalRecords = 20;
        $project = Project::factory()->create();
        $expectedIssues = Issue::factory()
            ->withProject($project->id)
            ->count(10)
            ->create();
        $this->issueRepository
            ->shouldReceive('getAllByProjectId')
            ->with($project->id, [
                'issueType:id,name',
                'status:id,name',
                'assignee:id,first_name,last_name',
            ])
            ->once()
            ->andReturn($this->queryBuilderMock);
        $this->queryBuilderMock->shouldReceive('offset')->with($start)->once()->andReturnSelf();
        $this->queryBuilderMock->shouldReceive('limit')->with($length)->once()->andReturnSelf();
        $this->queryBuilderMock->shouldReceive('get')->once()->andReturn($expectedIssues);
        $this->issueRepository
            ->shouldReceive('getAllByProjectId')
            ->with($project->id)
            ->once()
            ->andReturn($this->queryBuilderMock);
        $this->queryBuilderMock->shouldReceive('count')->once()->andReturn($totalRecords);

        $request = new Request(['draw' => $draw, 'start' => $start, 'length' => $length]);

        $response = $this->issueController->getAllByProjectId($request, $project->id);

        $responseData = $response->getData(true);
        $this->assertEquals($draw, $responseData['draw']);
        $this->assertEquals($totalRecords, $responseData['recordsTotal']);
        $this->assertEquals($totalRecords, $responseData['recordsFiltered']);
        $this->assertEquals($expectedIssues->toArray(), $responseData['issues']);
    }

    public function test_create()
    {
        $projectId = 1;
        $this->gateMock
            ->shouldReceive('authorize')
            ->with(Action::CREATE, Issue::class)
            ->andReturn(true);
        $this->issueTypeRepository
            ->shouldReceive('getAllByProjectId')
            ->with($projectId)
            ->once()
            ->andReturn($this->queryBuilderMock);
        $this->queryBuilderMock->shouldReceive('get')->once()->andReturn([]);
        $this->stepRepository
            ->shouldReceive('getAllByProjectId')
            ->with($projectId)
            ->once()
            ->andReturn($this->queryBuilderMock);
        $this->queryBuilderMock->shouldReceive('get')->once()->andReturn([]);
        $this->userRepository
            ->shouldReceive('getAllByProjectId')
            ->with($projectId)
            ->once()
            ->andReturn($this->queryBuilderMock);
        $this->queryBuilderMock->shouldReceive('get')->once()->andReturn([]);
        $this->issueRepository
            ->shouldReceive('getAllByProjectId')
            ->with($projectId)
            ->once()
            ->andReturn($this->queryBuilderMock);
        $this->queryBuilderMock->shouldReceive('get')->once()->andReturn([]);

        $view = $this->issueController->create($projectId);

        $this->assertEquals('issues.create', $view->getName());
    }

    public function test_show()
    {
        $projectId = 1;
        $this->gateMock
            ->shouldReceive('authorize')
            ->with(Action::VIEW, Issue::class)
            ->andReturn(true);
        $issue = Mockery::mock(Issue::class);
        $issue->shouldReceive('load')->with([
            'childIssues.issueType:id,name',
            'childIssues.status:id,name',
            'childIssues.assignee:id,first_name,last_name',
            'issueType',
            'status',
            'assignee',
            'parentIssue',
        ])->andReturnSelf();

        $view = $this->issueController->show($projectId, $issue);

        $this->assertEquals('issues.detail', $view->getName());
    }

    public function test_store()
    {
        $projectId = 1;
        $request = new StoreIssueRequest();
        $this->gateMock
            ->shouldReceive('authorize')
            ->with(Action::CREATE, Issue::class)
            ->andReturn(true);

        $this->issueRepository
            ->shouldReceive('create')
            ->with($request->input())
            ->once()
            ->andReturn(Mockery::mock(Issue::class));
        $response = $this->issueController->store($request, $projectId);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Status::SUCCESS, $response->getSession()->get('type'));

        $this->issueRepository
            ->shouldReceive('create')
            ->with($request->input())
            ->once()
            ->andThrow(new PDOException);
        $response = $this->issueController->store($request, $projectId);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Status::DANGER, $response->getSession()->get('type'));
    }

    public function test_edit()
    {
        $projectId = 1;
        $this->gateMock
            ->shouldReceive('authorize')
            ->with(Action::UPDATE, Issue::class)
            ->andReturn(true);
        $issue = Mockery::mock(Issue::class);
        $issue->shouldReceive('load')->with([
            'childIssues.issueType:id,name',
            'childIssues.status:id,name',
            'childIssues.assignee:id,first_name,last_name',
            'issueType',
            'status.nextStatusesAllowed',
            'assignee',
            'parentIssue',
        ])->andReturnSelf();
        $this->issueTypeRepository
            ->shouldReceive('getAllByProjectId')
            ->with($projectId)
            ->once()
            ->andReturn($this->queryBuilderMock);
        $this->queryBuilderMock->shouldReceive('get')->once()->andReturn([]);
        $this->stepRepository
            ->shouldReceive('getAllByProjectId')
            ->with($projectId)
            ->once()
            ->andReturn($this->queryBuilderMock);
        $this->queryBuilderMock->shouldReceive('get')->once()->andReturn([]);
        $this->userRepository
            ->shouldReceive('getAllByProjectId')
            ->with($projectId)
            ->once()
            ->andReturn($this->queryBuilderMock);
        $this->queryBuilderMock->shouldReceive('get')->once()->andReturn([]);
        $this->issueRepository
            ->shouldReceive('getAllByProjectId')
            ->with($projectId)
            ->once()
            ->andReturn($this->queryBuilderMock);
        $this->queryBuilderMock->shouldReceive('get')->once()->andReturn([]);

        $view = $this->issueController->edit($projectId, $issue);

        $this->assertEquals('issues.edit', $view->getName());
    }

    public function test_update()
    {
        $projectId = 1;
        $issueId = 1;
        $request = new UpdateIssueRequest();
        $issue = Mockery::mock(Issue::class);
        $this->issueRepository
            ->shouldReceive('findOrFail')
            ->with($issueId)
            ->andReturn($issue);
        $this->gateMock
            ->shouldReceive('authorize')
            ->with(Action::UPDATE, $issue)
            ->andReturn(true);

        $this->issueRepository
            ->shouldReceive('update')
            ->with($request->input(), $issueId)
            ->once()
            ->andReturnTrue();
        $response = $this->issueController->update($request, $projectId, $issueId);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Status::SUCCESS, $response->getSession()->get('type'));

        $this->issueRepository
            ->shouldReceive('update')
            ->with($request->input(), $issueId)
            ->once()
            ->andThrow(new PDOException);
        $response = $this->issueController->update($request, $projectId, $issueId);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Status::DANGER, $response->getSession()->get('type'));
    }

    public function test_delete()
    {
        $projectId = 1;
        $issue = Mockery::mock(Issue::class);
        $this->gateMock
            ->shouldReceive('authorize')
            ->with(Action::DELETE, $issue)
            ->andReturn(true);

        $this->issueRepository
            ->shouldReceive('delete')
            ->with($issue)
            ->once()
            ->andReturnTrue();
        $response = $this->issueController->destroy($projectId, $issue);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Status::SUCCESS, $response->getSession()->get('type'));

        $this->issueRepository
            ->shouldReceive('delete')
            ->with($issue)
            ->once()
            ->andThrow(new PDOException);
        $response = $this->issueController->destroy($projectId, $issue);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Status::DANGER, $response->getSession()->get('type'));
    }
}
