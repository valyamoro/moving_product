<?php
declare(strict_types=1);

namespace App\Services\HistoryProductMoving;

use App\Services\BaseService;

class HistoryProductMovingService extends BaseService
{
    public function getStringProductInfo(array $data): string
    {
        $date = \date('d-m-Y H:i');
        $string = "{$data['from_storage_title']} {$data['product_title']} был {$data['from_storage_past_quantity']}
         стало {$data['from_storage_now_quantity']} {$date}\n";
        $string .= "| {$data['to_storage_title']} {$data['product_title']} было {$data['to_storage_past_quantity']}
         перемещено {$data['moving_quantity']} стало {$data['to_storage_now_quantity']} {$date}";

        return $string;
    }

    public function save(array $data): void
    {
        $result = $this->getStringProductInfo($data);
        $this->repository->addHistoryProductMoving($data['product_id'], $result);
    }

    public function obtainingRemainingDataAboutMovementOfTheProduct(array $data): array
    {
        $data['from_storage_now_quantity'] = $this->repository->getQuantityWareHousesProduct($data['product_id'], $data['from_storage_id']);
        $data['to_storage_now_quantity'] = $this->repository->getQuantityWareHousesProduct($data['product_id'], $data['to_storage_id']);
        $data['from_storage_title'] = $this->repository->getStorageTitleById($data['from_storage_id']);
        $data['to_storage_title'] = $this->repository->getStorageTitleById($data['to_storage_id']);
        $data['product_title'] = $this->repository->getProductTitleById((int)$data['product_id']);

        return $data;
    }

    public function getPastQuantityWareHouses(int $productId, array $storagesId): array
    {
        return [
            'from_storage_past_quantity' => $this->repository->getQuantityStorageProduct($productId, $storagesId[0]),
            'to_storage_past_quantity' => $this->repository->getQuantityStorageProduct($productId, $storagesId[1]),
        ];
    }

}
