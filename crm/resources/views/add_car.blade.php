@extends('layout')
@section('title')Добавить авто@endsection
@section('main_content')
    <div class="container">
        <div>
            {{ Breadcrumbs::render('add_car') }}
        </div>
        <h1 class="my-3">Добавить авто</h1>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('add_handler') }}" method="post">
            @csrf
            <div class="input-group">
                <div class="mr-3 my-3">
                    <select class="form-select form-select-lg" name="model" id="model">
                        <option disabled selected>Модель</option>
                        @foreach($models as $model)
                            <option value="{{$model->car_model_id}}">{{ $model->car_brand . ' ' . $model->car_name . ' - ' . $model->car_type }}
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
                            <option value="{{$color->car_color_id}}">{{ $color->car_color }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="vin" placeholder="VIN" name="vin" >
                <label for="vin">VIN</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="price" placeholder="Цена" name="price">
                <label for="price">Цена</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status"
                       value="shipping" checked>
                <label class="form-check-label" for="status">shipping</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status"
                       value="available">
                <label class="form-check-label" for="status">available</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status"
                       value="sold">
                <label class="form-check-label" for="status">sold</label>
            </div>
            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>
    </div>
@endsection
