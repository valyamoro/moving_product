<?php
declare(strict_types=1);
\error_reporting(-1);
\session_start();

require_once __DIR__ . '/vendor/autoload.php';

$data = [
    'product_id' => 1,
    'from_storage_id' => 1,
    'to_storage_id' => 2,
    'transfer_quantity' => 5,
];

$product = $productReadService->getById($data['product_id']);
$fromStorage = $storageReadService->getById($data['from_storage_id']);
$toStorage = $storageReadService->getById($data['to_storage_id']);

$productMovingData = [
    'product_id' => $product->getId(),
    'from_storage_id' => $fromStorage->getId(),
    'to_storage_id' => $toStorage->getId(),
    'transfer_quantity' => $data['transfer_quantity'],
];
$productMoving = $productMovingWriteService->productMovingCollection->makeItem($productMovingData);
$fullProductMoving = $productMovingReadService->getMovementProductInfo($productMoving);

$productMovingWriteService->productMoving($fullProductMoving);

$storages = ['from' => $fromStorage, 'to' => $toStorage];
$isMovedProduct = $productMovingWriteService->saveHistory($product, $storages, $fullProductMoving->getTransferQuantity());

$productStoragesData = $storageReadService->getAllMovementsProducts();
$products = $productReadService->productCollection->makeItems($productStoragesData);

$histories = $productMovingReadService->getAll();
