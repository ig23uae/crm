<?php
namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\Client;
use App\Models\Color;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AddCarRequest;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Number;
use Illuminate\View\View;
use NumberFormatter;

class CarController1 extends Controller{

    public function getCarModels(Request $request)
    {
        $carMake = $request->input('car_make');

        $models = CarModel::where('car_brand_id', $carMake)->get(['car_model_id', 'car_name']);

        return response()->json($models);

    }

    public function cars(Request $request): View
    {
        $soldStatus = $request->input('sold');

        // Формирование запроса к базе данных
        $query = Car::join('models', 'models.car_model_id', '=', 'cars.car_model_id')
            ->join('colors', 'colors.car_color_id', '=', 'cars.car_color_id')
            ->join('brands', 'brands.car_brand_id', '=', 'models.car_brand_id')
            ->join('types', 'types.car_type_id', '=', 'models.car_type_id')
            ->select('cars.*', 'models.*', 'colors.*', 'brands.*', 'types.*');

        // Добавление условия, основанного на значении параметра 'sold'
        if ($soldStatus === 'true') {
            $query->where('cars.status', 'sold');
        } elseif ($soldStatus === 'false') {
            $query->whereNot('cars.status', 'sold');
        }
        $colors = Color::all();
        $brands = Brand::all();

        // Выполнение запроса с пагинацией
        $data = $query->paginate(20);

        //Форматирование цены
        foreach ($data as $car) {
            // Предполагается, что у вас есть поле 'price' в модели 'Car'
            $formatter = new NumberFormatter('ru', NumberFormatter::CURRENCY);
            $formattedPrice = $formatter->formatCurrency($car->price, 'RUB');

            // Добавление отформатированной цены в объект машины
            $car->formattedPrice = $formattedPrice;
        }
        // Возвращение данных в представление
        return view('cars', [
            'data' => $data,
            'brands' => $brands,
            'colors' => $colors
        ]);


    }

    public function cars_filter(Request $request): View{

        // Формирование запроса к базе данных
        $query = Car::join('models', 'models.car_model_id', '=', 'cars.car_model_id')
            ->join('colors', 'colors.car_color_id', '=', 'cars.car_color_id')
            ->join('brands', 'brands.car_brand_id', '=', 'models.car_brand_id')
            ->join('types', 'types.car_type_id', '=', 'models.car_type_id')
            ->select('cars.*', 'models.*', 'colors.*', 'brands.*', 'types.*')
            ->where('status', '!=', 'sold');

        // Добавление фильтров, если они указаны
        $carMake = $request->input('car_make');
        if ($carMake) {
            $query->where('brands.car_brand_id', '=', $carMake);
        }

        $carModel = $request->input('car_model');
        if ($carModel) {
            $query->where('models.car_model_id', '=', $carModel);
        }

        $carColor = $request->input('color');
        if ($carColor) {
            $query->where('colors.car_color_id', '=', $carColor);
        }

        $priceFrom = $request->input('price_from');
        if ($priceFrom) {
            $query->where('cars.price', '>=', $priceFrom);
        }

        $priceTo = $request->input('price_to');
        if ($priceTo) {
            $query->where('cars.price', '<=', $priceTo);
        }

        $yearFrom = $request->input('year_from');
        if ($yearFrom) {
            $query->where('cars.car_year', '>=', $yearFrom);
        }

        $yearTo = $request->input('year_to');
        if ($yearTo) {
            $query->where('cars.car_year', '<=', $yearTo);
        }

        //Получение таблиц для отображения фильтров
        $colors = Color::all();
        $brands = Brand::all();

        // Выполнение запроса с пагинацией
        $data = $query->paginate(20);

        //Форматирование цены
        foreach ($data as $car) {
            // Предполагается, что у вас есть поле 'price' в модели 'Car'
            $formatter = new NumberFormatter('ru', NumberFormatter::CURRENCY);
            $formattedPrice = $formatter->formatCurrency($car->price, 'RUB');

            // Добавление отформатированной цены в объект машины
            $car->formattedPrice = $formattedPrice;
        }

        return view('cars', [
            'data' => $data,
            'brands' => $brands,
            'colors' => $colors
        ]);
    }

