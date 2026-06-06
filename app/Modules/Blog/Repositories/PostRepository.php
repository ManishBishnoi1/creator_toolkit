<?php

namespace App\Modules\Blog\Repositories;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PostRepository implements PostRepositoryInterface
{
    /**
     * Get paginated list of blog posts.
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Post::query()
            ->latest('published_at')
            ->whereNotNull('published_at')
            ->paginate($perPage);
    }

    /**
     * Find post by slug.
     */
    public function findBySlug(string $slug): ?Post
    {
        return Post::query()
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Get related posts by category.
     */
    public function getRelated(Post $post, int $limit = 3): Collection
    {
        return Post::query()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->whereNotNull('published_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Create a new blog post.
     */
    public function create(array $data): Post
    {
        return Post::create($data);
    }

    /**
     * Update an existing blog post.
     */
    public function update(Post $post, array $data): bool
    {
        return $post->update($data);
    }

    /**
     * Delete a blog post.
     */
    public function delete(Post $post): bool
    {
        return $post->delete();
    }
}
