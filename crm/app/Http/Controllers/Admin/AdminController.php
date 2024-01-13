<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Color;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use NumberFormatter;
use function PHPUnit\Framework\isNull;

class AdminController extends Controller
{
    public function index()
    {
        $cars = Car::join('models', 'models.car_model_id', '=', 'cars.car_model_id')
            ->join('colors', 'colors.car_color_id', '=', 'cars.car_color_id')
            ->join('brands', 'brands.car_brand_id', '=', 'models.car_brand_id')
            ->join('types', 'types.car_type_id', '=', 'models.car_type_id')
            ->where('status', '=', 'available')->paginate(20);
        foreach ($cars as $car) {
            // Предполагается, что у вас есть поле 'price' в модели 'Car'
            $formatter = new NumberFormatter('ru', NumberFormatter::CURRENCY);
            $formattedPrice = $formatter->formatCurrency($car->price, 'RUB');

            // Добавление отформатированной цены в объект машины
            $car->formattedPrice = $formattedPrice;
        }
        $users = User::all()->count();
        $sales_count = Sales::all()->where('sale_status', '=', 'sold')->count();
        $cars_count = Car::all()->where('status', '=', 'available')->count();
        $visitors = random_int(100,1000);
        return view('admin_panel.index',[
            'cars_count' => $cars_count,
            'sales_count' => $sales_count,
            'cars' => $cars,
            'users' => $users,
            'visitors' => $visitors,
        ]);
    }
}
