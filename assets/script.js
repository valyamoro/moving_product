
function fetchData(productData) {
    const dataToSend = "product_id=" + encodeURIComponent(productData.productId) + "&from_storage_id=" + encodeURIComponent(productData.fromStorageId);

    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../?" + dataToSend, true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('modalContent').innerHTML = xhr.responseText; // Вставляем данные в модальное окно
        }
    };

    xhr.send();
}

document.addEventListener('DOMContentLoaded', function() {
    const modalButtons = document.querySelectorAll('.openModalBtn');

    modalButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const productData = {
                productId: button.getAttribute('data-product-id'),
                fromStorageId: button.getAttribute('data-from-storage-id')
            };

            fetchData(productData);

            const modal = document.getElementById('myModal');
            modal.style.display = 'block';
        });
    });

    const closeButton = document.querySelector('.close');
    closeButton.addEventListener('click', function() {
        const modal = document.getElementById('myModal');
        modal.style.display = 'none';
    });
});
