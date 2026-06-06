<?php

namespace App\Modules\Blog\Actions;

use App\Models\Post;
use App\Modules\Blog\Repositories\PostRepositoryInterface;
use Illuminate\Support\Str;

class UpdatePostAction
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    /**
     * Execute post update with dynamic slug regeneration and SEO fallback checks.
     */
    public function execute(Post $post, array $data): bool
    {
        if (isset($data['title']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (isset($data['title']) && empty($data['seo_title'])) {
            $data['seo_title'] = $data['title'];
        }

        if (isset($data['content']) && empty($data['seo_description'])) {
            $data['seo_description'] = Str::limit(strip_tags($data['content']), 155);
        }

        return $this->postRepository->update($post, $data);
    }
}
