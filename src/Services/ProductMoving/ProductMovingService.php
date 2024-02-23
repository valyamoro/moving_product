<?php
declare(strict_types=1);

namespace App\Services\ProductMoving;

use App\Services\BaseService;

class ProductMovingService extends BaseService
{
    public function movingProduct(array $data): void
    {
        if (false === $data['is_add']) {
            if ($data['quantity_product_from_storage'] <= $data['moving_quantity']) {
                $this->repository->deleteProduct($data['product_id'], $data['from_storage_id']);
            } else {
                $this->repository->updateProduct(
                    $data['quantity_difference_current_storage'],
                    $data['product_id'],
                    $data['from_storage_id']
                );
            }
            $this->repository->updateProduct($data['quantity_sum_current_storage'], $data['product_id'],
                $data['to_storage_id']);
        } else {
            if ($data['quantity_current_storage'] === 0) {
                $this->repository->deleteProduct($data['product_id'], $data['from_storage_id']);
            } else {
                $this->repository->updateProduct($data['quantity_current_storage'], $data['product_id'], $data['from_storage_id']);
            }

            $this->repository->addProduct($data['product_id'], $data['to_storage_id'], (int)$data['moving_quantity']);
        }
    }

    public function getNeedDataAboutProduct(array $data): array
    {
        $data['quantity_product_from_storage'] = $this->repository->getQuantityWareHousesProduct($data['product_id'], $data['from_storage_id']);
        $data['quantity_product_to_storage'] = $this->repository->getQuantityWareHousesProduct($data['product_id'], $data['to_storage_id']);

        $data['quantity_difference_current_storage'] = $data['quantity_product_from_storage'] - $data['moving_quantity'];
        $data['quantity_sum_current_storage'] = $data['quantity_product_to_storage'] + $data['moving_quantity'];

        if ($data['quantity_product_to_storage'] === 0) {
            $data['is_add'] = true;
            $data['quantity_current_storage'] = $data['quantity_difference_current_storage'];
        } else {
            $data['is_add'] = false;
            $data['quantity_current_storage'] = $data['quantity_sum_current_storage'];
        }

        return $data;
    }

}
