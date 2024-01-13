<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'models'; // Имя вашей таблицы
    protected $primaryKey = 'car_model_id'; // Имя первичного ключа

    // Другие поля, если они есть
    protected $fillable = ['car_name', 'car_brand_id'];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'car_brand_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'car_type_id');
    }

    public function cars()
    {
        return $this->hasMany(Car::class, 'car_model_id');
    }
}
