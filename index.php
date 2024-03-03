<?php
declare(strict_types=1);
\error_reporting(-1);

use App\Database\DatabaseConfiguration;
use App\Database\DatabasePDOConnection;
use App\Database\PDODriver;

require_once __DIR__ . '/vendor/autoload.php';

$session = new \App\core\Http\Session();
$session->start(true);

$request = new \App\core\Http\Request();
$configuration = require __DIR__ . '/config/db.php';
$dataBaseConfiguration = new DatabaseConfiguration(...$configuration);
$dataBasePDOConnection = new DatabasePDOConnection($dataBaseConfiguration);
$pdoDriver = new PDODriver($dataBasePDOConnection->connection());

$productRepository = new \App\Services\Product\Repositories\ProductRepository($pdoDriver);
$productService = new \App\Services\Product\ProductService($productRepository, $session);

$storageRepository = new \App\Services\Storage\Repositories\StorageRepository($pdoDriver);
$storageService = new \App\Services\Storage\StorageService($storageRepository, $session);
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

//if ($request->getMethod('to_storage_id') && $request->getMethod('from_storage_id') && $request->getMethod('product_id')) {
if ($data) {
//    $data = [];
//    foreach ($_POST as $key => $value) {
//        $data[$key] = \htmlspecialchars(\strip_tags(\trim($value)));
//    }

    $data = [
        'product_id' => (int)$data['product_id'],
        'from_storage_id' => (int)$data['from_storage_id'],
        'to_storage_id' => (int)$data['to_storage_id'],
        'move_quantity' => (int)$data['quantity'],
    ];

    $productStorageData = $productService->getAllProductStorage($data['product_id'], $data['from_storage_id']);
    $productValidator = new \App\Validations\ProductValidator(
        $data['move_quantity'],
        $productStorageData['quantity'] ?? 0,
        ['from' => $data['from_storage_id'], 'to' => $data['to_storage_id']],
    );

    if (!$productValidator->validate()) {
        \http_response_code(400);
        \setcookie('validate_errors', $productValidator->getErrors()[0]);
//        $session->setFlash(['validate_errors' => $productValidator->getErrors()]);
    } else {
        $productData = $productService->getById($data['product_id']);
        $product = \App\Factory\ProductFactory::create([
            'title' => $productData['title'],
            'price' => $productData['price'],
            'quantity' => $productData['quantity'],
            'created_at' => $productData['created_at'],
            'updated_at' => $productData['updated_at'],
        ]);
        $product->setId($productData['id']);

        $productStorage = new \App\Models\ProductStorage(
            $data['from_storage_id'],
            $data['to_storage_id'],
            $data['move_quantity'],
        );
        $productStorage = $productService->getAllAboutProduct($product, $productStorage);
        if ($productStorage->getPastQuantityFromStorage() === 0) {
            $session->setFlash(['error' => 'На этом складе нету этого товара! Пожалуйста выберите другой склад.']);
        } else {
            $isMovedProduct = $storageService->moveProduct($product, $productStorage);
            if ($isMovedProduct) {
                if ($storageService->saveHistory($product, $productStorage)) {
                    $msg = "Вы успешно переместили продукт с номером {$data['product_id']} со склада под номером {$data['from_storage_id']}
                    на склад под номером {$data['to_storage_id']} в количестве {$data['move_quantity']} штук.";
                    $session->setFlash(['success' => $msg]);
                } else {
                    $this->session->setFlash(['error' => 'История о перемещении товара не была сохранена! Пожалуйста, обратитесь к администратору сайта']);
                }
            }
        }
    }
}

$data = $productService->getAllAboutMovementProducts();
$products = $productService->getCollection($data);
$storages = $storageService->getCollection($data);
$storages = $storageService->addProductInStorage($storages, $products);

$productStorages = $storageService->getProductStoragesCollection($products);
$storagesCollection = $storageService->getCollection();

?>
<?php if (!empty($session->getFlash()['validate_errors'])): ?>
    <?php foreach ($session->getFlash()['validate_errors'] as $error): ?>
        <?php echo \nl2br($error) . '<br>'; ?>
    <?php endforeach; ?>
    <?php $session->delete('validate_errors'); ?>
    <br>
