<?php

namespace App\Http\Controllers\HomeSections;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;

class NewArrivalController extends Controller
{
    public function homeNewArrivals()
    {
        $newArrivalSection = HomepageSection::where('type', 'new_arrivals')->get();

        //check if section defined with 1 left, 1 right and 2 in middle
        $defaultSection = ['left' => 1, 'middle' => 2, 'right' => 1];
        $definedSection = $newArrivalSection->pluck('item_location');
        $definedSectionCount = array_count_values($definedSection->toArray());


        if($definedSectionCount == $defaultSection)
        {
            list($left, $restOfSections) = $newArrivalSection->partition(function ($item) {
                return $item->item_location == 'left';
            });
            list($middle, $right) = $restOfSections->partition(function ($item) {
                return $item->item_location == 'middle';
            });

            return [
                'left'  => $left,
                'middle'  => $middle,
                'right'  => $right
            ];
        }

        //disable view in front-end
        return 0;
    }
}
