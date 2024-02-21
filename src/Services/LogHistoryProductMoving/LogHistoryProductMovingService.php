<?php
declare(strict_types=1);

namespace App\Services\LogHistoryProductMoving;

use App\Services\BaseService;

class LogHistoryProductMovingService extends BaseService
{
    public function formatToInfoAboutMovingProduct(array $data): string
    {
        $data = $this->obtainingRemainingDataAboutMovementOfTheProduct($data);

        $string = "{$data['from_warehouse_title']} {$data['product_title']} был {$data['from_warehouse_past_quantity']} стало {$data['from_warehouse_now_quantity']}\n";
        $string .= "{$data['to_warehouse_title']} {$data['product_title']} было {$data['to_warehouse_past_quantity']} перемещено {$data['moving_quantity']} стало {$data['to_warehouse_now_quantity']}";

        return $string;
    }

    public function addHistoryProductData(array $data): void
    {
        $result = $this->formatToInfoAboutMovingProduct($data);
        $this->repository->addHistoryProductMoving($data['product_id'], $result);
    }

    private function obtainingRemainingDataAboutMovementOfTheProduct(array $data): array
    {
        $data['from_warehouse_now_quantity'] = $this->repository->getQuantityWareHousesProduct($data['product_id'], $data['from_warehouse_id']);
        $data['to_warehouse_now_quantity'] = $this->repository->getQuantityWareHousesProduct($data['product_id'], $data['to_warehouse_id']);
        $data['from_warehouse_title'] = $this->repository->getWareHouseTitleById($data['from_warehouse_id']);
        $data['to_warehouse_title'] = $this->repository->getWareHouseTitleById($data['to_warehouse_id']);
        $data['product_title'] = $this->repository->getProductTitleById((int)$data['product_id']);

        return $data;
    }


}