    public function add_car():View{
        $models = CarModel::join('brands','brands.car_brand_id', '=', 'models.car_brand_id')
        ->join('types','types.car_type_id', '=', 'models.car_type_id')
            ->select('models.*', 'brands.*', 'types.*')
            ->get();

        $colors = Color::all();

        return view('add_car',[
            'models' => $models,
            'colors' => $colors
        ]);
    }

    public function edit_car():View{
        $models = Car::join('models','models.car_model_id', '=', 'cars.car_model_id')
            ->join('brands','brands.car_brand_id', '=', 'models.car_brand_id')
            ->join('types','types.car_type_id', '=', 'models.car_type_id')
            ->select('cars.*','models.*', 'brands.*', 'types.*')
            ->get();

        $colors = Color::all();

        return view('edit_car',[
            'models' => $models,
            'colors' => $colors
        ]);
    }

    public function getCar(Request $request)
    {
        $car = $request->input('car_id');
        $models = Car::join('models','models.car_model_id', '=', 'cars.car_model_id')
            ->join('brands','brands.car_brand_id', '=', 'models.car_brand_id')
            ->join('types','types.car_type_id', '=', 'models.car_type_id')
            ->join('colors','cars.car_color_id', '=', 'colors.car_color_id')
            ->select('cars.*','models.*', 'brands.*', 'types.*', 'colors.*')
            ->where('car_id', $car)
            ->get();

        return response()->json($models);

    }

    public function edit_car_handler(Request $request)
    {
        // Находим машину по car_id
        $car = Car::find($request->input('car_id'));

        // Проверяем, найдена ли машина
        if ($car) {
            // Обновляем поля машины
            $car->car_model_id = $request->input('model');
            $car->car_year = $request->input('year');
            $car->car_color_id = $request->input('color');
            $car->car_vin = $request->input('vin');
            $car->price = $request->input('price');
            $car->status = $request->input('status');

            // Сохраняем изменения
            $car->save();

            return redirect()->route('cars');
        } else {
            // Если машина не найдена, выполните необходимые действия
            return redirect()->route('cars')->with('error', 'Машина не найдена');
        }
    }

    public function clients(): View
    {
        $clients = Client::paginate(20);

        return view('clients', [
            'clients' => $clients,
        ]);
    }

    public function create_client(): View
    {
        $clients = Client::all();
        return view('create_user',[
            'clients' => $clients,
        ]);
    }

    public function client_handler(ClientRequest $request)
    {
        $client = new Client();
        $client->name = $request->input('name');
        $client->surname = $request->input('surname');
        $client->phone = $request->input('phone');
        $client->email = $request->input('email');
        $client->adress = $request->input('adress');
        $client->passport = $request->input('passport');
        $client->timestamps;
        $client->save();
        return redirect()->route('clients');
    }

    public function sales(): View
    {
        $sales = Sales::join('cars', 'sales.car_id', '=', 'cars.car_id')
            ->join('models', 'models.car_model_id', '=', 'cars.car_model_id')
            ->join('colors', 'colors.car_color_id', '=', 'cars.car_color_id')
            ->join('brands', 'brands.car_brand_id', '=', 'models.car_brand_id')
            ->join('types', 'models.car_type_id', '=', 'types.car_type_id')
            ->select('cars.*', 'models.*', 'colors.*', 'brands.*', 'types.*', 'sales.*')
            ->paginate(20);

        //Форматирование цены
        foreach ($sales as $car) {
            // Предполагается, что у вас есть поле 'price' в модели 'Car'
            $formatter = new NumberFormatter('ru', NumberFormatter::CURRENCY);
            $formattedPrice = $formatter->formatCurrency($car->price, 'RUB');

            // Добавление отформатированной цены в объект машины
            $car->formattedPrice = $formattedPrice;
        }

        return view('sales', [
            'sales' => $sales,
        ]);
    }

