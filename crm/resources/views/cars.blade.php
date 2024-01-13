@extends('layout')
@section('title')Машины@endsection
@section('main_content')
    <div class="container">
        <h1 class="my-3">Машины</h1>
        <div class="row justify-content-end">
            <div class="col">
                <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                   href="/cars?sold=false">
                    Показать в наличии
                </a>
                <a class="link-offset-2 mx-5 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                   href="/cars?sold=true">
                    Показать проданные
                </a>
                <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                   href="/cars">
                    Показать все
                </a>
            </div>
            <div class="col-auto">
                <a class="p-3 link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                   href="/add_car">
                    Добавить авто
                </a>
                <a class="link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                   href="{{route('edit_car')}}">
                    Изменить авто
                </a>
            </div>
        </div>
    </div>
    <div class="container rounded my-3 p-3 border">
        <h4 class="pb-3">Подобрать авто</h4>
        <form action="{{route('cars_index', 'available')}}" method="get">
            <div class="row">
                <div class="col">
                    <select class="form-select" id="car_make" name="car_make">
                        @if(request()->filled('car_make'))
                            @foreach($brands as $brand)
                                @if($brand->car_brand_id == request('car_make'))
                                    <option value='{{$brand->car_brand_id}}' disabled selected>{{$brand->car_brand}}</option>
                                    <option value='{{$brand->car_brand_id}}'>{{$brand->car_brand}}</option>
                                @else
                                    <option value='{{$brand->car_brand_id}}'>{{$brand->car_brand}}</option>
                                @endif
                            @endforeach
                        @else
                            <option value='' disabled selected>Марка</option>
                            @foreach($brands as $brand)
                                <option value='{{$brand->car_brand_id}}'>{{$brand->car_brand}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col">
                    <select class="form-select" id="car_model" aria-label="Модель" name="car_model" disabled>
                        <option value='' disabled selected>Модель</option>
                    </select>
                </div>
                <div class="col">
                    <select class="form-select" aria-label="Цвет" name="color">
                        @if(request()->filled('color'))
                            @foreach($colors as $color)
                                @if($color->car_color_id == request('color'))
                                    <option value='{{$color->car_color_id}}' disabled selected>{{$color->car_color}}</option>
                                    <option value='{{$color->car_color_id}}'>{{$color->car_color}}</option>
                                @else
                                    <option value='{{$color->car_color_id}}'>{{$color->car_color}}</option>
                                @endif
                            @endforeach
                        @else
                            <option value='' disabled selected>Цвет</option>
                            @foreach($colors as $color)
                                <option value='{{$color->car_color_id}}'>{{$color->car_color}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-4 rounded">
                    <div class="input-group">
                        <input type="text" class="form-control" id="minPrice" name="price_from"
                               placeholder='Цена от, ₽'>
                        <input type="text" class="form-control" id="maxPrice" name="price_to" placeholder='До'>
                    </div>
                </div>
                <div class="col-4 rounded">
                    <div class="input-group">
                        <input type="text" class="form-control" id="minYear" name="year_from" placeholder='Год от'>
                        <input type="text" class="form-control" id="maxYear" name="year_to" placeholder='До'>
                    </div>
                </div>
                <div class="col rounded">
                    <button type="submit" class="btn btn-primary align-self-end">Показать</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('table')
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Марка</th>
            <th scope="col">Модель</th>
            <th scope="col">Кузов</th>
            <th scope="col">Год</th>
            <th scope="col">Цвет</th>
            <th scope="col">VIN</th>
            <th scope="col">Цена</th>
            <th scope="col">Статус</th>
            <th scope="col">Купить</th>
        </tr>
        </thead>
        <tbody>
        @if($data->count() > 0)
            @foreach($data as $car)
                @if($car->status == 'sold')
                   @php
                       $active = "table-active";
                   @endphp
                @else
                    @php
                        $active = "";
                    @endphp
                @endif
                <tr class="{{$active}}">
                    <th>{{ $car->car_id }}</th>
                    <td>{{ $car->car_brand }}</td>
                    <td>{{ $car->car_name }}</td>
                    <td>{{ $car->car_type }}</td>
                    <td>{{ $car->car_year }}</td>
                    <td>{{ $car->car_color }}</td>
                    <td>{{ $car->car_vin}}</td>
                    <td>{{$car->formattedPrice}}</td>
                    <td>{{ $car->status}}</td>
                    <td>
                        @if($car->status !== 'sold' && $car->status !== 'booked')
                            <a href="{{ route('create_sale_id', ['car_id' => $car->car_id]) }}">оформить→</a>
                        @else
                            недоступно
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="9">No cars found.</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="container">
        {{$data->links()}}
    </div>
@endsection

