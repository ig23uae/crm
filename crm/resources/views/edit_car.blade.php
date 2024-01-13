@extends('layout')
@section('title')Изменить авто@endsection
@section('main_content')
    <div class="container">
        <div>
            {{ Breadcrumbs::render('edit_car') }}
        </div>
        <h1 class="my-3">Изменить авто</h1>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('edit_car_handler')}}" method="get">
            @csrf
            <div class="input-group">
                <div class="mr-3 my-3">
                    <input type="hidden" name="model" id="model">
                    <select class="form-select form-select-lg" name="car_id" id="car_id">
                        <option disabled selected>Модель</option>
                        @foreach($models as $model)
                            <option value="{{$model->car_id}}">{{$model->car_id . ' ' . $model->car_brand . ' ' . $model->car_name . ' - ' . $model->car_vin }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="m-3">
                    <select class="form-select form-select-lg" name="year" id="year">
                        <option disabled selected>Год</option>
                        @for($i = 1990; $i <= 2022; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                        <option selected value="2023">2023</option>
                        @for($i = 2024; $i <= 2030; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="my-3">
                    <select class="form-select form-select-lg" name="color" id="color">
                        <option disabled selected>Цвет</option>
                        @foreach($colors as $color)
                            <option value="{{$color->car_color_id}}" id="{{ $color->car_color }}">{{ $color->car_color }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="vin" placeholder="VIN" name="vin">
                <label for="vin">VIN</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="price" placeholder="Цена" name="price">
                <label for="price">Цена</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="shipping" value="shipping" checked>
                <label class="form-check-label" for="shipping">shipping</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="available" value="available">
                <label class="form-check-label" for="available">available</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="sold" value="sold">
                <label class="form-check-label" for="sold">sold</label>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="submitButton">Сохранить изменения</button>
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Сохранить изменения</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Вы уверены что хотите изменить значения?</p>
                            <h2 id="name"></h2>
                            <span id="inputYear"> </span> => <span id="outputYear"> </span><br>
                            <span id="inputColor"> </span> => <span id="outputColor"> </span><br>
                            <span id="inputVin"> </span> => <span id="outputVin"> </span><br>
                            <span id="inputPrice"> </span> => <span id="outputPrice"> </span><br>
                            <span id="inputStatus"> </span> => <span id="outputStatus"> [без изменений]</span><br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
                            <button type="submit" class="btn btn-primary" id="saveChanges">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script>
            // Объявляем initialStatus на уровне выше
            var initialStatus;

            // Обработчик события изменения выбранной опции в списке
            $("#car_id").change(function () {
                var selectedCarId = $(this).val();

                // Отправка Ajax-запроса для получения данных машины
                $.ajax({
                    url: "/get-car",
                    method: "GET",
                    data: { car_id: selectedCarId },
                    dataType: "json",
                    success: function (response) {
                        if (response.length > 0) {
                            const carData = response[0];

                            // Обновление значений полей ввода формы
                            $("#year").val(carData.car_year);

                            // Выбор опции с соответствующим текстовым значением
                            $("#color option:contains('" + carData.car_color + "')").prop('selected', true);

                            $("#vin").val(carData.car_vin);
                            $("#price").val(carData.price);
                            $("input[name='status']").filter("[value='" + carData.status + "']").prop("checked", true);

                            // Вставка значений response в теги p модального окна
                            $("#name").text(carData.car_brand + ' ' + carData.car_name);
                            $("#inputYear").text(carData.car_year);
                            $("#inputColor").text(carData.car_color);
                            $("#inputVin").text(carData.car_vin);
                            $("#inputPrice").text(carData.price);
                            $("#inputStatus").text(carData.status);

                            // Сохраняем начальный статус
                            initialStatus = carData.status;
                            $("#model").val(carData.car_model_id);
                        }
                    },
                    error: function (error) {
                        console.log("Error fetching car details: ", error);
                    }
                });
            });

            // Обработчик события нажатия на кнопку "Сохранить изменения"
            $("#submitButton").click(function () {
                // Получаем значения из полей формы
                var inputYear = $("#year").val();
                var inputColor = $("#color").val();
                var inputVin = $("#vin").val();
                var inputPrice = $("#price").val();

                $("#outputYear").text(inputYear);
                $("#outputColor").text($("#color option:selected").text());
                $("#outputVin").text(inputVin);
                $("#outputPrice").text(inputPrice);


                var currentStatus = $("input[name='status']:checked").val();

                if (currentStatus !== initialStatus) {
                    $("#outputStatus").text(currentStatus);
                } else {
                    $("#outputStatus").text("[без изменений]");
                }
            });
        </script>
@endsection
