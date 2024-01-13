@extends('layouts.admin_layout')
@section('title', 'Главная')
@section('main_content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Главная</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <!-- /.breadcrumb -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$cars_count}}</h3>
                            <p>Авто в наличии</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('cars_index', $status='available')}}" class="small-box-footer">Посмотреть <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{$sales_count}}</h3>
                            <p>Количество сделок</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <!--<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{$users}}</h3>
                            <p>Пользователя</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <!--<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{$visitors}}</h3>
                            <p>Уникальных пользователей</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <!--<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
                    </div>
                </div>
                <!-- ./col -->
            </div><!-- /.row -->
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Машины в наличии:</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0" >
                            <table class="table table-hover table-head-fixed text-nowrap">
                                <thead>
                                <tr>
                                    <th scope="col">Авто</th>
                                    <th scope="col">Год</th>
                                    <th scope="col">Цвет</th>
                                    <th scope="col">VIN</th>
                                    <th scope="col">Цена</th>
                                    <th scope="col">Статус</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($cars->count() > 0)
                                    @foreach($cars as $car)
                                        <tr class="active">
                                            <td>{{ $car->car_brand . ' ' . $car->car_name}}</td>
                                            <td>{{ $car->car_year }}</td>
                                            <td>{{ $car->car_color }}</td>
                                            <td>{{ $car->car_vin }}</td>
                                            <td>{{ $car->formattedPrice}}</td>
                                            <td><h5><span class="badge badge-success">{{ $car->status}}</span></h5></td>
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
                                {{$cars->links()}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Сделки в процессе:</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0" >
                            <table class="table table-hover table-head-fixed text-nowrap">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Модель</th>
                                    <th scope="col">VIN</th>
                                    <th scope="col">Цена</th>
                                    <th scope="col">Статус</th>
                                    <th scope="col">Продавец</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr class="active">
                                        <td>1</td>
                                        <td>Pajero</td>
                                        <td>vin</td>
                                        <td>5500000</td>
                                        <td><h5><span class="badge badge-warning">booked</span></h5></td>
                                        <td>Админ</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="container">
                                {{$cars->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
