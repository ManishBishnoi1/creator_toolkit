<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Modules\Blog\Repositories\PostRepositoryInterface;
use App\Core\Services\SEOService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function __construct(
        protected PostRepositoryInterface $postRepository,
        protected SEOService $seoService
    ) {}

    /**
     * Display a listing of the blog posts.
     */
    public function index(Request $request): View
    {
        $searchQuery = $request->input('q');

        if (!empty($searchQuery)) {
            $posts = Post::query()
                ->whereNotNull('published_at')
                ->where(function ($query) use ($searchQuery) {
                    $query->where('title', 'like', "%{$searchQuery}%")
                          ->orWhere('content', 'like', "%{$searchQuery}%");
                })
                ->latest('published_at')
                ->paginate(9)
                ->appends(['q' => $searchQuery]);
        } else {
            $posts = $this->postRepository->getPaginated(9);
        }

        // Set page SEO metadata
        $this->seoService
            ->setTitle('Blog - Instagram Downloader Guides & Social Media Tips')
            ->setDescription('Read our latest articles on how to download Instagram Reels, save stories anonymously, convert videos to MP4, and grow your creator profile in 2026.')
            ->setKeywords(['instagram downloader blog', 'reels downloader guide', 'save instagram reels', 'how to download stories'])
            ->setBreadcrumbs([
                'Home' => '/',
                'Blog' => '/blog'
            ]);

        return view('frontend.blog.index', compact('posts', 'searchQuery'));
    }

    /**
     * Display the specified blog post.
     */
    public function show(string $slug): View
    {
        $post = $this->postRepository->findBySlug($slug);

        if (!$post) {
            abort(404, 'Article not found');
        }

        // Fetch recent posts for sidebar (excluding current post)
        $recentPosts = Post::query()
            ->where('id', '!=', $post->id)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->limit(5)
            ->get();

        // Configure Page SEO
        $seoTitle = $post->seo_title ?: $post->title;
        $seoDesc = $post->seo_description ?: Str::limit(strip_tags($post->content), 155);
        
        $this->seoService
            ->setTitle($seoTitle)
            ->setDescription($seoDesc)
            ->setKeywords(array_map('trim', explode(' ', strtolower($post->title))))
            ->setBreadcrumbs([
                'Home' => '/',
                'Blog' => '/blog',
                $post->title => '/blog/' . $post->slug
            ]);

        return view('frontend.blog.show', compact('post', 'recentPosts'));
    }
}
