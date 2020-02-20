<?php

namespace App\Http\Controllers\HomeSections;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;

class OfferController extends Controller
{
    public function homeOffers()
    {
        $offersSection = HomepageSection::where('type', 'special_offers')->get();

        //check if section defined with 1 left, 1 right and 2 in middle
        $defaultSection = ['left' => 1, 'middle' => 2, 'right' => 1];
        $definedSection = $offersSection->pluck('item_location');
        $definedSectionCount = array_count_values($definedSection->toArray());


        if($definedSectionCount == $defaultSection)
        {
            list($left, $restOfSections) = $offersSection->partition(function ($item) {
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
