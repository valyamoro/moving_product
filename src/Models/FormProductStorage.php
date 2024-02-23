<?php
declare(strict_types=1);

namespace App\Models;

use App\core\Model;
use App\Database\PDODriver;
use App\Services\ProductMoving\Repositories\ProductMovingRepository;

class FormProductStorage extends Model
{
    public function __construct(
        private readonly int $productId,
        private readonly array $storagesId,
        private readonly int|string $quantity,
    ) {
        parent::__construct();
    }

    public function getStoragesId(): array
    {
        return $this->storagesId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int|string
    {
        return $this->quantity;
    }

    public function getQuantityStoragesProduct(PDODriver $connection): int
    {
        $repository = new ProductMovingRepository($connection);

        return $repository->getQuantityWareHousesProduct($this->getProductId(), $this->getStoragesId()['from']);
    }

    public function rules(PDODriver $connection): array
    {
        return [
            'quantity' => [
                $this->validator::RULE_REQUIRED,
                $this->validator::RULE_NUMBERS,
                [$this->validator::RULE_QUANTITY_MIN, 'min_quantity' => '1'],
                [$this->validator::RULE_QUANTITY_MAX, 'max_quantity' => $this->getQuantityStoragesProduct($connection)],
            ],

            'storagesId' => [
                [$this->validator::RULE_STORAGE_MATCH, 'is_match' => $this->getStoragesId()['from'] === $this->getStoragesId()['to']],
            ],

        ];
    }

}
