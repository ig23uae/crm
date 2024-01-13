@extends('layout')
@section('title')Машины@endsection
@section('main_content')
    <div class="container">
        <div>
            {{ Breadcrumbs::render('edit_sale', $sale->sale_id) }}
        </div>
        <h1 class="my-3">Изменить сделку</h1>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('edit_sale_handler')}}" method="post">
            @csrf
            <div class="input-group">
                <div class="mr-3 my-3">
                    <input type="hidden" name="sale_id" value="{{ $sale->sale_id }}">
                    <select class="form-select form-select-lg" name="car_id" id="car_id">
                        <option selected value="{{$sale->car_id}}" selected>{{$sale->car_brand . " " . $sale->car_name}}</option>
                    </select>
                </div>
                <div class="m-3">
                    <select class="form-select form-select-lg" name="year" id="year">
                        <option selected value="{{$sale->car_year}}">{{$sale->car_year}}</option>
                    </select>
                </div>
                <div class="my-3">
                    <select class="form-select form-select-lg" name="color" id="color">
                        <option disabled selected>{{$sale->car_color}}</option>
                    </select>
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="vin" placeholder="VIN" name="vin" value="{{$sale->car_vin}}" disabled>
                <label for="vin">VIN</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="price" placeholder="Цена" name="price" value="{{$sale->price}}" disabled>
                <label for="price">Цена</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="sold" value="sold" {{ $sale->status == 'sold' ? 'checked' : '' }}>
                <label class="form-check-label" for="sold">sold</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="booked" value="booked" {{ $sale->status == 'booked' ? 'checked' : '' }}>
                <label class="form-check-label" for="booked">booked</label>
            </div>
            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="submitButton">Сохранить изменения</button>
        </form>
@endsection

