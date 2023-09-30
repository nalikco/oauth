<?php

declare(strict_types=1);

namespace App\View\Components\Ui\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $title,
        public string $value = '',
        public string $type = 'text',
        public string $placeholder = '',
        public bool $required = false,
        public bool $autoFocus = false,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.form.input');
    }
}
