<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Concerns\HasTimestamps;
class Car extends Model
{
    protected $table = 'cars';
    protected $primaryKey = 'car_id';
    protected $fillable = ['created_at', 'updated_at'];
    public function model()
    {
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'car_color_id');
    }
    public function images()
    {
        return $this->hasMany(Images::class);
    }
    public function docs()
    {
        return $this->hasMany(Docs::class);
    }
}
