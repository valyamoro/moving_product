<?php
declare(strict_types=1);

namespace App\Services\ProductMoving\Repositories;

use App\Services\Contracts\RepositoryInterface;

class ReadProductRepository implements RepositoryInterface
{
    public function __construct(
        private PDODriver $connection,
    ) {}

    public function getById(int $id): array
    {

    }

    public function getAll(): array
    {

    }

    public function sortById()
    {

    }


}
