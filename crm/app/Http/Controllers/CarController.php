<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCarRequest;
use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\Images;
use App\Models\Docs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use NumberFormatter;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $status = null)
    {
        // Формирование запроса к базе данных
        $query = Car::join('models', 'models.car_model_id', '=', 'cars.car_model_id')
            ->join('colors', 'colors.car_color_id', '=', 'cars.car_color_id')
            ->join('brands', 'brands.car_brand_id', '=', 'models.car_brand_id')
            ->join('types', 'types.car_type_id', '=', 'models.car_type_id')
            ->select('cars.*', 'models.*', 'colors.*', 'brands.*', 'types.*');

        if ($status == 'sold'){
            $query->where('cars.status', 'sold');
        }elseif ($status == 'available'){
            $query->where('cars.status', 'available');
        }else{
            $query->get();
        }

        // Добавление фильтров, если они указаны
        $carMake = $request->input('car_make');
        if ($carMake) {
            $query->where('brands.car_brand_id', '=', $carMake);
            $query->where('status', '!=', 'sold');
        }

        $carModel = $request->input('car_model');
        if ($carModel) {
            $query->where('models.car_model_id', '=', $carModel);
        }

        $carColor = $request->input('color');
        if ($carColor) {
            $query->where('colors.car_color_id', '=', $carColor);
            $query->where('status', '!=', 'sold');
        }

        $priceFrom = $request->input('price_from');
        if ($priceFrom) {
            $query->where('cars.price', '>=', $priceFrom);
            $query->where('status', '!=', 'sold');
        }

        $priceTo = $request->input('price_to');
        if ($priceTo) {
            $query->where('cars.price', '<=', $priceTo);
            $query->where('status', '!=', 'sold');
        }

        $yearFrom = $request->input('year_from');
        if ($yearFrom) {
            $query->where('cars.car_year', '>=', $yearFrom);
            $query->where('status', '!=', 'sold');
        }

        $yearTo = $request->input('year_to');
        if ($yearTo) {
            $query->where('cars.car_year', '<=', $yearTo);
            $query->where('status', '!=', 'sold');
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

        return view('admin_panel.cars.cars', [
            'data' => $data,
            'brands' => $brands,
            'colors' => $colors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $models = CarModel::join('brands','brands.car_brand_id', '=', 'models.car_brand_id')
            ->join('types','types.car_type_id', '=', 'models.car_type_id')
            ->select('models.*', 'brands.*', 'types.*')
            ->get();

        $colors = Color::all();

        return view('admin_panel.cars.add',[
            'models' => $models,
            'colors' => $colors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddCarRequest $request)
    {
        $car = new Car();
        $car->car_model_id = $request->input('model');
        $car->car_year = $request->input('year');
        $car->car_color_id = $request->input('color');
        $car->car_vin = $request->input('vin');
        $car->price = $request->input('price');
        $car->status = $request->input('status');
        $car->save();
        $carID = $car->car_id;

        // Обработка изображений
        $images = $request->file('images');
        if ($images) {
            foreach ($images as $image) {
                $path = Storage::put('public/images', $image, 'public');
                $relativePath = \Illuminate\Support\Str::after($path, 'public/');
                Images::create(['path' => $relativePath, 'car_id' => $carID]);
            }
        }

        // Обработка документов
        $docs = $request->file('docs');
        if ($docs) {
            foreach ($docs as $doc) {
                $path = Storage::put('public/docs', $doc, 'public');
                $relativePath = \Illuminate\Support\Str::after($path, 'public/');
                Docs::create(['path' => $relativePath, 'car_id' => $carID]);
            }
        }

        return redirect()->route('add_car')->withSuccess('Запись успешно добавлена');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $car_id)
    {
        try {
            $car = Car::join('models', 'models.car_model_id', '=', 'cars.car_model_id')
                ->join('colors', 'colors.car_color_id', '=', 'cars.car_color_id')
                ->join('brands', 'brands.car_brand_id', '=', 'models.car_brand_id')
                ->join('types', 'types.car_type_id', '=', 'models.car_type_id')
                ->select('cars.*', 'models.*', 'colors.*', 'brands.*', 'types.*')
                ->where('cars.car_id', '=', $car_id)
                ->firstOrFail(); // Заменяем first() на firstOrFail()
            $images = Images::where('car_id', $car_id)->get();
            $docs = Docs::where('car_id', $car_id)->get();
            return view('admin_panel.cars.show', [
                'car' => $car,
                'images' => $images,
                'docs' => $docs,
            ]);
        } catch (ModelNotFoundException $e) {
            // Обработка ситуации, когда модель не найдена
            return 'error'; // Пример вывода страницы 404
        } catch (\Exception $e) {
            // Обработка других исключений
            return 'error'; // Пример вывода страницы 500
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $car_id)
    {
        try {
            $car = Car::join('models', 'models.car_model_id', '=', 'cars.car_model_id')
                ->join('colors', 'colors.car_color_id', '=', 'cars.car_color_id')
                ->join('brands', 'brands.car_brand_id', '=', 'models.car_brand_id')
                ->join('types', 'types.car_type_id', '=', 'models.car_type_id')
                ->select('cars.*', 'models.*', 'colors.*', 'brands.*', 'types.*')
                ->where('cars.car_id', '=', $car_id)
                ->firstOrFail();

            $colors = Color::all();
            return view('admin_panel.cars.edit', [
                'car' => $car,
                'colors' => $colors,
            ]);
        } catch (ModelNotFoundException $e) {
            // Обработка ситуации, когда модель не найдена
            return 'error'; // Пример вывода страницы 404
        } catch (\Exception $e) {
            // Обработка других исключений
            return 'error'; // Пример вывода страницы 500
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $car_id)
    {
        $car = Car::find($car_id);
        // Проверяем, найдена ли машина
        if ($car) {
            // Обновляем поля машины
            $car->car_model_id = $request->input('model');
            $car->car_year = $request->input('year');
            $car->car_color_id = $request->input('color');
            $car->car_vin = $request->input('vin');
            $car->price = $request->input('price');
            $car->status = $request->input('status');

            $car->save();

            $carID = $car->car_id;

            // Обработка изображений
            $images = $request->file('images');
            if ($images) {
                foreach ($images as $image) {
                    $path = Storage::put('public/images', $image, 'public');
                    $relativePath = \Illuminate\Support\Str::after($path, 'public/');
                    Images::create(['path' => $relativePath, 'car_id' => $carID]);
                }
            }

            // Обработка документов
            $docs = $request->file('docs');
            if ($docs) {
                foreach ($docs as $doc) {
                    $path = Storage::put('public/docs', $doc, 'public');
                    $relativePath = \Illuminate\Support\Str::after($path, 'public/');
                    Docs::create(['path' => $relativePath, 'car_id' => $carID]);
                }
            }

            return redirect()->route('cars_index', 'all')->withSuccess('Запись успешно обновлена');
        } else {
            // Если машина не найдена, выполните необходимые действия
            return redirect()->route('cars_index', 'all')->with('error', 'Машина не найдена');
        }
    }

    public function delete_doc($id)
    {
        if (Auth::check()) {
            // Check if the authenticated user has the 'admin' role or a specific capability
            if (Auth::user()->hasRole('admin')) {
                $doc = Docs::where('doc_id', $id)->first();
                if ($doc) {
                    // Удалить файл
                    Storage::delete('public/'.$doc->path);
                    $doc->where('doc_id', $id)->delete();
                    return redirect()->back()->withSuccess('Успешно удалено');
                } else{
                    return redirect()->back()->with('error', 'Запись не найдена');
                }
            } else {
                // User is not an admin, redirect them back
                return redirect()->back()->with('error', 'У вас недостаточно прав доступа');
            }
        } else {
            // User is not authenticated, redirect them to the login page
            return redirect()->route('login')->with('error', 'Необходимо выполнить вход');
        }
    }

    public function delete_image($id)
    {
        if (Auth::check()) {
            // Check if the authenticated user has the 'admin' role or a specific capability
            if (Auth::user()->hasRole('admin')) {
                $img = Images::where('image_id', $id)->first();
                if ($img) {
                    // Удалить файл
                    Storage::delete('public/'.$img->path);
                    $img->where('image_id', $id)->delete();
                    return redirect()->back()->withSuccess('Успешно удалено');
                } else{
                    return redirect()->back()->with('error', 'Запись не найдена');
                }
            } else {
                // User is not an admin, redirect them back
                return redirect()->back()->with('error', 'У вас недостаточно прав доступа');
            }
        } else {
            // User is not authenticated, redirect them to the login page
            return redirect()->route('login')->with('error', 'Необходимо выполнить вход');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($car_id)
    {
        if (Auth::check()) {
            // Check if the authenticated user has the 'admin' role or a specific capability
            if (Auth::user()->hasRole('admin')) {
                $car = Car::find($car_id);

                if ($car) {
                    // Найти изображения и удалить соответствующие файлы
                    $images = Images::where('car_id', $car_id)->get();
                    foreach ($images as $image) {
                        // Удалить файл
                        Storage::delete('public/'.$image->path);
                    }

                    // Найти документы и удалить соответствующие файлы
                    $docs = Docs::where('car_id', $car_id)->get();
                    foreach ($docs as $doc) {
                        // Удалить файл
                        Storage::delete('public/'.$doc->path);
                    }
                    $car->delete();
                    return redirect()->route('cars_index', 'all')->withSuccess('Запись успешно удалена');
                } else {
                    return redirect()->route('cars_index', 'all')->with('error', 'Машина не найдена');
                }
            } else {
                // User is not an admin, redirect them back
                return redirect()->back()->with('error', 'У вас недостаточно прав доступа');
            }
        } else {
            // User is not authenticated, redirect them to the login page
            return redirect()->route('login')->with('error', 'Необходимо выполнить вход');
        }
    }
}
