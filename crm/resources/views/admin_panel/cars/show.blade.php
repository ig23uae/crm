@extends('layouts.admin_layout')
@section('title', 'Посмотреть авто')
@section('main_content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Запись {{$car->car_brand . ' ' . $car->car_name}}</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        {{ Breadcrumbs::render('car', $car) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">{{ $car->car_brand }} {{ $car->car_name }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4><strong>Название:</strong> {{ $car->car_brand }} {{ $car->car_name }}</h4>
                            <h4><strong>Vin:</strong> {{ $car->car_vin }}</h4>
                            <h4><strong>Год:</strong> {{ $car->car_year }}</h4>
                            <h4><strong>Цвет:</strong> {{ $car->car_color }}</h4>
                            <h4><strong>Цена:</strong> {{ $car->price }} ₽</h4>
                            <hr>
                            @if($car->status == 'available')
                                <h4><strong>Статус: </strong><span class="badge badge-success">{{ $car->status}}</span></h4>
                            @elseif($car->status == 'booked' or $car->status == 'shipping')
                                <h4><strong>Статус: </strong><span class="badge badge-warning">{{ $car->status}}</span></h4>
                            @else
                                <h4><strong>Статус: </strong><span class="badge badge-secondary">{{ $car->status}}</span></h4>
                            @endif
                            <hr>
                            <a class="btn btn-info btn-sm" href="{{route('edit_car', $car->car_id)}}">
                                <i class="fas fa-pencil-alt"></i>
                                Изменить запись
                            </a>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $car->car_id }})">
                                <i class="fas fa-trash"></i>
                                Удалить машину
                            </button>
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
                            <!-- Другие данные о машине -->
                        </div>
                        <div class="col-md-6">
                            <h5>Фотографии:</h5>
                            <div class="row">
                                @foreach($images as $image)
                                    <div class="col-sm-4">
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
                <div class="col-md-6">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Фотографии:</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Имя файла</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($images as $image)
                                    <tr>
                                        <td>
                                            <a href="{{ asset('storage/'.$image->path) }}" class="btn-link text-secondary" download>
                                                <i class="far fa-fw fa-image"></i>
                                                {{ $image->path }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{route('delete_image', $image->image_id)}}" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                    Удалить
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Документы:</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Имя файла</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($docs as $doc)
                                    <tr>
                                        <td>
                                            <a href="{{ asset('storage/'.$doc->path) }}" class="btn-link text-secondary" download>
                                                <i class="far fa-fw fa-image"></i>
                                                {{ $doc->path }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{route('delete_doc', $doc->doc_id)}}" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                    Удалить
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
