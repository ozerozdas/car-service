<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cars;
use App\Models\Services;

class Orders extends Model
{
    use HasFactory;

    public function cars()
    {
        return $this->hasMany(Cars::class, 'id', 'car_id');
    }

    public function services()
    {
        return $this->hasMany(Services::class, 'id', 'service_id');
    }
}