<?php endif; ?>
<?php if (!empty($session->getFlash()['success'])): ?>
    <?php echo \nl2br($session->getFlash()['success']); ?>
    <?php $session->delete('success'); ?>
    <br>
<?php endif; ?>
<?php if (!empty($session->getFlash()['error'])): ?>
    <?php echo \nl2br($session->getFlash()['error']); ?>
    <?php $session->delete('error'); ?>
    <br>
<?php endif; ?>
<?php if ($request->getMethod('product_id') && $request->getMethod('from_storage_id') && \is_null($request->getMethod('quantity'))): ?>
    <div id="validate_error"></div>
    <div class="modal-body">
        Вы перемещаете продукт с айди: <?php echo $request->getMethod('product_id'); ?><br>
        Со склада с айди: <?php echo $request->getMethod('from_storage_id'); ?> <br>
        На склад: <br>
        <label for="to_storage_id"></label><select name="to_storage_id" id="to_storage_id">
            <?php foreach ($storagesCollection as $value): ?>
                <option value="<?php echo $value->getId() ?>">
                    <?php echo $value->getName() ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <label for="quantity" class="form-label">Количество</label>
    <input type="text" name="quantity" id="numberInput" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
    <input type="hidden" name="product_id" value="<?php echo $request->getMethod('product_id'); ?>">
    <input type="hidden" name="from_storage_id" value="<?php echo $request->getMethod('from_storage_id'); ?>">
    <button id="button" name="product_id" type="button" value="<?php echo $request->getMethod('product_id'); ?>"
            class="btn btn-primary" onclick="moveProduct()">
        Переместить
    </button>
<?php else: ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
          crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<script>
    function moveProduct() {
        const productId = document.querySelector('input[name="product_id"]').value;
        const fromStorageId = document.querySelector('input[name="from_storage_id"]').value;
        const toStorageId = document.getElementById('to_storage_id').value;
        const quantity = document.getElementById('numberInput').value;

        const data = {
            product_id: productId,
            from_storage_id: fromStorageId,
            to_storage_id: toStorageId,
            quantity: quantity
        };

        if (parseInt(quantity) > 0) {
            fetch('index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => {
                    if (response.status === 400) {
                        const cookies = document.cookie;
                        const validateError = decodeURIComponent(cookies.split('; ').find(cookie => cookie.startsWith('validate_errors=')).split('=')[1]);
                        document.getElementById('validate_error').innerText = validateError;
                    } else {
                        window.location.href = '/';
                    }
                })
        } else {
            document.getElementById('validate_error').innerText = 'Пожалуйста, введите количество товаров для отправки.';
        }
    }
</script>
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
    <?php foreach ($storages as $storage): ?>
        <tr>
            <td><?php echo $storage->getProduct()->getId() ?></td>
            <td><?php echo $storage->getProduct()->getTitle() ?></td>
            <td><?php echo $storage->getName(); ?> </td>
            <td><?php echo $storage->getProduct()->getPrice(); ?> </td>
            <td><?php echo $storage->getProduct()->getQuantity(); ?> </td>
            <td>
                <button class="openModalBtn" data-product-id="<?php echo $storage->getProduct()->getId(); ?>"
                        data-from-storage-id="<?php echo $storage->getId(); ?>">
                    Переместить
                </button>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php if (!empty($productStorages)): ?>
    <h3>История перемещений:</h3>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Айди продукта</th>
            <th scope="col">История</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($productStorages as $key => $productStorage): ?>
            <?php foreach ($productStorage as $value): ?>
                <tr>
                    <td><?php echo $key ?></td>
                    <td><?php echo "{$value->getFromStorage()->getName()} {$value->getProduct()->getTitle()} было {$value->getPastQuantityFromStorage()}
                    стало {$value->getNowQuantityFromStorage()} | {$value->getFromStorage()->getCreatedAt()}<br>
                   {$value->getToStorage()->getName()} {$value->getProduct()->getTitle()} было {$value->getPastQuantityToStorage()}
                    перемещено {$value->getMoveQuantity()} стало {$value->getNowQuantityToStorage()} | {$value->getToStorage()->getCreatedAt()}"; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<?php endif; ?>
