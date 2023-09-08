<?php 

namespace App\Repositories\Posts;

use App\Models\Posts;
use App\Repositories\Posts\PostsRepositoryInterface;

class PostsRepository implements PostsRepositoryInterface {
    public function create(array $data)
    {
        return Posts::create($data);
    }

    public function find($id)
    {
        return Posts::with('user')->find($id);
    }

    public function findAll($perPage = 10)
    {
        return Posts::with('user')->paginate($perPage);
    }

    public function update($post, array $data)
    {
        return $post->update($data);
    }

    public function delete($postId)
    {
        $post = Posts::find($postId);
        if ($post) {
            $post->delete();
            return true;
        }
        return false;
    }
}
