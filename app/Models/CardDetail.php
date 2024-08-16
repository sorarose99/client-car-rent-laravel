<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class CardDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_number',
        'card_holder',
        'expiry_date',
        'issuer',
        'cvv',
        'booking_id',
    ];

    protected $casts = [
        'expiry_date' => 'date', // Adjust if necessary
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
