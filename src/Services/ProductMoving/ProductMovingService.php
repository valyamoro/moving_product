<?php
declare(strict_types=1);

namespace App\Services\ProductMoving;

use App\Services\BaseService;

class ProductMovingService extends BaseService
{
    public function movingProduct(array $data): array
    {

        dump($data);
        $data = \array_merge($this->getNeedDataAboutProduct($data), $data);
        dump($data);
        if (false === $data['is_add']) {
            if ($data['quantity_product_from_warehouse'] <= $data['moving_quantity']) {
                $this->repository->deleteProduct($data['product_id'], $data['from_warehouse_id']);
                $this->repository->updateProduct($data['quantity_sum_current_warehouse'], $data['product_id'],
                    $data['to_warehouse_id']);
            } else {
                $this->repository->updateProduct($data['quantity_difference_current_warehouse'], $data['product_id'],
                    $data['from_warehouse_id']);
                $this->repository->updateProduct($data['quantity_sum_current_warehouse'], $data['product_id'],
                    $data['to_warehouse_id']);
            }
        } else {
            if ($data['quantity_current_warehouse'] === 0) {
                $this->repository->deleteProduct($data['product_id'], $data['from_warehouse_id']);
            } else {
                $this->repository->updateProduct($data['quantity_current_warehouse'], $data['product_id'],
                    $data['from_warehouse_id']);
            }

            $this->repository->addProduct($data['product_id'], $data['to_warehouse_id'], $data['moving_quantity']);
        }

        return [
            'from_warehouse_past_quantity' => $data['from_warehouse_product_data']['quantity'],
            'to_warehouse_past_quantity' => $data['to_warehouse_product_data']['quantity'] ?? 0,
        ];
    }

    private function getNeedDataAboutProduct(array $data): array
    {
        $data['from_warehouse_product_data'] = $this->repository->getProductData($data['product_id'],
            $data['from_warehouse_id']);
        $data['to_warehouse_product_data'] = $this->repository->getProductData($data['product_id'],
            $data['to_warehouse_id']);

        $data['quantity_product_from_warehouse'] = $this->repository->getQuantityWareHousesProduct($data['product_id'],
        $data['from_warehouse_id']);
        $data['quantity_product_to_warehouse'] = $this->repository->getQuantityWareHousesProduct($data['product_id'],
            $data['to_warehouse_id']);

        $data['quantity_difference_current_warehouse'] = $data['quantity_product_from_warehouse'] - $data['moving_quantity'];
        $data['quantity_sum_current_warehouse'] = $data['quantity_product_to_warehouse'] + $data['moving_quantity'];

        if (\is_null($data['to_warehouse_product_data'])) {
            $data['is_add'] = true;
            $data['quantity_current_warehouse'] = $data['quantity_difference_current_warehouse'];
        } else {
            $data['is_add'] = false;
            $data['quantity_current_warehouse'] = $data['quantity_sum_current_warehouse'];
        }

        return $data;
    }

}
