@extends('layouts.admin_layout')
@section('title', 'Посмотреть авто')
@if(request()->input('car_id') == null)
    @section('main_content')
        <section class="content-header">
        <div class="container-fluid" id="warning-header">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Создать сделку</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fas fa-check"></i>{{session('success')}}</h4>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fas fa-circle-xmark"></i>{{session('error')}}</h4>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div id="warning"></div>
        </div><!-- /.container-fluid -->
    </section>
        <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <form action="{{route('sale_store')}}" method="post">
                            @csrf
                            <input type="hidden" name="user" value="{{auth()->user()->id}}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="client">Выберите клиента</label>
                                    <input class="form-control form-control-lg" list="Surname-listOptions" id="client"
                                           name="client" placeholder="Клиент">
                                    <datalist id="Surname-listOptions">
                                        @foreach($clients as $client)
                                            <option
                                                value="{{$client->client_id}}">{{$client->client_id . " " . $client->name . " " . $client->surname}}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="form-group">
                                    <label for="car">Выберите авто</label>
                                    <select class="custom-select form-control-border custom-select-lg" id="car" name="car">
                                        <option selected disabled>Авто</option>
                                        @foreach($cars as $car)
                                            <option
                                                value="{{$car->car_id }}">{{ $car->car_id . " " . $car->car_brand . " " . $car->car_name . " " . $car->car_vin }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="email" style="user-select: none">Email <span class="text-body-secondary">(Не обязательно)</span></label>
                                    <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="you@example.com" autocomplete="email">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="country">Район</label>
                                            <select class="custom-select form-control-border" id="country" name="country" autocomplete="off" disabled>
                                                <option selected disabled>Район...</option>
                                                <option>Зеленоград</option>
                                                <option>Раменское</option>
                                                <option>Химки</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="adress">Адрес</label>
                                            <input type="text" class="form-control" id="adress" name="adress" placeholder="Введите адрес" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="help" name="help" disabled>
                                                <label class="custom-control-label" for="help">Помощь с регистрацией</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="truck" name="truck" disabled>
                                                <label class="custom-control-label" for="truck">Вызов эвакуатора</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="price">Цена</label>
                                    <input type="text" class="form-control form-control-lg" id="price" name="price" placeholder="Введите цену">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="PriceBd" class="custom-control-input" id="exampleCheck1">
                                        <label class="custom-control-label" for="exampleCheck1">Цена по каталогу</label>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label>Тип оплаты:</label>
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="custom-control custom-radio">
                                                <input id="part" name="paymentMethod" type="radio" value="1" class="custom-control-input" checked required>
                                                <label for="part" class="custom-control-label">Задаток</label>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="custom-control custom-radio">
                                                <input id="full1" name="paymentMethod" type="radio" value="2" class="custom-control-input" required>
                                                <label for="full1" class="custom-control-label">Полная оплата (нал)</label>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="custom-control custom-radio">
                                                <input id="full2" name="paymentMethod" type="radio" value="3" class="custom-control-input" required>
                                                <label for="full2" class="custom-control-label">Полная оплата (поручение)</label>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="custom-control custom-radio">
                                                <input id="credit" name="paymentMethod" type="radio" value="4" class="custom-control-input" required>
                                                <label for="credit" class="custom-control-label">Трехсторонняя сделка</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Корзина</h3>
                            <div class="card-tools">
                                <h4><span class="badge badge-primary" id="selectedCountBadge">0</span></h4>
                            </div><!-- /.card-tools -->
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <dl id="productList">
                                <div id="empty_cart" class="product-item">
                                    <dt>Корзина пока пуста</dt>
                                    <dd>Выберите авто из списка</dd>
                                </div>

                                <div id="selected_car" class="product-item">
                                    <dt id="selected_car_brand"></dt>
                                    <dd>
                                        <div class="row">
                                            <div class="col">
                                                <span id="selected_car_details"></span>
                                            </div>
                                            <div class="col text-right">
                                                <span class="price" id="selected_car_price"></span>
                                            </div>
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div><!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col">
                                    <label for="total_amount">Сумма</label>
                                </div>
                                <div class="col text-right">
                                    <strong id="total_amount">0₽</strong>
                                </div>
                            </div>
                        </div><!-- /.card-footer -->
                    </div><!-- /.card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Сотрудник</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <h5><strong>Сотрудник: </strong>{{ auth()->user()->name }}</h5>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                </div><!-- /.col-md-4 -->
            </div><!-- /.row -->
        </div>
    </section>
    @endsection
    @section('scripts')
        <script src="{{asset('../js/create_sale.js')}}"></script>
    @endsection
@else
    @section('main_content')
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Создать сделку {{$car->car_brand . ' ' . $car->car_name}}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fas fa-check"></i>{{session('success')}}</h4>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fas fa-check"></i>{{session('error')}}</h4>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div><!-- /.container-fluid -->
    </section>
        <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Авто</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div><!-- /.card-tools -->
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">
                                <strong>Авто:</strong>
                                {{ $car->car_brand }} {{ $car->car_name }}
                            </h5>
                            <p class="card-text">
                                <strong>Цвет:</strong> {{ $car->car_color }}<br>
                                <strong>Год выпуска:</strong> {{ $car->car_year }}<br>
                                <strong>VIN:</strong> {{ $car->car_vin }}<br>
                                <strong>Цена:</strong> {{ $car->price }}₽<br>
                                <strong>Статус:</strong>
                                @if($car->status == 'available')
                                    <span class="badge badge-success">{{ $car->status}}</span>
                                @else($car->status == 'shipping')
                                    <span class="badge badge-warning">{{ $car->status}}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                @foreach($images as $image)
                                    <div class="col-sm-2">
                                        <a href="{{ asset('storage/' . $image->path) }}" data-toggle="lightbox" data-title="фотография {{$image->path}}" data-gallery="gallery">
                                            <img src="{{ asset('storage/'.$image->path) }}" class="img-fluid mb-2" alt="white sample">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <form action="{{route('sale_store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="user" value="{{auth()->user()->id}}">
                            <input type="hidden" name="car" value="{{$car->car_id}}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="client">Выберите клиента</label>
                                    <input class="form-control form-control-lg" list="Surname-listOptions" id="client"
                                           name="client" placeholder="Клиент">
                                    <datalist id="Surname-listOptions">
                                        @foreach($clients as $client)
                                            <option
                                                value="{{$client->client_id}}">{{$client->client_id . " " . $client->name . " " . $client->surname}}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="form-group">

                                </div>
                                <div class="form-group">
                                    <label for="email">Email <span class="text-body-secondary">(Не обязательно)</span></label>
                                    <input type="email" class="form-control form-control-lg" id="email" placeholder="you@example.com" autocomplete="email" style="user-select: none">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="country">Район</label>
                                            <select class="custom-select form-control-border" id="country" name="country" autocomplete="off" disabled>
                                                <option selected disabled>Район...</option>
                                                <option>Зеленоград</option>
                                                <option>Раменское</option>
                                                <option>Химки</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="adress">Адрес</label>
                                            <input type="text" class="form-control" id="adress" name="adress" placeholder="Введите адрес" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="help" name="help">
                                                <label class="custom-control-label" for="help">Помощь с регистрацией</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="truck" name="truck">
                                                <label class="custom-control-label" for="truck">Вызов эвакуатора</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="price">Цена</label>
                                    <input type="text" class="form-control form-control-lg" id="price" placeholder="Введите цену">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1">
                                        <label class="custom-control-label" for="exampleCheck1">Цена по каталогу</label>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label>Тип оплаты:</label>
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="custom-control custom-radio">
                                                <input id="part" name="paymentMethod" type="radio" value="1" class="custom-control-input" checked required>
                                                <label for="part" class="custom-control-label">Задаток</label>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="custom-control custom-radio">
                                                <input id="full1" name="paymentMethod" type="radio" value="2" class="custom-control-input" required>
                                                <label for="full1" class="custom-control-label">Полная оплата (нал)</label>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="custom-control custom-radio">
                                                <input id="full2" name="paymentMethod" type="radio" value="3" class="custom-control-input" required>
                                                <label for="full2" class="custom-control-label">Полная оплата (поручение)</label>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="custom-control custom-radio">
                                                <input id="credit" name="paymentMethod" type="radio" value="4" class="custom-control-input" required>
                                                <label for="credit" class="custom-control-label">Трехсторонняя сделка</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Корзина</h3>
                            <div class="card-tools">
                                <h4><span class="badge badge-primary" id="selectedCountBadge">1</span></h4>
                            </div><!-- /.card-tools -->
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <dl id="productList">
                                <div id="selected_car" class="product-item">
                                    <dt id="selected_car_brand">{{ $car->car_brand }} {{ $car->car_name }}</dt>
                                    <dd>
                                        <div class="row">
                                            <div class="col">
                                                <span id="selected_car_details">{{ $car->car_color . ' ' . $car->car_year . ' ' . $car->car_vin}}</span>
                                            </div>
                                            <div class="col text-right">
                                                <span class="price" id="selected_car_price">{{ $car->price}} ₽</span>
                                            </div>
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div><!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col">
                                    <label for="total_amount">Сумма</label>
                                </div>
                                <div class="col text-right">
                                    <strong id="total_amount">{{ $car->price}}₽</strong>
                                </div>
                            </div>
                        </div><!-- /.card-footer -->
                    </div><!-- /.card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Сотрудник</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <h5><strong>Сотрудник: </strong>{{ auth()->user()->name }}</h5>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                </div><!-- /.col-md-4 -->
            </div><!-- /.row -->
        </div>
    </section>
    @endsection
    @section('scripts')
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
        </script>
    @endsection
@endif
