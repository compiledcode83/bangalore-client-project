<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;
use Illuminate\Http\Request;
use App\Http\Resources\Page as PageResource;

class PageController extends Controller
{
    public function getPage($slug)
    {
        $page = StaticPage::where( 'slug', $slug )
                            ->first();

        return [
            'page' => new PageResource($page)
        ];

    }
}
