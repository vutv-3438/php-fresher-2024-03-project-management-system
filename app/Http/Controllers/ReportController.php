<?php

namespace App\Http\Controllers;

use App\Common\Enums\Action;
use App\Models\Issue;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, int $projectId)
    {
        $this->authorize(Action::REPORT, Issue::class);

        return view('report.index');
    }
}
