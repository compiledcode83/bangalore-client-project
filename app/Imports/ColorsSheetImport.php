<?php

namespace App\Imports;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use Illuminate\Support\Collection;
use Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ColorsSheetImport implements ToCollection, WithHeadingRow {

    /**
     * @param Collection $rows
     * @throws ValidationException
     */
    public function collection( Collection $rows )
    {
        Validator::make( $rows->toArray(), [
            '*.product_sku'        => 'required',
            '*.color_name_english' => 'required',
            '*.color_name_arabic'  => 'required',
            '*.color_code'         => 'required',
            '*.color_sku'          => 'required',
            '*.stock'              => 'required',
            '*.images'             => 'required'
        ] )->validate();

        foreach ($rows as $row)
        {
            $obj = [
                'product_sku'        => $row['product_sku'],
                'color_name_english' => $row['color_name_english'],
                'color_name_arabic'  => $row['color_name_arabic'],
                'color_code'         => $row['color_code'],
                'color_sku'          => $row['color_sku'],
                'stock'              => $row['stock'],
                'images'             => $row['images'],
            ];

            $this->persistToDataBase( $obj );
        }
    }

    public function persistToDataBase( $data )
    {
        try
        {
            $gallery = explode( ',', $data['images'] );
            foreach ($gallery as &$image)
            {
                $image = '/images/'.$image;
            }

            $product = Product::where( 'sku', $data['product_sku'] )->first();
            $attributeValue = AttributeValue::where( 'value_en', $data['color_name_english'] )
                ->where( 'value_ar', $data['color_name_arabic'] )
                ->where( 'other_value', $data['color_code'] )
                ->first();

            if ( !$attributeValue )
            {
                $attributeValue = AttributeValue::create( [
                    'attribute_id' => '1',
                    'value_en'     => $data['color_name_english'],
                    'value_ar'     => $data['color_name_arabic'],
                    'other_value'  => $data['color_code']
                ] );
            }

            $productColor = new ProductAttributeValue( [
                'product_id'         => $product->id,
                'attribute_value_id' => $attributeValue->id,
                'sku'                => $data['color_sku'],
                'stock'              => $data['stock'],
                'main_images'        => $gallery,
            ] );

            return $productColor->save();
        } catch (\Exception $exception)
        {
            return back()->withErrors( "Something went wrong in colors sheet, please check your file!" );
        }
    }
}
