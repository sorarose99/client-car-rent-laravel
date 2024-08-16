<?php
// app/Models/Car.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'car';
    use HasFactory;
  protected $fillable = [
        'branch_id',
        'title',
        'images',
        'engine',
        'mileage',
        'color',
        'transmission',
        'fuel_type',
        'doors',
        'seats',
         'price_per_day','price_per_hour','price_per_month',
        'additional_details',
    ];


    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }





}
