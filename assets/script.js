
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

function moveProduct() {
    const productId = document.getElementById('product_id').value;
    const fromStorageId = document.getElementById('from_storage_id').value;
    const toStorageId = document.getElementById('to_storage_id').value;
    const quantity = document.getElementById('quantity').value;

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
                    const validateError = decodeURIComponent(cookies.split('; ').find(cookie => cookie.startsWith('validate_error=')).split('=')[1]);
                    document.getElementById('validate_error').innerText = validateError;
                } else {
                    const modal = document.getElementById('myModal');
                    modal.style.display = 'none';

                    const cookies = document.cookie;
                    const success = decodeURIComponent(cookies.split('; ').find(cookie => cookie.startsWith('success=')).split('=')[1]);
                    document.getElementById('success').innerText = success;

                    const error = decodeURIComponent(cookies.split('; ').find(cookie => cookie.startsWith('error=')).split('=')[1]);
                    document.getElementById('error').innerText = error;
                }
            })
    } else {
        document.getElementById('validate_error').innerText = 'Пожалуйста, введите количество товаров для отправки.';
    }
}
