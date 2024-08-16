<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class Branch extends Model
{

     protected $table = 'branch';

   // Specify the primary key if it's not the default 'id'
    protected $primaryKey = 'id';

    // Specify the columns that are mass assignable
    protected $fillable = [
        'car_id',
        'text',
        'loclat',
        'loclong',
        'regionid',
        'cityid',
        'branchid',
        'address1',
        'address2',
        'hours',
        'phone1',
        'phone2',
        'mobile',
        'agent',
        'email',
    ];

    // If the primary key is not auto-incrementing
    public $incrementing = true;

    // If the primary key is not an integer
    protected $keyType = 'int';

    // If timestamps are not used
    public $timestamps = false;

    public function cars()
    {
        return $this->hasMany(Car::class);
    }



}
