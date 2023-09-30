<?php

declare(strict_types=1);

namespace App\View\Components\Ui\Header\Nav;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Link extends Component
{
    public bool $active = false;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $routeName,
    ) {
        // Check is the current route name equals to provided route name
        $this->active = request()->routeIs($this->routeName);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.header.nav.link');
    }
}
