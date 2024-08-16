<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking'; // Use the table name if different

    protected $fillable = [
        'branch_id',
        'car_id',
        'variant',
        'pickupDate',
        'returnDate',
        'price',
        'duration',
        'pickupLocation',
        'dropoffLocation',
    ];

    public function cardDetail()
    {
        return $this->hasOne(CardDetail::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }


    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
