@extends('layouts.admin_layout')
@section('title', 'Добавить авто')
@section('main_content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Добавить авто</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        {{ Breadcrumbs::render('add_car') }}
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
               <form action="{{route('cars_store')}}" method="POST" enctype="multipart/form-data">
                   @csrf
                   <div class="card-body">
                       <div class="row mb-2">
                           <div class="col-md-4">
                               <select class="custom-select rounded-0" name="model" id="model" required>
                                   <option disabled selected>Модель</option>
                                   @foreach($models as $model)
                                       <option value="{{$model->car_model_id}}">{{ $model->car_brand . ' ' . $model->car_name . ' - ' . $model->car_type }}
                                       </option>
                                   @endforeach
                               </select>
                           </div>
                           <div class="col-sm-2">
                               <select class="custom-select rounded-0" name="year" id="year" required>
                                   <option disabled selected>Год</option>
                                   @for($i = 1990; $i <= 2023; $i++)
                                       <option value="{{ $i }}">{{ $i }}</option>
                                   @endfor
                                   <option selected value="2024">2024</option>
                                   @for($i = 2025; $i <= 2030; $i++)
                                       <option value="{{ $i }}">{{ $i }}</option>
                                   @endfor
                               </select>
                           </div>
                           <div class="col-sm-2">
                               <select class="custom-select rounded-0" name="color" id="color" required>
                                   <option disabled selected>Цвет</option>
                                   @foreach($colors as $color)
                                       <option value="{{$color->car_color_id}}">{{ $color->car_color }}
                                       </option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                       <div class="form-group">
                           <label for="vin">Vin</label>
                           <input type="text" class="form-control form-control-lg" id="vin" name="vin"placeholder="Введите Vin">
                       </div>
                       <div class="form-group">
                           <label for="price">Цена</label>
                           <input type="text" class="form-control form-control-lg" id="price" placeholder="Введите цену" name="price">
                       </div>
                       <div class="form-group">
                           <label>Выберите статус:</label>
                           <div class="row">
                               <div class="col-auto">
                                   <div class="custom-control custom-radio">
                                       <input class="custom-control-input" type="radio"  name="status" id="status_shipping" value="shipping" checked>
                                       <label for="status_shipping" class="custom-control-label">В пути</label>
                                   </div>
                               </div>
                               <div class="col-auto">
                                   <div class="custom-control custom-radio">
                                       <input class="custom-control-input" type="radio" name="status" id="status_available" value="available">
                                       <label for="status_available" class="custom-control-label">В наличии</label>
                                   </div>
                               </div>
                               <div class="col-auto">
                                   <div class="custom-control custom-radio">
                                       <input class="custom-control-input" type="radio" name="status" id="status_sold" value="sold">
                                       <label for="status_sold" class="custom-control-label">Продана</label>
                                   </div>
                               </div>
                           </div><!--/.row -->
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
                   </div><!--/.card-body -->
                   <div class="card-footer">
                       <button type="submit" class="btn btn-primary">Добавить</button>
                   </div><!--/.card-footer -->
               </form><!--/footer -->
           </div><!--/.card -->
       </div><!--/.container-fluid -->
   </section><!--/.content -->
@endsection
