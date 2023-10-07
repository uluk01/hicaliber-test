<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    public function get(Request $request)
    {
        $properties = Property::query();
        foreach($request->json() as $key => $param) {
            if(!empty($param) && $request->has($key)) {
                if($key === "name") {
                    $properties->where($key, 'LIKE', "%{$param}%");
                } elseif($key === 'price') {
                    $properties->whereBetween($key, $param);
                } else {
                    $properties->where($key, '=', $param);
                }
            }
        }

        return $properties->get();
    }

    public function create(Request $request)
    {
        //
    }
}
