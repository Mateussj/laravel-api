<?php

namespace App\Repositories\Posts;

interface PostsRepositoryInterface {
    public function create(array $data);
    public function find($id);
    public function findAll($perPage = 10);
    public function update($user, array $data);
    public function delete($userId);
}