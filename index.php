<?php
declare(strict_types=1);
\error_reporting(-1);
\session_start();

use App\Database\DatabaseConfiguration;
use App\Database\DatabasePDOConnection;
use App\Database\PDODriver;

require_once __DIR__ . '/vendor/autoload.php';

$configuration = require __DIR__ . '/config/db.php';
$dataBaseConfiguration = new DatabaseConfiguration(...$configuration);
$dataBasePDOConnection = new DatabasePDOConnection($dataBaseConfiguration);
$pdoDriver = new PDODriver($dataBasePDOConnection->connection());

$productRepository = new \App\Services\Product\Repositories\ProductRepository($pdoDriver);
$productService = new \App\Services\Product\ProductService($productRepository);

$storageRepository = new \App\Services\Storage\Repositories\StorageRepository($pdoDriver);
$storageService = new \App\Services\Storage\StorageService($storageRepository);

if (!empty($_POST)) {
    $data = [
        'product_id' => (int)$_POST['product_id'],
        'from_storage_id' => (int)$_POST['from_storage_id'],
        'to_storage_id' => (int)$_POST['to_storage_id'],
        'moving_quantity' => $_POST['quantity'],
    ];

    $productValidator = new \App\Validations\ProductValidator(
        $data['moving_quantity'],
        $productService->getQuantityProductInStorage(
            $data['product_id'],
            $data['from_storage_id']),
            ['from' => $data['from_storage_id'], 'to' => $data['to_storage_id']],
    );

    if (!$productValidator->validate()) {
        $_SESSION['errors'] = $productValidator->getErrors();
    } else {
        $product = new \App\Models\Product(
            $data['product_id'],
            (int)$data['moving_quantity'],
            $productService->getTitleById($data['product_id']),
        );

        $storage = new \App\Models\Storage($data['from_storage_id'], $data['to_storage_id']);

        $productService->getAllAboutProduct($product, $storage);
        $storageService->moveProduct($product, $storage);

        $productInfoAboutMovement = $storageService->getInfoAboutProductMovement($product, $storage);
        $storageService->saveHistory($productInfoAboutMovement);

        $_SESSION['success'] = "Вы успешно переместили продукт с номером {$_POST['product_id']} со склада под номером {$_POST['from_storage_id']}
            на склад под номером {$_POST['to_storage_id']} в количестве {$_POST['quantity']} штук.";
        \header('Location: /');
        die;
    }

}

$_SESSION['storages'] = $storageService->getAll();

$products = $productService->getAll();
$historyMovementProducts = $storageService->getAllHistoryAboutMovementProduct($products);

?>
<?php if (!empty($_SESSION['errors'])): ?>
    <?php foreach ($_SESSION['errors'] as $error): ?>
        <?php echo \nl2br($error) . '<br>'; ?>
    <?php endforeach; ?>
    <?php unset($_SESSION['errors']); ?>
    <br>
<?php endif; ?>
<?php if (!empty($_SESSION['success'])): ?>
    <?php echo \nl2br($_SESSION['success']) . '<br>'; ?>
    <?php unset($_SESSION['success']); ?>
    <br>
<?php endif; ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous">
</script>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="modalContent"></div>
    </div>
</div>
<script src="assets/script.js"></script>

</body>
<table class="table">
    <?php ?>
    <thead>
    <tr>
        <th scope="col">Айди продукта</th>
        <th scope="col">Название продукта</th>
        <th scope="col">Название склада</th>
        <th scope="col">Цена</th>
        <th scope="col">Количество</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $value): ?>
        <tr>
            <td><?php echo $value['id'] ?></td>
            <td><?php echo $value['title'] ?></td>
            <td><?php echo $value['name'] ?></td>
            <td><?php echo $value['price']; ?> </td>
            <td><?php echo $value['quantity']; ?> </td>
            <td>
                <button class="openModalBtn" data-product-id="<?php echo $value['id']; ?>" data-from-storage-id="<?php echo $value['storage_id']; ?>">
                    Переместить
                </button>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php if (!empty($historyMovementProducts)): ?>
    <h3>История перемещений:</h3>
    <table class="table">
        <?php ?>
        <thead>
        <tr>
            <th scope="col">Айди продукта</th>
            <th scope="col">История</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($historyMovementProducts as $value): ?>
            <tr>
                <td><?php echo $value['product_id'] ?></td>
                <td><?php echo $value['description'] . "\n" ?> </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
