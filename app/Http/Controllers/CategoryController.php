<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller {

    public function homeCategories()
    {
        $categories = Category::where( 'is_active', '1' )
            ->where( 'in_homepage', '!=', '0' )
            ->get();

        $response = [];
        foreach ($categories as $category)
        {
            $response[] = [
                'id'     => $category->id,
                'name'   => $category->name,
                'slug'   => $category->slug
            ];
        }

        return $response;
    }

    public function categoryProducts( $slug, Request $request )
    {
        $wishList = [];
        $user = Auth::guard('api')->user();
        if($user)
        {
            //get user wishList
            $wishList = $user->wishLists->pluck('product_id')->toArray();
        }

        $category = Category::where( 'slug', $slug )->first();

        $filterOptions = $request->query();
//        dd($filterOptions);
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

        if(isset($filterOptions['term']))
        {
            $query->where('name_en', 'LIKE', '%'. $filterOptions['term'] .'%')
                ->orWhere('name_ar', 'LIKE', '%'. $filterOptions['term'] .'%');
        }

        if(isset($filterOptions['color']))
        {
            $filterColors = explode(',',$filterOptions['color']);

            $query->whereHas('productAttributeValues', function ($query) use ($filterColors){
                $query->whereIn('attribute_value_id', $filterColors);
            });
        }

        if(isset($filterOptions['discount']))
        {
            if(in_array('upTo30',$filterOptions['discount'] )){
                $query->whereHas('prices', function ($query) use ($filterOptions, $user){

                    if(isset($user->type))
                    {
                        if($user->type == User::TYPE_CORPORATE)
                        {
//                        $query->where('percentage_discount', '<=',  $filterOptions['min']);
//                        $query->where('corporate_unit_price', '<=',  $filterOptions['max']);
                        }
                        else
                        {
//                        $query->where('individual_unit_price', '>=',  $filterOptions['min']);
//                        $query->where('individual_unit_price', '<=',  $filterOptions['max']);
                        }
                    }

                });
            }
            if(in_array('upTo50',$filterOptions['discount'] )){
//                dd($filterOptions['discount']);
            }
            if(in_array('upTo60',$filterOptions['discount'] )){
//                dd($filterOptions['discount']);
            }
            if(in_array('moreThan60',$filterOptions['discount'] )){
//                dd($filterOptions['discount']);
            }
        }

        if(isset($filterOptions['sort']))
        {
            $products = $query->active()->orderBy( 'name_en', $filterOptions['sort'] )->get();

        }
        else
        {
            $products = $query->active()->orderBy( 'created_at', 'desc' )->get();
//            $products = $products->sortByDesc('created_at')->values()->all();
//            $products = collect($products);
        }

        if ( $category )
        {
            $productModel = new Product();

            // make sure filter attributes not changed after apply any of filters on category
            // get all products without applied filters and extract general filter options
            $generalSubCats = $category->subCategories()->pluck('id');
            $generalSubCats->push($category->id);
            $generalProducts = Product::whereHas('categories', function ($query) use ($generalSubCats){
                $query->whereIn('id', $generalSubCats->toArray());
            })->active()->get();
            $filterAttributes = $productModel->getProductsFilterAttributes($generalProducts);

            $products = $productModel->getProductsRatingColors($products);
            $products = $this->addWishListedProducts($products, $wishList);
            $products = $productModel->addPrices($products,$user);

            if (isset($filterOptions['sort_by_price']))
            {
                $sortBy = 'SortByDesc';
                if($filterOptions['sort_by_price'] == 'asc'){
                    $sortBy = 'sortBy';
                }
                $products = $products->$sortBy(function($value) use ($user) {
                    $setting = Setting::find(1);
                    $discountEnabled = $setting->enable_offers_page;

                    if($discountEnabled){
                        return $value->price['discount'];
                    } else
                    {
                        return $value->price['baseOriginal'];
                    }
                })->values()->all();
                $products =  $this->paginate($products, $perPage = count($products), $page = null, $options = []);
            }else{
                // IF No SORTING  THEN PAGINATE
                $products =  $this->paginate($products, $perPage = 9, $page = null, $options = []);
            }

//            if(is_array($products)){
//
//                $products = Collection::wrap($products);
//            }
//            $page = $request['page'] ?? 1;
//            $perPage = 9;
//            $pagination = new \Illuminate\Pagination\LengthAwarePaginator(
//                $products->forPage($page, $perPage),
//                $products->count(),
//                $perPage,
//                $page
//            );
//            $products = $pagination;

//            $products = $products->take(3);

            if(isset($filterOptions['min']) || isset($filterOptions['max']))
            {
                foreach ($products as $product)
                {
                    if($product->price['discount']){

                        if($product->price['discount'] < $filterOptions['min'] && $product->price['discount'] > $filterOptions['max']){
                            $products->forget($product);
                        }
                    }else{
                        if($product->price['baseOriginal'] < $filterOptions['min'] && $product->price['baseOriginal'] > $filterOptions['max']){
                            $products->forget($product);
                        }
                    }
                }
            }

            $response = [
                'category' => [
                    'name_en'        => $category->name_en,
                    'description_en' => $category->description_en,
                    'banner'         => $category->banner,
                    'image'          => $category->image,
                    'slug'           => $category->slug,
                ],
                'products' => $products->toArray(),
            ];

//            if(empty($filterOptions))
//            {
                $response['filterAttributes'] = $filterAttributes;
//            }
            return response()->json( $response );
        }

        return [];
    }

    public function addWishListedProducts($products, $wishList)
    {
        foreach ($products as $product)
        {
            if(in_array($product->id, $wishList))
            {
                $product->whishlisted = 1;
            }
            else
            {
                $product->whishlisted = 0;
            }
        }

        return $products;
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

    /**
     * Gera a paginação dos itens de um array ou collection.
     *
     * @param array|Collection      $items
     * @param int   $perPage
     * @param int  $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 9, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);


        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
