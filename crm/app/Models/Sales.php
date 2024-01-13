<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'sale_id';
    protected $fillable = ['client_id', 'car_id', 'email', 'price', 'help', 'truck', 'country', 'address', 'paymentMethod', 'sale_status', 'employee_id'];

    protected $attributes = [
        'help' => false,
        'truck' => false,
    ];

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function user()
    {
        return $this->belongsTo(Model::class, 'user_id');
    }

    public function client()
    {
        return $this->belongsTo(Model::class, 'client_id');
    }

}
