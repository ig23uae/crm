@extends('layout')
@section('title')
    Добавить Сделку
@endsection
@if(request()->route('car_id') !== null)
    @section('main_content')
        <div class="container" id="warning-header">
            @foreach($cars as $car)
                <h1 class="mx-3 mb-3">
                    Оформление
                    {{$car->car_brand}}
                    {{$car->car_name}}
                </h1>
            @endforeach
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Корзина</span>
                        <span id="selectedCountBadge" class="badge bg-primary rounded-pill">1</span>
                    </h4>
                    <ul class="list-group mb-3" id="productList">
                        @foreach($cars as $car)
                        <li class="list-group-item d-flex justify-content-between lh-sm" id="empty_cart">
                            <div>
                                <h6 class="my-0">
                                        {{$car->car_brand}}
                                        {{$car->car_name}}
                                </h6>
                                <small class="text-body-secondary">
                                        {{$car->car_color}}
                                        {{$car->car_year}}
                                        {{$car->car_vin}}
                                </small>
                            </div>
                            <span class="text-body-secondary price" id="selected_car_price">{{$car->price}}₽</span>
                        </li>
                        @endforeach
                    </ul>
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label for="total_amount" class="form-label">Сумма</label>
                            <strong id="total_amount">{{$car->price}}₽</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-lg-8">
                    <form class="needs-validation" novalidate="" action="{{route('sale_handler')}}" method="post">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="client" class="form-label fs-4">Выберите клиента</label>
                                <input class="form-control form-control-lg" list="Surname-listOptions" id="client"
                                       name="client" placeholder="Клиент">
                                <datalist id="Surname-listOptions">
                                    @foreach($clients as $client)
                                        <option
                                            value="{{$client->client_id}}">{{$client->client_id . " " . $client->name . " " . $client->surname}}</option>
                                    @endforeach
                                </datalist>
                                <div class="invalid-feedback">
                                    Выбор клиента обязателен.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="car" class="form-label fs-4">Авто</label>
                                <select class="form-select form-select-lg" id="car" name="car" required hidden>
                                    @foreach($cars as $car)
                                        <option
                                            value="{{$car->car_id }}">{{ $car->car_id . " " . $car->car_brand . " " . $car->car_name . " " . $car->car_vin }}</option>
                                    @endforeach
                                </select>
                                <div class="card">
{{--                                    <img src="путь_к_изображению" class="card-img-top" alt="Изображение машины">--}}
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $car->car_brand }} {{ $car->car_name }}</h5>
                                        <p class="card-text">
                                            <strong>Цвет:</strong> {{ $car->car_color }}<br>
                                            <strong>Год выпуска:</strong> {{ $car->car_year }}<br>
                                            <strong>VIN:</strong> {{ $car->car_vin }}<br>
                                            <strong>Цена:</strong> {{ $car->price }}₽<br>
                                            <strong>Статус:</strong>
                                            @if($car->status == 'available')
                                            <span class="text-success mb-0">{{ $car->status }}</span>
                                            @else
                                            <span class="text-warning mb-0">{{ $car->status }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">Email <span class="text-body-secondary">(Не обязательно)</span></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" autocomplete="email">
                            </div>

                            <div class="col-6">
                                <label for="country" class="form-label">Район</label>
                                <select class="form-select" id="country" name="country" autocomplete="off" disabled>
                                    <option selected disabled>Район...</option>
                                    <option>Зеленоград</option>
                                    <option>Раменское</option>
                                    <option>Химки</option>
                                </select>
                            </div>

                            <div class="col-6">
                                <label for="adress" class="form-label">Адресс</label>
                                <input type="text" class="form-control" id="adress" name="address" placeholder="1234 Main St"
                                       disabled>
                            </div>

                        </div>

                        <hr class="my-4">

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="help" name="help">
                            <label class="form-check-label" for="same-address">Помощь с регистрацией</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="truck" name="truck">
                            <label class="form-check-label" for="save-info">Вызов эвакуатора</label>
                        </div>

                        <hr class="my-4">
                        <h4 class="mb-3">Тип оплаты</h4>

                        <div class="my-3">
                            <div class="form-check">
                                <input id="credit" name="paymentMethod" type="radio" value="1" class="form-check-input"
                                       checked required>
                                <label class="form-check-label" for="credit">Задаток</label>
                            </div>
                            <div class="form-check">
                                <input id="debit" name="paymentMethod" type="radio" value="2" class="form-check-input"
                                       required>
                                <label class="form-check-label" for="debit">Полная оплата (нал)</label>
                            </div>
                            <div class="form-check">
                                <input id="paypal" name="paymentMethod" type="radio" value="3" class="form-check-input"
                                       required>
                                <label class="form-check-label" for="paypal">Полная оплата (поручение)</label>
                            </div>
                            <div class="form-check">
                                <input id="paypal1" name="paymentMethod" type="radio" value="4" class="form-check-input"
                                       required>
                                <label class="form-check-label" for="paypal">Трехсторонняя сделка</label>
                            </div>
                        </div>

                        <hr class="my-4">

                        <button class="w-100 btn btn-primary btn-lg" type="submit">Перейти к оплате</button>
                    </form>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
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
                    var listItemCar = createListItem('{{$car->car_brand}} {{$car->car_name}}', '{{$car->car_color}} {{$car->car_year}} {{$car->car_vin}}', '{{$car->price}}₽');
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
                    const listItem = document.createElement('li');
                    listItem.className = 'list-group-item d-flex justify-content-between lh-sm';

                    const div = document.createElement('div');
                    const h6 = document.createElement('h6');
                    h6.className = 'my-0';
                    h6.textContent = title;

                    const small = document.createElement('small');
                    small.className = 'text-body-secondary';
                    small.textContent = subtitle;

                    div.appendChild(h6);
                    div.appendChild(small);

                    const span = document.createElement('span');
                    span.className = 'text-body-secondary price';
                    span.textContent = price;

                    listItem.appendChild(div);
                    listItem.appendChild(span);

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
                    var lis = productList.getElementsByTagName('li');

                    // Преобразуем HTMLCollection в массив
                    var lisArray = Array.from(lis);

                    lisArray.forEach(function (li) {
                        // Используем querySelector для получения элемента по селектору
                        var priceElement = li.querySelector('.price');
                        // Проверяем, что элемент найден, прежде чем пытаться извлечь текст
                        if (priceElement) {
                            total += parseInt(priceElement.textContent.replace('₽', ''));
                        }
                    });

                    document.getElementById('selectedCountBadge').textContent = lisArray.length;
                    // Обновляем значение в элементе с id "total_amount"
                    document.getElementById('total_amount').textContent = '₽' + total;
                }
            });
        </script>
    @endsection
