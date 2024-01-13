$(document).ready(function () {
    // Declare carData outside the event handler to make it accessible throughout the scope
    var carData = {};

    $('#car').change(function () {
        var carId = $(this).val();

        $.ajax({
            url: '/create_sale/add_handler/GetCarID',
            type: 'GET',
            data: { car: carId },
            dataType: 'json',
            success: function (data) {
                carData = data;
                // Убираем первый LI
                $('#empty_cart').remove();

                // Заполняем данные из базы данных
                $('#selected_car_brand').text(data.car_brand + ' ' + data.car_name);
                $('#selected_car_details').text(data.car_color + ' ' + data.car_year + ' ' + data.car_vin);

                $('#selected_car_price').text(data.price + '₽');
                //
                // // Отображаем li
                $('#selected_car').show();
                //
                updateTotal();
                document.getElementById('selectedCountBadge').textContent = "1";
                document.getElementById('total_amount').textContent = data.price + '₽';
                document.getElementById('truck').disabled = false;
                document.getElementById('help').disabled = false;
                // //alert-warning если статус не available
                console.log(data.status);
                $('#warning').remove();  // Remove the container (if it exists)
                var warningContainer = $('<div id="warning"></div>');  // Create a new container

                if (data.status !== 'available') {
                    var warningAlert = '<div class="alert alert-warning" role="alert">Машина не доступна в наличии. Статус: <strong>' + data.status + '</strong></div>';
                    warningContainer.append(warningAlert);  // Append the warning alert to the container
                    $('#warning-header').append(warningContainer);  // Append the container to the target element in your HTML
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    const helpCheckbox = document.getElementById('help');
    const truckCheckbox = document.getElementById('truck');
    const productList = document.getElementById('productList');
    const inputAdress = document.getElementById('adress');
    const inputCountry = document.getElementById('country');

    helpCheckbox.addEventListener('change', function () {
        updateList();
    });

    truckCheckbox.addEventListener('change', function () {
        updateList();
        inputAdress.disabled = !truckCheckbox.checked;
        inputCountry.disabled = !truckCheckbox.checked;
        if (truckCheckbox.checked) {
            inputCountry.focus();
        }
    });

    function updateList() {
        // Очищаем список
        clearList();

        // Добавляем элемент с информацией о машине всегда
        const listItemCar = createListItem(carData.car_brand + ' ' + carData.car_name, carData.car_color + ' ' + carData.car_year + ' ' + carData.car_vin, carData.price + '₽');
        productList.appendChild(listItemCar);

        // Добавляем элементы в список в зависимости от состояния checkbox
        if (helpCheckbox.checked) {
            const listItemHelp = createListItem('Помощь в Гаи', 'помощь', '5000₽');
            productList.appendChild(listItemHelp);
        }

        if (truckCheckbox.checked) {
            const listItemTruck = createListItem('Эвакуатор', 'Эвакуатор', '5000₽');
            productList.appendChild(listItemTruck);
        }

        // Обновляем сумму после обновления списка
        updateTotal();
    }

    function createListItem(title, subtitle, price) {
        const listItem = document.createElement('dl');

        const dt = document.createElement('dt');
        dt.textContent = title;

        const ddDetails = document.createElement('div');
        ddDetails.className = 'col';
        ddDetails.textContent = subtitle;

        const ddPrice = document.createElement('div');
        ddPrice.className = 'col price text-right';
        ddPrice.textContent = price;

        listItem.appendChild(dt);

        const rowDiv = document.createElement('div');
        rowDiv.className = 'row';
        rowDiv.appendChild(ddDetails);
        rowDiv.appendChild(ddPrice);

        listItem.appendChild(rowDiv);

        return listItem;
    }

    function clearList() {
        // Очищаем весь список, оставляя только первый элемент
        while (productList.childNodes.length > 1) {
            productList.removeChild(productList.lastChild);
        }
    }

    function updateTotal() {
        var total = 0;
        var dls = productList.getElementsByTagName('dl');

        // Преобразуем HTMLCollection в массив
        var dlsArray = Array.from(dls);

        dlsArray.forEach(function (dl) {
            // Используем querySelector для получения элемента по селектору
            var priceElement = dl.querySelector('.price');
            // Проверяем, что элемент найден, прежде чем пытаться извлечь текст
            if (priceElement) {
                total += parseInt(priceElement.textContent.replace('₽', ''));
            }
        });

        document.getElementById('selectedCountBadge').textContent = dlsArray.length;
        // Обновляем значение в элементе с id "total_amount"
        document.getElementById('total_amount').textContent = '₽' + total;
    }
});
