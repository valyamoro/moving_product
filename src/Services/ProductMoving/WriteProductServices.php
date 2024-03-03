<?php
declare(strict_types=1);

namespace App\Services\ProductMoving;

use App\Models\Model;
use App\Models\Product;
use App\Services\Contracts\ServiceInterface;
use App\Services\ProductMoving\Repositories\ReadProductRepository;
use App\Services\ProductMoving\Repositories\WriteProductRepository;

// только для работы с запись, обновления, удаления.
class WriteProductServices implements ServiceInterface
{
    public function __construct(
        private WriteProductRepository $repository,
    ) {}

    public function getById(int $id): Model
    {
    }

    public function create(Product $product): Product
    {
    }

    public function update(Product $product): Product
    {
    }

    public function destroy(int $id): bool
    {
    }

}
