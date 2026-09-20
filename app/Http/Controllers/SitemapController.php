<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];

        $urls[] = $this->url(route('home'), now(), 'daily', '1.0');
        $urls[] = $this->url(route('blogs.index'), now(), 'weekly', '0.6');

        foreach (Category::where('status', true)->get(['slug', 'updated_at']) as $category) {
            $urls[] = $this->url(route('category.show', $category->slug), $category->updated_at, 'weekly', '0.8');
        }

        foreach (Brand::where('status', true)->get(['slug', 'updated_at']) as $brand) {
            $urls[] = $this->url(url('/brand/' . $brand->slug), $brand->updated_at, 'weekly', '0.7');
        }

        foreach (Product::where('status', 'active')->get(['slug', 'updated_at']) as $product) {
            $urls[] = $this->url(route('product.show', $product->slug), $product->updated_at, 'weekly', '0.9');
        }

        foreach (Blog::where('is_published', true)->get(['slug', 'updated_at']) as $blog) {
            $urls[] = $this->url(route('blogs.view', $blog->slug), $blog->updated_at, 'monthly', '0.5');
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xml .= implode('', $urls);
        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    private function url(string $loc, $lastmod, string $freq, string $priority): string
    {
        $last = $lastmod ? $lastmod->toAtomString() : now()->toAtomString();

        return '<url>'
            . '<loc>' . htmlspecialchars($loc, ENT_XML1) . '</loc>'
            . '<lastmod>' . $last . '</lastmod>'
            . '<changefreq>' . $freq . '</changefreq>'
            . '<priority>' . $priority . '</priority>'
            . '</url>';
    }
}
