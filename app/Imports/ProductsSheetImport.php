<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Validator;

class ProductsSheetImport implements ToCollection, WithHeadingRow {


    public function collection( Collection $rows )
    {
        Validator::make( $rows->toArray(), [
            '*.name_english'              => 'required',
            '*.name_arabic'               => 'required',
            '*.short_description_english' => 'required',
            '*.short_description_arabic'  => 'required',
            '*.description_english'       => 'required',
            '*.description_arabic'        => 'required',
            '*.more_info_english'         => 'required',
            '*.more_info_arabic'          => 'required',
            '*.sku'                       => 'required',
            '*.main_image'                => 'required',
            '*.supplier_price'            => 'required',
        ] )->validate();

        foreach ($rows as $row)
        {
            $gallery = explode( ',', $row['main_gallery'] );
            foreach ($gallery as &$image)
            {
                $image = '/images/'.$image;
            }
            $obj = new Product( [
                'main_gallery'         => $gallery,
                'name_en'              => $row['name_english'],
                'name_ar'              => $row['name_arabic'],
                'short_description_ar' => $row['short_description_english'],
                'short_description_en' => $row['short_description_arabic'],
                'description_en'       => $row['description_english'],
                'description_ar'       => $row['description_arabic'],
                'more_information_ar'  => $row['more_info_english'],
                'more_information_en'  => $row['more_info_arabic'],
                'sku'                  => $row['sku'],
                'main_image'           => '/images/'.$row['main_image'],
                'supplier_price'       => $row['supplier_price'],
            ] );

            $this->persistToDataBase( $obj );
        }
    }

    public function persistToDataBase( $data )
    {
        try
        {
            return $data->save();
        } catch (QueryException $exception)
        {
            return back()->withErrors( "Duplicate Entry SKU, please check your data!" );
        } catch (\Exception $exception)
        {
            return back()->withErrors( "Something went wrong in products sheet, please check your file!" );
        }

    }
}
