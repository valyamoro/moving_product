<?php
declare(strict_types=1);

namespace App\Services\Home;

use App\Services\BaseService;

class HomeService extends BaseService
{
    public function getAllHistoryMovementProducts(): array
    {
        $result = [];

        $historyMoves = $this->repository->getAllHistoryMovementProducts();

        foreach ($this->repository->getAllProducts() as $value) {
            $string = '';
            foreach ($historyMoves as $historyMove) {
                if ($value['id'] === $historyMove['product_id']) {
                    $string .= ($historyMove['description'] . '<br>');
                }
            }

            if (!empty($string)) {
                $result[] = ['product_id' => $value['id'], 'description' => $string];
            }
        }

        return $this->deleteDuplicates($result, 'product_id');
    }

    public function getAllProducts(): array
    {
        return $this->repository->getAllProducts();
    }

    public function getAllStorages(): array
    {
        return $this->repository->getAllStorages();
    }

    private function deleteDuplicates(array $data, string $key): array
    {
        $uniqueIds = [];

        return \array_filter($data, function($item) use (&$uniqueIds, $key) {
            if (!\in_array($item[$key], $uniqueIds)) {
                $uniqueIds[] = $item[$key];
                return true;
            }

            return false;
        });
    }

}
