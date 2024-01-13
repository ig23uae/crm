@extends('layouts.admin_layout')
@section('title', 'Список сделок')
@section('main_content')
    @php
        $month = request('month');
    @endphp
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-4">
                    @if($month == 1)
                        <h1 class="m-0">Совершенные сделки за последний месяц</h1>
                    @elseif($month == 3)
                        <h1 class="m-0">Совершенные сделки за последние 3 месяца</h1>
                    @else
                        <h1 class="m-0">Совершенные сделки</h1>
                    @endif
                </div>
                <div class="col-auto ml-auto">
                    <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="{{ route('sales', ['status' => request('month')]) }}">
                        Показать все
                    </a>
                    <a class="link-offset-2 mx-5 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="{{ route('sales', ['month' => 1, 'status' => request('month')]) }}">
                        Показать за последний месяц
                    </a>
                    <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="{{ route('sales', ['month' => 3, 'status' => request('month')]) }}">
                        Показать за последние 3 месяца
                    </a>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fas fa-check"></i>{{session('success')}}</h4>
                </div>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive p-0" >
            <table class="table table-hover table-head-fixed text-nowrap">
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
                                <td>
                                    @if($sale->sale_status == 'sold')
                                        <h5><span class="badge badge-secondary">{{ $sale->sale_status }}</span></h5>
                                    @elseif($sale->sale_status == 'booked')
                                        <h5><span class="badge badge-warning">{{ $sale->sale_status }}</span></h5>
                                    @endif
                                <td>
                                    <a class="btn btn-primary btn-sm" href="#">
                                        <i class="fas fa-folder">
                                        </i>
                                        View
                                    </a>
                                    @if($sale->sale_status !== 'sold')
                                        <a class="btn btn-info btn-sm" href="#">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </a>
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
        </div>
    </div>
@endsection
