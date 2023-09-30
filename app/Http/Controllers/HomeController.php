<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Retrieves the index view.
     */
    public function view(): View
    {
        return view('pages.home', [
            'title' => __('brand.nalikby').' '.__('brand.account'),
        ]);
    }
}
