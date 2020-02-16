<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductsImport implements WithMultipleSheets {

    public function sheets(): array
    {
        return [
            'products_sheet' => new ProductsSheetImport(),
            'colors_sheet' => new ColorsSheetImport(),
            'prices_sheet' => new PricesSheetImport(),
        ];
    }
}
