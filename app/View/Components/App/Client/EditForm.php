<?php

namespace App\View\Components\App\Client;

use App\Models\Passport\Client;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EditForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string  $actionUrl,
        public string  $method = 'POST',
        public ?Client $client = null,
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.app.client.edit-form');
    }
}
