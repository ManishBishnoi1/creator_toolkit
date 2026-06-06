<?php

namespace App\Modules\Blog\Actions;

use App\Models\Post;
use App\Modules\Blog\Repositories\PostRepositoryInterface;
use Illuminate\Support\Str;

class CreatePostAction
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    /**
     * Execute post creation with custom slug handling and SEO defaults.
     */
    public function execute(array $data): Post
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Set fallback SEO tags if not explicitly provided
        if (empty($data['seo_title'])) {
            $data['seo_title'] = $data['title'];
        }

        if (empty($data['seo_description']) && !empty($data['content'])) {
            $data['seo_description'] = Str::limit(strip_tags($data['content']), 155);
        }

        return $this->postRepository->create($data);
    }
}
