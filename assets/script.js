
function fetchData(productData) {
    // Формируем строку данных для отправки на сервер
    var dataToSend = "product_id=" + encodeURIComponent(productData.productId) + "&from_storage_id=" + encodeURIComponent(productData.fromStorageId);

    // Создаем объект XMLHttpRequest для выполнения запроса
    var xhr = new XMLHttpRequest();
    // Открываем соединение с сервером
    xhr.open("GET", "../dataForModal.php?" + dataToSend, true);

    // Устанавливаем обработчик события изменения состояния запроса
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Обрабатываем полученный ответ
            var response = xhr.responseText;
            document.getElementById('modalContent').innerHTML = response; // Вставляем данные в модальное окно
        }
    };

    // Отправляем запрос на сервер
    xhr.send();
}

document.addEventListener('DOMContentLoaded', function() {
    // Получаем все кнопки с классом "openModalBtn"
    var modalButtons = document.querySelectorAll('.openModalBtn');

    // Для каждой кнопки добавляем обработчик события click
    modalButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Получаем данные продукта из атрибутов кнопки
            var productData = {
                productId: button.getAttribute('data-product-id'),
                fromStorageId: button.getAttribute('data-from-storage-id')
            };

            // Вызываем функцию fetchData() перед открытием модального окна
            fetchData(productData);

            // Открываем модальное окно
            var modal = document.getElementById('myModal');
            modal.style.display = 'block';
        });
    });

    // Добавляем обработчик события для кнопки закрытия модального окна
    var closeButton = document.querySelector('.close');
    closeButton.addEventListener('click', function() {
        var modal = document.getElementById('myModal');
        modal.style.display = 'none';
    });
});


















// function fetchData(productData) {
//     var dataToSend = "example_data=example_value"; // Данные, которые вы хотите передать
//     var xhr = new XMLHttpRequest();
//     xhr.open("GET", "../dataForModal.php?" + dataToSend, true);
//     xhr.onreadystatechange = function() {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             var response = xhr.responseText;
//             // Обработка ответа
//             document.getElementById('modalContent').innerHTML = response; // Вставляем данные в модальное окно
//         }
//     };
//     xhr.send();
// }







//
// document.getElementById('openModalBtn').addEventListener('click', function() {
//     let button = this;
//     var productData = button.value;
//     fetchData(productData); // Вызываем функцию fetchData() перед открытием модального окна
//     var modal = document.getElementById('myModal');
//     modal.style.display = 'block';
// });
//
// document.getElementsByClassName('close')[0].addEventListener('click', function() {
//     document.getElementById('myModal').style.display = 'none';
// });