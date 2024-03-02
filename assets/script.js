
function fetchData(productData) {
    var dataToSend = "product_id=" + encodeURIComponent(productData.productId) + "&from_storage_id=" + encodeURIComponent(productData.fromStorageId);

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../?" + dataToSend, true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;
            document.getElementById('modalContent').innerHTML = response; // Вставляем данные в модальное окно
        }
    };

    xhr.send();
}

document.addEventListener('DOMContentLoaded', function() {
    var modalButtons = document.querySelectorAll('.openModalBtn');

    modalButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var productData = {
                productId: button.getAttribute('data-product-id'),
                fromStorageId: button.getAttribute('data-from-storage-id')
            };

            fetchData(productData);

            var modal = document.getElementById('myModal');
            modal.style.display = 'block';
        });
    });

    var closeButton = document.querySelector('.close');
    closeButton.addEventListener('click', function() {
        var modal = document.getElementById('myModal');
        modal.style.display = 'none';
    });
});
