<?php

namespace App\Http\Controllers;

use App\Common\Enums\Action;
use App\Common\Enums\Resource;
use App\Common\Enums\Status;
use App\Http\Requests\DeleteMemberRequest;
use App\Http\Requests\InviteMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Jobs\SendInvitationMail;
use App\Models\Member;
use App\Services\Mail\ConfirmProjectMailService;
use App\Services\Repositories\Contracts\IMemberRepository;
use App\Services\Repositories\Contracts\IProjectRepository;
use App\Services\Repositories\Contracts\IRoleRepository;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class MemberController extends BaseController
{
    private IMemberRepository $memberRepository;
    private IRoleRepository $roleRepository;
    private IProjectRepository $projectRepository;

    public function __construct(
        IMemberRepository $memberRepository,
        IRoleRepository $roleRepository,
        IProjectRepository $projectRepository
    ) {
        $this->memberRepository = $memberRepository;
        $this->roleRepository = $roleRepository;
        $this->projectRepository = $projectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $projectId
     * @return View
     * @throws AuthorizationException
     */
    public function index(int $projectId): View
    {
        $this->authorize(Action::VIEW_ANY, Member::class);

        return view('members.index', [
            'members' => $this->memberRepository->getAllByProjectId($projectId, [
                'roles' => function ($query) use ($projectId) {
                    $query->select('id', 'name', 'project_id')
                        ->where('project_id', $projectId);
                },
            ])->get(),
            'roles' => $this->roleRepository->getAllByProjectId($projectId)->get(),
            'projectId' => $projectId,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize(Action::CREATE, Member::class);

        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InviteMemberRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function requestJoinProject(InviteMemberRequest $request): RedirectResponse
    {
        $this->authorize(Action::CREATE, Member::class);

        try {
            $emails = $this->getEmailsToSendInvitationEmail($request->input('names_or_emails'));
            $usersByEmails = $this->memberRepository->getByEmails($emails);
            $project = $this->projectRepository->findOrFail(getRouteParam('projectId'));
            foreach ($emails as $email) {
                $url = URL::temporarySignedRoute(
                    'members.store',
                    now()->addMinutes(10),
                    [
                        'token' => Str::random(100),
                        'user_id' => $usersByEmails[$email]->id,
                        'projectId' => $project->id,
                    ]
                );
                SendInvitationMail::dispatch(new ConfirmProjectMailService($usersByEmails[$email], $project, $url));
            }

            return back()
                ->with([
                    'type' => count($emails) === 0 ? Status::DANGER : Status::SUCCESS,
                    'msg' => count($emails) === 0
                        ? __('Nothing has been sent, please check your information again!')
                        : __('List users have been sent') . ': ' . join(', ', $emails),
                ])
                ->withInput();
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }

    public function store(Request $request): View
    {
        if (!$request->hasValidSignature()) {
            self::Forbidden(__('Fail! Please contact the admin to get something else!'));
        }

        try {
            $this->memberRepository->addDefaultRoleToUser($request->input('user_id'), getRouteParam('projectId'));

            return view('notification', [
                'type' => Status::SUCCESS,
                'title' => __('The confirmation was successfully!'),
                'message' => __('Please login to your project!'),
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            self::ServerError();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMemberRequest $request
     * @param int $projectId
     * @param Member $member
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateMemberRequest $request, int $projectId, Member $member): RedirectResponse
    {
        $this->authorize(Action::UPDATE, $member);

        try {
            $this->memberRepository->update($request->input(), $member->id);

            return redirectWithActionStatus(
                Status::SUCCESS,
                'members.index',
                Resource::MEMBER,
                Action::UPDATE,
                ['projectId' => $projectId]
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteMemberRequest $request
     * @param int $projectId
     * @param Member $member
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(DeleteMemberRequest $request, int $projectId, Member $member): RedirectResponse
    {
        $this->authorize(Action::DELETE, $member);

        try {
            $this->memberRepository->deleteMemberInProject($member, $request->input('role_id'));

            return redirectWithActionStatus(
                Status::SUCCESS,
                'members.index',
                Resource::MEMBER,
                Action::DELETE,
                ['projectId' => $projectId],
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return backWithActionStatus();
        }
    }

    private function getEmailsToSendInvitationEmail(string $namesOrEmails): array
    {
        $emails = [];

        $namesOrEmailsArray = explode(',', $namesOrEmails);

        foreach ($namesOrEmailsArray as $item) {
            $trimmedItem = trim($item);

            if (filter_var($trimmedItem, FILTER_VALIDATE_EMAIL)) {
                $emails[] = $trimmedItem;
            } else {
                $foundEmail = $this->memberRepository->getEmailByUserName($trimmedItem);
                if (isset($foundEmail)) {
                    $emails[] = $foundEmail;
                }
            }
        }

        return self::filterEmails($emails);
    }

    private function filterEmails(array $emails): array
    {
        $projectId = getRouteParam('projectId');
        $memberMails = $this->memberRepository->getAllByProjectId($projectId)
            ->pluck('email')
            ->all();

        return array_filter($emails, function ($email) use ($memberMails) {
            return !in_array($email, $memberMails);
        });
    }
}
