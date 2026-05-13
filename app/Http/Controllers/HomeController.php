<?php

namespace App\Http\Controllers;

use App\Models\DrawResult;
use App\Models\GalleryImage;
use App\Models\HomepageSection;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sections = HomepageSection::where('is_enabled', true)
            ->orderBy('sort_order')
            ->get();

        $storeDrawResult  = DrawResult::where('type', 'store')
            ->where('is_published', true)
            ->where('is_home_featured', true)
            ->with('drawNumbers')
            ->first();

        $onlineDrawResult = DrawResult::where('type', 'online')
            ->where('is_published', true)
            ->where('is_home_featured', true)
            ->with('drawNumbers')
            ->first();

        $postsSection = $sections->firstWhere('section_key', 'posts');
        $postsLimit   = $postsSection?->display_limit ?? 6;
        $posts = Post::where('is_published', true)
            ->orderByDesc('is_pinned')
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->limit($postsLimit)
            ->get();

        $gallerySection = $sections->firstWhere('section_key', 'gallery');
        $galleryLimit   = $gallerySection?->display_limit ?? 8;
        $galleryImages  = GalleryImage::where('is_visible', true)
            ->orderBy('sort_order')
            ->limit($galleryLimit)
            ->get();

        return view('home', compact(
            'sections',
            'storeDrawResult',
            'onlineDrawResult',
            'posts',
            'galleryImages'
        ));
    }
}
