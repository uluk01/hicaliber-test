<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model {

    protected $fillable = [
        'id',
        'name',
        'price',
        'bedrooms',
        'bathrooms',
        'storeys',
        'garages'
      ];
}