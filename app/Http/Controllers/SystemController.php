<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequirement;
use Spatie\Sitemap\SitemapGenerator;

class SystemController extends Controller
{
    public function health()
    {
       return response()->json(['message' => 'success'], 200);
    }

    public function generateSitemap()
    {
        $sitemap = SitemapGenerator::create(config('app.url'))
            ->getSitemap();

        $purchaseReqs = PurchaseRequirement::all();

        foreach ($purchaseReqs as $purchaseReq)
        {
            $sitemap->add(route('purchase_requirements.show.slug', $purchaseReq->slug));
        }

        $sitemap->writeToFile('sitemap.xml');
        echo 'Done';
    }
}
