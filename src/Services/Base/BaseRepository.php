<?php
declare(strict_types=1);

namespace App\Services\Base;

use App\Databases\QueryBuilder;

abstract class BaseRepository
{
    public function __construct(
        protected readonly QueryBuilder $connection,
    ) {}

}
