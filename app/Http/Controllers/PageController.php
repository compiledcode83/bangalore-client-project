<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ClientLogo;
use App\Models\Faq;
use App\Models\Setting;
use App\Models\SocialMedia;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use App\Http\Resources\Page as PageResource;

class PageController extends Controller {

    public function getPage( $slug )
    {
        $page = StaticPage::where( 'slug', $slug )
            ->first();
        $clientLogos = [];
        if ( $slug == 'clients' )
        {
            $clientLogos = ClientLogo::where( 'is_active', '1' )->get();
        }

        return [
            'page' => [
                'title'       => $page->title,
                'body'        => $page->body,
                'banner'      => $page->banner,
                'slug'        => $page->slug,
                'clientLogos' => $clientLogos
            ]
        ];

    }

    public function getSocial()
    {
        return SocialMedia::all();
    }

    public function getFAQPage()
    {
        $settings = Setting::find( 1 );
        $faqItemsData = Faq::where( 'is_active', '1' )->get();

        $faqItems = [];
        foreach ($faqItemsData as $item)
        {
            $faqItems [] = [
                'id'          => $item->id,
                'title'       => $item->title,
                'description' => $item->description
            ];
        }

        return [
            'banner'   => $settings->faq_banner,
            'faqItems' => $faqItems
        ];
    }

    public function getSitemapPage()
    {
        $settings = Setting::find( 1 );
        $categories = Category::where( 'is_active', 1 )->whereHas( 'products' )->get();
        $pages = [
            ['title' => 'About Us', 'link' => '/about'],
            ['title' => 'Services', 'link' => '/services'],
            ['title' => 'Media', 'link' => '/media'],
            ['title' => 'Privacy', 'link' => '/pages/privacy'],
            ['title' => 'Terms', 'link' => '/pages/terms'],
            ['title' => 'Clients', 'link' => '/pages/clients'],
            ['title' => 'FAQs', 'link' => '/faq'],
            ['title' => 'Contact', 'link' => '/contact'],
        ];

        return [
            'banner'     => $settings->sitemap_banner,
            'pages'      => $pages,
            'categories' => $categories
        ];
    }
}
