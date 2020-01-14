<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller {

    public function homeCategories()
    {
        $categories = Category::where( 'in_homepage', '!=', '0' )
            ->get( ['name_en', 'id', 'slug'] );

        return $categories;
    }

    public function categoryProducts( $slug )
    {
        $category = Category::with( 'products' , 'products.reviews')
                            ->where( 'slug', $slug )
                            ->first();

        $products = $category->products()->orderBy( 'created_at', 'desc' )->paginate(9);

        if ( $category )
        {
            foreach ($products as $product)
            {
                //add ratings
                if ( $product->reviews->first() )
                {
                    $reviews = $product->reviews;
                    $count = $reviews->count();
                    if ( $count )
                    {
                        $product->rating = ceil( $reviews->sum( 'rating' ) / $count );
                    }
                }
                //add colors
                $colors = [];
                if($product->productAttributeValues->first())
                {
                    foreach ($product->productAttributeValues as $productAttributeValue)
                    {
                        if(isset($productAttributeValue->attributeValue->other_value))
                        {
                            $colors [] = $productAttributeValue->attributeValue->other_value;
                        }
                    }

                }

                $product->colors = $colors;
            }

            $response = [
                'category' => [
                    'name_en'        => $category->name_en,
                    'description_en' => $category->description_en,
                    'banner'         => $category->banner,
                    'image'          => $category->image,
                    'slug'           => $category->slug,
                ],
                'products' => $products
            ];
            return response()->json( $response );
        }

        return [];
    }
}
