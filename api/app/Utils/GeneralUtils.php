<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class GeneralUtils
{
    public static function generatePaginationFromRedis(string $paginatorFromRedis): Paginator
    {
        $paginatorArray = json_decode($paginatorFromRedis, true);

        $data = collect($paginatorArray['data'])->map(fn ($item) => (object) $item);

        $total = $paginatorArray['total'];
        $perPage = $paginatorArray['per_page'];
        $currentPage = $paginatorArray['current_page'];

        return new LengthAwarePaginator($data, $total, $perPage, $currentPage);
    }
}
