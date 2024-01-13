@extends('layouts.admin_layout')
@section('title', 'Изменить авто')
@section('main_content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Изменить авто: {{$car->car_brand . ' ' . $car->car_name}}</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        {{ Breadcrumbs::render('car', $car) }}
                    </div>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fas fa-check"></i>{{session('success')}}</h4>
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
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form action="{{route('update_car', $car->car_id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <select class="custom-select rounded-0" name="model" id="model" required>
                                    <option value="{{$car->car_model_id}}" selected>{{$car->car_brand . ' ' . $car->car_name}}</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="custom-select rounded-0" name="year" id="year" required>
                                    <option selected>Год</option>
                                    @php
                                        $startYear = $car->car_year - 25; // Начальный год (5 лет до значения)
                                        $endYear = $car->car_year + 5;   // Конечный год (5 лет после значения)
                                    @endphp

                                    @for($i = $startYear; $i <= $endYear; $i++)
                                        <option value="{{ $i }}" {{ $i == $car->car_year ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="custom-select rounded-0" name="color" id="color" required>
                                    <option value="{{$car->car_color_id}}" selected>{{$car->car_color}}</option>
                                    @foreach($colors as $color)
                                        <option value="{{$color->car_color_id}}">{{ $color->car_color }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="vin">Vin</label>
                            <input type="text" class="form-control form-control-lg" id="vin" name="vin"placeholder="Введите Vin" value="{{$car->car_vin}}">
                        </div>
                        <div class="form-group">
                            <label for="price">Цена</label>
                            <input type="text" class="form-control form-control-lg" id="price" placeholder="Введите цену" name="price" value="{{$car->price}}">
                        </div>
                        <div class="form-group">
                            <label>Выберите статус:</label>
                            <div class="row">
                                <div class="col-auto">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" name="status" id="status_shipping" value="shipping" {{ $car->status == 'shipping' ? 'checked' : '' }}>
                                        <label for="status_shipping" class="custom-control-label">В пути</label>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" name="status" id="status_available" value="available" {{ $car->status == 'available' ? 'checked' : '' }}>
                                        <label for="status_available" class="custom-control-label">В наличии</label>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" name="status" id="status_sold" value="sold" {{ $car->status == 'sold' ? 'checked' : '' }}>
                                        <label for="status_sold" class="custom-control-label">Продана</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group w-50">
                            <label for="InputFile">Документы:</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="InputFile" name="docs[]" multiple>
                                    <label class="custom-file-label" for="InputFile">Выберите файлы</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Загрузить</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group w-50">
                            <label for="InputImage">Фотографии:</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="InputImage" name="images[]" accept="image/*" multiple>
                                    <label class="custom-file-label" for="InputImage">Выберите фотографии</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Загрузить</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button id="submitButton" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                            Изменить
                        </button>
                    </div>
                    <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Вы уверены что хотите внести имения в {{$car->car_brand . ' ' . $car->car_name}}?</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h2 id="name"></h2>
                                    <p>
                                        <span id="inputYear"></span> => <span id="outputYear"></span><br>
                                        <span id="inputColor"></span> => <span id="outputColor"></span><br>
                                        <span id="inputVin"></span> => <span id="outputVin"></span><br>
                                        <span id="inputPrice"></span> => <span id="outputPrice"></span><br>
                                        <span id="inputStatus"></span> => <span id="outputStatus">[без изменений]</span><br>
                                    </p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                    <button type="submit" class="btn btn-primary">Изменить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        document.getElementById("submitButton").addEventListener("click", function () {
            // Получаем значения из полей формы
            var inputYear = document.getElementById("year").value;
            var inputColor = document.getElementById("color").value;
            var inputVin = document.getElementById("vin").value;
            var inputPrice = document.getElementById("price").value;

            console.log(inputYear);
            // Отображаем новые значения в модальном окне
            document.getElementById("name").textContent = "{{ $car->car_brand }} {{ $car->car_name }}";
            document.getElementById("inputYear").textContent = "{{ $car->car_year }}";
            document.getElementById("outputYear").textContent = inputYear;
            document.getElementById("inputColor").textContent = "{{ $car->car_color }}";
            document.getElementById("outputColor").textContent = document.getElementById("color").options[document.getElementById("color").selectedIndex].text;
            document.getElementById("inputVin").textContent = "{{ $car->car_vin }}";
            document.getElementById("outputVin").textContent = inputVin;
            document.getElementById("inputPrice").textContent = "{{ $car->price }}";
            document.getElementById("outputPrice").textContent = inputPrice;

            var currentStatus = document.querySelector("input[name='status']:checked").value;
            var initialStatus = "{{ $car->status }}";

            // Отображаем новый статус или информацию о его отсутствии изменений
            document.getElementById("inputStatus").textContent = initialStatus;
            if (currentStatus !== initialStatus) {
                document.getElementById("outputStatus").textContent = currentStatus;
            } else {
                document.getElementById("outputStatus").textContent = "[без изменений]";
            }

        });
    </script>

@endsection
