<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSalesRequest;
use App\Http\Requests\UpdateSalesRequest;
use App\Models\Car;
use App\Models\Client;
use App\Models\Images;
use App\Models\Sales;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use NumberFormatter;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sales = Sales::join('cars', 'sales.car_id', '=', 'cars.car_id')
            ->join('models', 'models.car_model_id', '=', 'cars.car_model_id')
            ->join('colors', 'colors.car_color_id', '=', 'cars.car_color_id')
            ->join('brands', 'brands.car_brand_id', '=', 'models.car_brand_id')
            ->join('types', 'models.car_type_id', '=', 'types.car_type_id')
            ->join('users', 'sales.employee_id', '=', 'users.id')
            ->select('cars.*', 'models.*', 'colors.*', 'brands.*', 'types.*', 'sales.*', 'users.*');

        $month = $request->input('month');
        // Определение даты, которая находится на границе текущего месяца
        $startDate = now()->startOfMonth();
        if ($month == '1') {
            // Выбор сделок, созданных после начала текущего месяца
            $sales->whereDate('sales.created_at', '>=', $startDate);
        }elseif ($month == '3') {
            // Если выбрано 3 месяца, уточнить, что сделка была создана более 2 месяцев назад
            $sales->whereDate('sales.created_at', '>', $startDate->subMonths(2));
        }

        $status = $request->input('status');
        if ($status == 'booked') {
            // Выбор сделок, созданных после начала текущего месяца
            $sales->where('sales.sale_status', '=', $status);
        }elseif ($status == 'sold') {
            // Если выбрано 3 месяца, уточнить, что сделка была создана более 2 месяцев назад
            $sales->where('sales.sale_status', '=', $status);
        }

        $sales = $sales->paginate(20);

        //Форматирование цены
        foreach ($sales as $car) {
            // Предполагается, что у вас есть поле 'price' в модели 'Car'
            $formatter = new NumberFormatter('ru', NumberFormatter::CURRENCY);
            $formattedPrice = $formatter->formatCurrency($car->price, 'RUB');

            // Добавление отформатированной цены в объект машины
            $car->formattedPrice = $formattedPrice;
        }

        return view('admin_panel.sales.sales', [
            'sales' => $sales,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $car_id = $request->input('car_id');

        if (!is_null($car_id)) {
            // Получаем car_id и ищем запись
            $car = Car::join('models', 'models.car_model_id', '=', 'cars.car_model_id')
                ->join('colors', 'colors.car_color_id', '=', 'cars.car_color_id')
                ->join('brands', 'brands.car_brand_id', '=', 'models.car_brand_id')
                ->select('cars.*', 'models.*', 'colors.*', 'brands.*')
                ->where('cars.car_id', $car_id)
                ->where('status', '!=', 'sold')
                ->where('status', '!=', 'booked')
                ->first();

            if (!is_null($car)) {
                $clients = Client::all();
                $images = Images::all();
                return view('admin_panel.sales.create', [
                    'clients' => $clients,
                    'car' => $car,
                    'images' => $images,
                ]);
            } else {
                abort(404);
            }
        } else {
            // car_id не указан, ищем все записи
            $cars = Car::join('models', 'models.car_model_id', '=', 'cars.car_model_id')
                ->join('colors', 'colors.car_color_id', '=', 'cars.car_color_id')
                ->join('brands', 'brands.car_brand_id', '=', 'models.car_brand_id')
                ->select('cars.*', 'models.*', 'colors.*', 'brands.*')
                ->where('status', '!=', 'sold')
                ->where('status', '!=', 'booked')
                ->get();

            if (!$cars->isEmpty()) {
                $clients = Client::all();

                return view('admin_panel.sales.create', [
                    'clients' => $clients,
                    'cars' => $cars,
                ]);
            } else {
                abort(404);
            }
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalesRequest $request)
    {
        dd($request);
        $sale = new Sales();
        //проверка является ли пользователь указанный в сделке текущим пользователем
        $authenticatedUserId = auth()->user()->id;
        $inputUserId = $request->input('user');

        if ($authenticatedUserId != $inputUserId) {
            return redirect()->back()->with('error', 'Фатальная ошибка');
        }

        $sale->client_id = $request->input('client');
        $sale->car_id = $request->input('car');
        $sale->email = $request->input('email');

        //Вставка статуса продажи по типу оплаты
        $paymentMethod = $request->input('paymentMethod');
        $priceBD = $request->has('PriceBd');
        $sale->paymentMethod = $paymentMethod;
        $price = Car::where('car_id', $request->input('car'))->first(['price']);

        if ($priceBD) {
            $basePrice = $price->price;
        } elseif ($price) {
            $basePrice = $request->input('price');
        }else{
            return redirect()->back()->with('error', 'Фатальная ошибка');
        }

        $sale->price = $request->has('PriceBd') ? $basePrice : $request->input('price');

        if ($request->has('help')) {
            $sale->price += 5000;
        }

        if ($request->has('truck')) {
            $sale->price += 5000;
            $sale->country = $request->input('country');
            $sale->address = $request->input('adress');
        }
        $sale->help = $request->has('help');
        $sale->truck = $request->has('truck');
        $sale->sale_status = $request->input('paymentMethod') === '1' ? 'booked' : 'sold';
        $sale->employee_id = $request->input('user');
        $sale->save();
        Car::where('car_id', $request->input('car'))->update(['status' => $sale->sale_status]);
        return redirect()->back()->withSuccess('Запись успешно добавлена');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sales $sales)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesRequest $request, Sales $sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sales $sales)
    {
        //
    }
}
