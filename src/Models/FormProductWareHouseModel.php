<?php
declare(strict_types=1);

namespace App\Models;

use App\core\Model;
use App\Services\ProductMoving\Repositories\ProductMovingRepository;

class FormProductWareHouseModel extends Model
{
    public function __construct(
        private readonly int $productId,
        private readonly array $wareHousesId,
        private readonly int $quantity,
    ) {
        parent::__construct();
    }

    public function getWareHousesId(): array
    {
        return $this->wareHousesId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getQuantityWareHousesProduct(): int
    {
        $repository = new ProductMovingRepository();

        return $repository->getQuantityWareHousesProduct($this->getProductId(), $this->getWareHousesId()['from']);
    }

    public function rules(): array
    {
        return [
            'quantity' => [
                $this->validator::RULE_REQUIRED,
                [$this->validator::RULE_QUANTITY_MIN, 'min_quantity' => '1'],
                [$this->validator::RULE_QUANTITY_MAX, 'max_quantity' => $this->getQuantityWareHousesProduct()],
            ],

            'wareHousesId' => [
                $this->validator::RULE_WAREHOUSES_MATCH,
            ],

        ];
    }

}
