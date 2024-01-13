@extends('layouts.admin_layout')
@section('title', 'Список Авто')
@section('main_content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 justify-content-end">
                <div class="col-4">
                    <h1 class="m-0">Список авто</h1>
                </div>
                <div class="col-auto ml-auto">
                    <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                       href="{{route('cars_index', 'available')}}">
                        Показать в наличии
                    </a>
                    <a class="link-offset-2 mx-5 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                       href="{{route('cars_index', 'sold')}}">
                        Показать проданные
                    </a>
                    <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                       href="{{route('cars_index', 'all')}}">
                        Показать все
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
        <div class=" rounded m-2 p-3 border">
            <h4 class="pb-3">Фильтры</h4>
            <form action="{{route('cars_index', 'available')}}" method="get">
                @csrf
                <div class="row">
                    <div class="col">
                        <select class="custom-select form-control-border" id="car_make" name="car_make">
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
                        <select class="custom-select form-control-border" id="car_model" aria-label="Модель" name="car_model">
                            <option value='' disabled selected>Модель</option>
                        </select>
                    </div>
                    <div class="col">
                        <select class="custom-select form-control-border" id="color" name="color">
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
                        <button type="submit" class="btn btn-primary float-right">Показать</button>
                    </div>
                </div>
            </form>
        </div>
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
                    <th scope="col"></th>
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
                            <td>{{ $car->car_vin }}</td>
                            <td>{{ $car->formattedPrice}}</td>
                            <td>
                                @if($car->status == 'available')
                                    <h5><span class="badge badge-success">{{ $car->status}}</span></h5>
                                @elseif($car->status == 'booked' or $car->status == 'shipping')
                                    <h5><span class="badge badge-warning">{{ $car->status}}</span></h5>
                                @else
                                    <h5><span class="badge badge-secondary">{{ $car->status}}</span></h5>
                                @endif
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{route('car', $car->car_id)}}">
                                    <i class="fas fa-folder">
                                    </i>
                                    View
                                </a>
                                <a class="btn btn-info btn-sm" href="{{route('edit_car', $car->car_id)}}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </a>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $car->car_id }})">
                                    <i class="fas fa-trash">
                                    </i>
                                    Delete
                                </button>
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
            <script>
                function confirmDelete(carId) {
                    // Устанавливаем значение скрытого поля формы
                    $('#carIdInput').val(carId);

                    // Получаем URL для формы с добавлением значения car_id
                    var formAction = '{{ route("delete_car", ["car_id" => ":carId"]) }}';
                    formAction = formAction.replace(':carId', carId);

                    // Устанавливаем новый action формы
                    $('#confirmDeleteForm').attr('action', formAction);

                    // Отображаем модальное окно
                    $('#confirmationModal').modal('show');

                    // Обработчик формы при подтверждении удаления
                    $('#confirmDeleteForm').submit(function(event) {
                        // Отменяем обычное поведение формы
                        event.preventDefault();

                        // Отправляем форму
                        this.submit();
                    });
                }
            </script>
            <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Подтверждение удаления</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Вы уверены, что хотите удалить эту машину?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                            <form id="confirmDeleteForm" action="" method="POST">
                                @csrf
                                @method('delete')

                                <!-- Скрытое поле для передачи car_id -->
                                <input type="hidden" id="carIdInput" name="car_id">

                                <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">Удалить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            {{$data->links()}}
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('../js/getCarModels.js')}}"></script>
@endsection
