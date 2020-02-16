<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Validator;

class PricesSheetImport implements ToCollection, WithHeadingRow {

    /**
     * @param Collection $rows
     * @throws ValidationException
     */
    public function collection( Collection $rows )
    {
        Validator::make( $rows->toArray(), [
            '*.product_sku'                      => 'required',
            '*.max_qty'                          => 'required|numeric',
            '*.supplier_price'                   => 'required|numeric',
            '*.individual_unit_price'            => 'required|numeric',
            '*.individual_discounted_unit_price' => 'required|numeric',
            '*.corporate_unit_price'             => 'required|numeric',
            '*.corporate_discounted_unit_price'  => 'required|numeric'
        ] )->validate();

        foreach ($rows as $row)
        {
            $obj = [
                'product_sku'                      => $row['product_sku'],
                'max_qty'                          => $row['max_qty'],
                'supplier_price'                   => $row['supplier_price'],
                'individual_unit_price'            => $row['individual_unit_price'],
                'individual_discounted_unit_price' => $row['individual_discounted_unit_price'],
                'corporate_unit_price'             => $row['corporate_unit_price'],
                'corporate_discounted_unit_price'  => $row['corporate_discounted_unit_price'],
            ];

            $this->persistToDataBase( $obj );
        }
    }

    public function persistToDataBase( $data )
    {
        try
        {
            $product = Product::where( 'sku', $data['product_sku'] )->first();
            $productPrice = new ProductPrice( [
                'product_id'                       => $product->id,
                'max_qty'                          => $data['max_qty'],
                'supplier_price'                   => $data['supplier_price'],
                'individual_unit_price'            => $data['individual_unit_price'],
                'individual_discounted_unit_price' => $data['individual_discounted_unit_price'],
                'corporate_unit_price'             => $data['corporate_unit_price'],
                'corporate_discounted_unit_price'  => $data['corporate_discounted_unit_price'],
            ] );

            return $productPrice->save();
        } catch (\Exception $exception)
        {
            return back()->withErrors( "Something went wrong in prices sheet, please check your file!" );
        }
    }
}
