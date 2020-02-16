<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller {

    public function homeCategories()
    {
        $categories = Category::where( 'in_homepage', '!=', '0' )
            ->get( ['name_en', 'id', 'slug'] );

        return $categories;
    }

    public function categoryProducts( $slug, Request $request )
    {
        $category = Category::where( 'slug', $slug )->first();

        $filterOptions = $request->query();
        if(isset($filterOptions['cat']))
        {
            $filterCategories = explode(',',$filterOptions['cat']);
            $categoriesIds = Category::whereIn( 'slug', $filterCategories )->pluck('id');

        }

        if(!isset($filterOptions['cat']))
        {
            $categoriesIds = $category->subCategories()
                ->pluck('id');
            $categoriesIds->push($category->id);
        }

        $query = Product::whereHas('categories', function ($query) use ($categoriesIds){
            $query->whereIn('id', $categoriesIds->toArray());
        });

        if(isset($filterOptions['color']))
        {
            $filterColors = explode(',',$filterOptions['color']);

            $query->whereHas('productAttributeValues', function ($query) use ($filterColors){
                $query->whereIn('attribute_value_id', $filterColors);
            });
        }

        $products = $query->orderBy( 'created_at', 'desc' )->paginate(9);


        if ( $category )
        {
            $productModel = new Product();

            $filterAttributes = $productModel->getProductsFilterAttributes($products);

            $products = $productModel->getProductsRatingColors($products);

            $response = [
                'category' => [
                    'name_en'        => $category->name_en,
                    'description_en' => $category->description_en,
                    'banner'         => $category->banner,
                    'image'          => $category->image,
                    'slug'           => $category->slug,
                ],
                'products' => $products,
                'filterAttributes' => $filterAttributes
            ];
            return response()->json( $response );
        }

        return [];
    }

    public function listFilterCategories($slug)
    {
        if($slug)
        {
            $category = Category::where( 'slug', $slug )->first();

            $children = $category->subCategories;

            return [
              'singleCategories' => $children
            ];

        }

        $categories = Category::all();

        return [
            'singleCategories' => $categories
        ];
    }
}
