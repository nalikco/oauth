<?php

namespace App\Dto\Paginate;

readonly class PaginatePropsDto
{
    public function __construct(
        public int $page,
        public int $perPage,
    )
    {
    }
}
