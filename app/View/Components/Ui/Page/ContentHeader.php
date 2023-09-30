<?php

namespace App\View\Components\Ui\Page;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContentHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string  $title,
        public ?string $backUrl = null,
        public ?string $actionUrl = null,
        public ?string $actionLabel = null,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.page.content-header');
    }
}
