@extends('layout')
@section('title')Добавить Клиента@endsection
@section('main_content')
    <div class="container">
        <h1 class="mx-3">Зарегестрировать клиента</h1>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="rounded my-3 p-3" style="background-color: #f5f5f5;">
            <form action="{{route('client_handler')}}" method="post">
                @csrf
                <div class="input-group input-group-lg mb-3">
                    <label for="name" class="input-group-text">Имя Клиента</label>
                    <input class="form-control form-control-lg" list="Name-listOptions" id="name" name="name" placeholder="Имя">
                    <datalist id="Name-listOptions">
                        @foreach($clients as $client)
                            <option value="{{$client->name}}">
                        @endforeach
                    </datalist>
                </div>
                <div class="input-group input-group-lg mb-3">
                    <label for="surname" class="input-group-text">Фамилия Клиента</label>
                    <input class="form-control form-control-lg" list="Surname-listOptions" id="surname" name="surname" placeholder="Фамилия">
                    <datalist id="Surname-listOptions">
                        @foreach($clients as $client)
                            <option value="{{$client->surname}}">
                        @endforeach
                    </datalist>
                </div>
                <div class="input-group input-group-lg mb-3">
                    <label for="exampleInputEmail1" class="input-group-text">Телефон</label>
                    <input type="phone" class="form-control form-control-lg" id="phone" name="phone" placeholder="8-(999)-999-99-99">
                </div>
                <div class="input-group input-group-lg mb-3">
                    <label for="email" class="input-group-text">Почта</label>
                    <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="example@email.com">
                </div>
                <div class="input-group input-group-lg mb-3">
                    <label for="adress" class="input-group-text">Адресс</label>
                    <input type="text" class="form-control form-control-lg" id="adress" name="adress" placeholder="Адресс" >
                </div>
                <div class="input-group input-group-lg mb-3">
                    <label for="passport" class="input-group-text">Паспорт</label>
                    <input type="text" class="form-control form-control-lg" id="passport" name="passport" placeholder="1234 567890">
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Отправить</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const phoneInput = document.getElementById('phone');

            phoneInput.addEventListener('input', function (e) {
                let x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
                e.target.value = !x[2] ? x[1] : '8-(' + x[2] + (x[3] ? ')-' + x[3] : '') + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
            });
        });

    </script>
@endsection
