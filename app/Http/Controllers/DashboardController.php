<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Authenticate\GetAuthenticatedUserAction;
use App\Repositories\TokenRepository;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly TokenRepository $tokenRepository,
        private readonly GetAuthenticatedUserAction $getAuthenticatedUserAction,
    ) {
    }

    /**
     * Returns the dashboard view.
     *
     * @return View The dashboard view
     */
    public function view(): View
    {
        return view('pages.dashboard', [
            'title' => __('brand.nalikby') . ' ' . __('brand.account'),
            'clients' => $this->tokenRepository->getActiveGroupedByClientForUser(
                ($this->getAuthenticatedUserAction)()->id,
            ),
        ]);
    }
}
