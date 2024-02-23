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
        'product_id' => (int)$_GET['product_id'],
        'from_storage_id' => (int)$_GET['from_storage_id'],
        'to_storage_id' => (int)$_POST['to_storage_id'],
        'moving_quantity' => (int)$_POST['quantity'],
    ];

    $product = new \App\Models\Product($data['product_id'], $data['moving_quantity'], $productService->getTitleById($data['product_id']));
    $storage = new \App\Models\Storage($data['from_storage_id'], $data['to_storage_id']);

    $productAndStorageCollection = $productService->getAllAboutProduct($product, $storage);
    $storageService->moveProduct($productAndStorageCollection['product'], $productAndStorageCollection['storage']);

    $productInfoAboutMovement = $storageService->getInfoAboutProductMovement($product, $storage);
    $storageService->saveHistory($productInfoAboutMovement);

    $_SESSION['success'] = "Вы успешно переместили продукт с номером {$_GET['product_id']} со склада под номером {$_GET['from_storage_id']}
            на склад под номером {$_POST['to_storage_id']} в количестве {$_POST['quantity']} штук.";
    \header('Location: /');
    die;
}

$storages = $storageService->getAll();

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
<?php if (!empty($_GET['product_id']) && !empty($_GET['from_storage_id'])): ?>
    Вы перемещаете продукт с номером <?php echo $_GET['product_id']; ?> <br>
    Со склада под номером <?php echo $_GET['from_storage_id']; ?>
    <form action="" method="POST">
        <div class="modal-body">
            <label for="to_storage_id"></label><select name="to_storage_id" id="to_storage_id">
                <?php foreach ($storages as $value): ?>
                    <option value="<?php echo $value['id'] ?>">
                        <?php echo $value['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <label for="quantity" class="form-label">Количество</label>
        <input name="quantity" class="form-control" id="quantity" value="<?php echo $_POST['quantity'] ?? '' ?>"
               aria-describedby="quantity">
        <button type="submit" name="product_id" value="<?php echo $_GET['product_id']; ?>" class="btn btn-primary">
            Переместить
        </button>
    </form>
<?php endif; ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous">
</script>

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
                <a href="?product_id=<?php echo "{$value['id']}&from_storage_id={$value['storage_id']}"; ?>">
                    <button id="myBtn">Переместить продукт</button>
                </a>
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
