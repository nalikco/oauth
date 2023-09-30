<?php

namespace App\Actions\Paginate;

use App\Dto\Paginate\PaginatePropsDto;
use Illuminate\Http\Request;

readonly class GetPaginatePropsFromRequestAction
{
    /**
     * Retrieves the pagination properties from the request.
     *
     * @param Request $request The request object.
     * @return PaginatePropsDto The pagination properties.
     */
    public function __invoke(Request $request): PaginatePropsDto
    {
        $page = (int)$request->query('page', 1);
        $perPage = (int)$request->query('per_page', 10);

        return new PaginatePropsDto(
            page: $page,
            perPage: $perPage,
        );
    }
}
