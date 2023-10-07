<?php

namespace App\Helpers;

use App\Models\Property;
use Illuminate\Support\Facades\Log;

class PropertiesHelper
{
    public static function getInitialProperties()
    {
        return Property::all();
    }

    public static function getPriceOptions()
    {
        Log::info(print_r(Property::pluck('price')->sort(), true));

        $prices = Property::pluck('price')->sort();

        $min = $prices->first();
        $max = $prices->last();

        $step = ($max - $min) / 9;

        return [
            'min' => $min,
            'max' => $max,
            'step' => round($step)
        ];
    }
}
