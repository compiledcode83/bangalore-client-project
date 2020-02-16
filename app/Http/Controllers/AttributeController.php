<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function listFilterColors()
    {
        $colorAttribute = Attribute::where( 'name_en', 'color' )->first();
        $colors = AttributeValue::where( 'attribute_id', $colorAttribute->id )
                                ->where( 'is_active', '1' )
                                ->get(['id', 'value_en', 'value_ar', 'other_value']);

        return $colors;
    }
}
