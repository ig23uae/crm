<?php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Машины', route('cars_index', 'all'));
});

Breadcrumbs::for('add_car', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Добавить авто', route('add_car'));
});

Breadcrumbs::for('car', function (BreadcrumbTrail $trail, $car) {
    $trail->parent('home');
    $trail->push($car->car_brand . ' ' . $car->car_name, route('edit_car', $car->car_id));
});

