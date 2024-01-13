@extends('layout')
@section('title')Сделки@endsection
@section('main_content')
    @php
        $month = request('month');
    @endphp
    <div class="container">
        @if($month == 1)
            <h1 class="my-3">Совершенные сделки за последний месяц</h1>
        @elseif($month == 3)
            <h1 class="my-3">Совершенные сделки за последние 3 месяца</h1>
        @else
            <h1 class="my-3">Совершенные сделки</h1>
        @endif
        <div class="row justify-content-end">
            <div class="col">
                <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                   href="/sales">
                    Показать все
                </a>
                <a class="link-offset-2 mx-5 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                   href="/sales?month=1">
                    Показать за последний месяц
                </a>
                <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                   href="/sales?month=3">
                    Показать за последние 3 месяца
                </a>
            </div>
        </div>
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
            <th scope="col">Изменить</th>
        </tr>
        </thead>
        <tbody>
        @if($sales->count() > 0)
            @foreach($sales as $sale)
                @php
                    $active = ($sale->status == 'sold') ? 'table-active' : '';
                @endphp
                <tr class="{{ $active }}">
                    <th>{{ $sale->car_id }}</th>
                    <td>{{ $sale->car_brand }}</td>
                    <td>{{ $sale->car_name }}</td>
                    <td>{{ $sale->car_type }}</td>
                    <td>{{ $sale->car_year }}</td>
                    <td>{{ $sale->car_color }}</td>
                    <td>{{ $sale->car_vin }}</td>
                    <td>{{ $sale->formattedPrice }}</td>
                    <td>{{ $sale->sale_status }}</td>
                    <td>
                        @if($sale->status !== 'sold')
                            <a href="{{ route('edit_sale', ['sale_id' => $sale->sale_id]) }}">Изменить→</a>
                        @else
                            недоступно
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="9">No sales found.</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="container">
        {{$sales->links()}}
    </div>
@endsection
