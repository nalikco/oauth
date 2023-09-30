<?php

declare(strict_types=1);

namespace App\Enums;

enum FlashMessageType: string
{
    case Success = 'success';
    case Error = 'error';
    case Warning = 'warning';
}