@else
    @section('main_content')
        <div class="container">
            <h1 class="mx-3 mb-3">Создать сделку</h1>
            <div id="warning"></div>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Корзина</span>
                        <span id="selectedCountBadge" class="badge bg-primary rounded-pill">0</span>
                    </h4>
                    <ul class="list-group mb-3" id="productList">
                        <li class="list-group-item d-flex justify-content-between lh-sm" id="empty_cart">
                            <div>
                                <h6 class="my-0">Корзина пока пуста</h6>
                                <small class="text-body-secondary">Выберите авто из списка</small>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm" id="selected_car"
                            style="display: none;">
                            <div>
                                <h6 class="my-0" id="selected_car_brand"></h6>
                                <small class="text-body-secondary" id="selected_car_details"></small>
                            </div>
                            <span class="text-body-secondary price" id="selected_car_price"></span>
                        </li>
                    </ul>
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label for="total_amount" class="form-label">Сумма</label>
                            <strong id="total_amount">0₽</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-lg-8">
                    <form class="needs-validation" novalidate="" action="{{route('sale_handler')}}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="client" class="form-label fs-4">Выберите клиента</label>
                                <input class="form-control form-control-lg" list="Surname-listOptions" id="client"
                                       name="client" placeholder="Клиент">
                                <datalist id="Surname-listOptions">
                                    @foreach($clients as $client)
                                        <option
                                            value="{{$client->client_id}}">{{$client->client_id . " " . $client->name . " " . $client->surname}}</option>
                                    @endforeach
                                </datalist>
                                <div class="invalid-feedback">
                                    Выбор клиента обязателен.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="car" class="form-label fs-4">Выберите Авто</label>
                                <select class="form-select form-select-lg" id="car" name="car" required>
                                    <option value="" disabled selected>Авто</option>
                                    @foreach($cars as $car)
                                        <option
                                            value="{{$car->car_id }}">{{ $car->car_id . " " . $car->car_brand . " " . $car->car_name . " " . $car->car_vin }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Выбор авто обязателен.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">Email <span class="text-body-secondary">(Не обязательно)</span></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" autocomplete="email">
                            </div>

                            <div class="col-6">
                                <label for="country" class="form-label">Район</label>
                                <select class="form-select" id="country" name="country" autocomplete="off" disabled>
                                    <option selected disabled>Район...</option>
                                    <option>Зеленоград</option>
                                    <option>Раменское</option>
                                    <option>Химки</option>
                                </select>
                            </div>

                            <div class="col-6">
                                <label for="adress" class="form-label">Адресс</label>
                                <input type="text" class="form-control" id="adress" name="adress" placeholder="1234 Main St" disabled>
                            </div>

                        </div>

                        <hr class="my-4">

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="help" name="help">
                            <label class="form-check-label" for="same-address">Помощь с регистрацией</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="truck" name="truck">
                            <label class="form-check-label" for="save-info">Вызов эвакуатора</label>
                        </div>

                        <hr class="my-4">
                        <h4 class="mb-3">Тип оплаты</h4>

                        <div class="my-3">
                            <div class="form-check">
                                <input id="credit" name="paymentMethod" type="radio" value="1" class="form-check-input"
                                       checked required>
                                <label class="form-check-label" for="credit">Задаток</label>
                            </div>
                            <div class="form-check">
                                <input id="debit" name="paymentMethod" type="radio" value="2" class="form-check-input"
                                       required>
                                <label class="form-check-label" for="debit">Полная оплата (нал)</label>
                            </div>
                            <div class="form-check">
                                <input id="paypal" name="paymentMethod" type="radio" value="3" class="form-check-input"
                                       required>
                                <label class="form-check-label" for="paypal">Полная оплата (поручение)</label>
                            </div>
                            <div class="form-check">
                                <input id="paypal1" name="paymentMethod" type="radio" value="4" class="form-check-input"
                                       required>
                                <label class="form-check-label" for="paypal">Трехсторонняя сделка</label>
                            </div>
                        </div>

                        <hr class="my-4">

                        <button class="w-100 btn btn-primary btn-lg" type="submit">Перейти к оплате</button>
                    </form>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/create_sale.js') }}"></script>
    @endsection
@endif


