<?php declare(strict_types=1);

namespace App\Services\Grid;

enum ColumnSortOrder: string
{
    case ASC = 'asc';
    case DESC = 'desc';
    case NONE = 'none';
}