    public function create_sale($car_id = null): View
    {
        try {
            $cars = Car::join('models', 'models.car_model_id', '=', 'cars.car_model_id')
                ->join('colors', 'colors.car_color_id', '=', 'cars.car_color_id')
                ->join('brands', 'brands.car_brand_id', '=', 'models.car_brand_id')
                ->select('cars.*', 'models.*', 'colors.*', 'brands.*')
                ->where(function ($query) use ($car_id) {
                    if (!is_null($car_id)) {
                        $query->where('cars.car_id', $car_id);
                    }
                    $query->where('status', '!=', 'sold')
                        ->where('status', '!=', 'booked');
                })
                ->get();

            // Проверка, что коллекция не пуста
            if ($cars->isNotEmpty()) {
                $clients = Client::all();

                return view('create_sale', [
                    'clients' => $clients,
                    'cars' => $cars,
                ]);
            } else {
                abort(404);
            }
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function sale_handler(Request $request)
    {
        $sale = new Sales();
        $sale->client_id = $request->input('client');
        $sale->car_id = $request->input('car');
        $sale->email = $request->input('email');
        $price = Car::where('car_id', $request->input('car'))->first(['price']);
        if ($request->has('help')) {
            $sale->price = $price->price + 5000;
            if ($request->has('truck')) {
                $sale->price = $price->price + 10000;
                $sale->country = $request->input('country');
                $sale->address = $request->input('address');
            }
        } elseif ($request->has('truck')) {
            $sale->price = $price->price + 5000;
            $sale->country = $request->input('country');
            $sale->address = $request->input('address');
        } else {
            $sale->price = $price->price;
        }
        $sale->help = $request->has('help');
        $sale->truck = $request->has('truck');
        $sale->sale_status = $request->input('paymentMethod') === '1' ? 'booked' : 'sold';
        $sale->paymentMethod = $request->input('paymentMethod');
        $sale->employee_id = '1';
        $sale->timestamps;
        $sale->save();

        Car::where('car_id', $request->input('car'))->update(['status' => $sale->sale_status]);
        return redirect()->route('sales');
    }
    public function GetCarID(Request $request)
    {
        $carID = $request->input('car');
        $models = Car::join('models', 'models.car_model_id', '=', 'cars.car_model_id')
            ->join('colors', 'colors.car_color_id', '=', 'cars.car_color_id')
            ->join('brands', 'brands.car_brand_id', '=', 'models.car_brand_id')
            ->where('car_id', $carID)
            ->first(['car_id', 'car_brand', 'car_name', 'car_color','car_year' ,'car_vin', 'price', 'status']);
        return response()->json($models);
    }

    public function edit_sale($sale_id):View{
        try {
            $sale = Sales::join('cars', 'sales.car_id', '=', 'cars.car_id')
                ->join('models', 'models.car_model_id', '=', 'cars.car_model_id')
                ->join('colors', 'colors.car_color_id', '=', 'cars.car_color_id')
                ->join('brands', 'brands.car_brand_id', '=', 'models.car_brand_id')
                ->join('types', 'models.car_type_id', '=', 'types.car_type_id')
                ->join('clients','sales.client_id', '=', 'clients.client_id')
                ->where('sale_id', '=' , $sale_id)
                ->first();

            // Проверка, что коллекция не пуста
            if ($sale != null) {
                return view('edit_sale',[
                    'sale' => $sale,
                ]);
            } else {
                abort(404);
            }
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }
    public function edit_sale_handler(Request $request)
    {
        // Находим машину и сделку по car_id
        $sale = Sales::join('cars', 'sales.car_id', '=', 'cars.car_id')
            ->find($request->input('sale_id'));

        // Проверяем, найдена ли машина
        if ($sale) {
            // Обновляем поля машины и сделки
            $sale->sale_status = $request->input('status');
            $sale->save();

            $car = $sale->car; // Предполагается, что у модели Sale есть отношение car
            if ($car) {
                $car->status = $request->input('status');
                $car->save();
            }

            return redirect()->route('sales');
        } else {
            // Если машина не найдена, выполните необходимые действия
            return redirect()->route('sales')->with('error', 'Машина не найдена');
        }
    }

}
