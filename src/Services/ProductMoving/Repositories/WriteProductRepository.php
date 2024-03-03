<?php
declare(strict_types=1);

namespace App\Services\ProductMoving\Repositories;

use App\Models\Product;
use App\Services\Contracts\RepositoryInterface;

class WriteProductRepository implements RepositoryInterface
{
    public function __construct(
        private PDODriver $connection,
    ) {}

    public function getById(int $id): array
    {
    }

    public function create(Product $product): array
    {

    }

    public function updated(Product $product): array
    {

    }

    public function destroy(int $id): bool
    {

    }

}
