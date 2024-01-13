@extends('layout')
@section('title')Клиенты@endsection
@section('main_content')
    <div class="container">
        <h1 class="my-3">Клиенты</h1>
    </div>
@endsection
@section('table')
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Имя</th>
            <th scope="col">Фамилия</th>
            <th scope="col">Номер телефона</th>
            <th scope="col">Почта</th>
            <th scope="col">Адрес</th>
            <th scope="col">Пасспорт</th>
        </tr>
        </thead>
        <tbody>
        @if($clients->count() > 0)
            @foreach($clients as $client)
                <tr>
                    <th>{{ $client->client_id }}</th>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->surname }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->adress }}</td>
                    <td>{{ $client->passport}}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="9">No clients found.</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="container">
        {{$clients->links()}}
    </div>
@endsection


