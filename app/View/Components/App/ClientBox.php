<?php

namespace App\View\Components\App;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ClientBox extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string  $brand,
        public string  $url,
        public string  $name,
        public string  $description,
        public string  $deleteUrl,
        public string  $createdAtLabel,
        public Carbon  $createdAt,
        public ?string $imageUrl = null,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.app.client-box');
    }
}
