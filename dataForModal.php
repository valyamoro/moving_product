<?php
session_start();
?>
<form id="myForm" action="index.php" method="POST">
    <div class="modal-body">
        <label for="to_storage_id"></label><select name="to_storage_id" id="to_storage_id">
            <?php foreach ($_SESSION['storages'] as $value): ?>
                <option value="<?php echo $value['id'] ?>">
                    <?php echo $value['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <label for="quantity" class="form-label">Количество</label>
    <input name="quantity" class="form-control" id="quantity" aria-describedby="quantity">
    <input type="hidden" name="product_id" value="<?php echo $_GET['product_id']; ?>">
    <input type="hidden" name="from_storage_id" value="<?php echo $_GET['from_storage_id']; ?>">
    <button type="submit" name="product_id" value="<?php echo $_GET['product_id']; ?>" class="btn btn-primary">
        Переместить
    </button>
</form>

<script>
    document.getElementById("submitButton").addEventListener("click", function() {
        document.getElementById("myForm").submit();
    });
</script>
