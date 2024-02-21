<?php
declare(strict_types=1);

namespace App\Services\LogHistoryProductMoving;

use App\Services\BaseService;

class LogHistoryProductMovingService extends BaseService
{
    public function formatToInfoAboutMovingProduct(array $data): string
    {
        $string = "{$data['from_warehouse_title']} {$data['product_title']} был {$data['from_warehouse_past_quantity']} стало {$data['from_warehouse_now_quantity']}\n";
        $string .= "{$data['to_warehouse_title']} {$data['product_title']} было {$data['to_warehouse_past_quantity']} перемещено {$data['moving_quantity']} стало {$data['to_warehouse_now_quantity']}";

        return $string;
    }

    public function addHistoryProductData(array $data): void
    {
        $result = $this->formatToInfoAboutMovingProduct($data);
        $this->repository->addHistoryProductMoving($data['product_id'], $result);
    }

    public function obtainingRemainingDataAboutMovementOfTheProduct(array $data): array
    {
        $data['from_warehouse_now_quantity'] = $this->repository->getQuantityWareHousesProduct($data['product_id'], $data['from_warehouse_id']);
        $data['to_warehouse_now_quantity'] = $this->repository->getQuantityWareHousesProduct($data['product_id'], $data['to_warehouse_id']);
        $data['from_warehouse_title'] = $this->repository->getWareHouseTitleById($data['from_warehouse_id']);
        $data['to_warehouse_title'] = $this->repository->getWareHouseTitleById($data['to_warehouse_id']);
        $data['product_title'] = $this->repository->getProductTitleById((int)$data['product_id']);

        return $data;
    }

    public function getPastQuantityWareHouses(int $productId, array $wareHousesId): array
    {
        return [
            'from_warehouse_past_quantity' => $this->repository->getQuantityWareHouseProduct($productId, $wareHousesId[0]),
            'to_warehouse_past_quantity' => $this->repository->getQuantityWareHouseProduct($productId, $wareHousesId[1]),
        ];
    }

}
