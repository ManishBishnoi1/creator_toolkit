<?php

namespace App\Modules\Blog\Repositories;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface PostRepositoryInterface
{
    /**
     * Get paginated list of blog posts.
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator;

    /**
     * Find post by slug.
     */
    public function findBySlug(string $slug): ?Post;

    /**
     * Get related posts by category.
     */
    public function getRelated(Post $post, int $limit = 3): Collection;

    /**
     * Create a new blog post.
     */
    public function create(array $data): Post;

    /**
     * Update an existing blog post.
     */
    public function update(Post $post, array $data): bool;

    /**
     * Delete a blog post.
     */
    public function delete(Post $post): bool;
}
