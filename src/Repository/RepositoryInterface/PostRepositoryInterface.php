<?php


namespace App\Repository\RepositoryInterface;


use App\Entity\Post;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface PostRepositoryInterface
{
    /**
     * @return array
     */
    public function getAllPost(): array;

    /**
     * @param int $postId
     * @return object
     */
    public function getOnePost(int $postId): object;

    /**
     * @param Post $post
     * @param UploadedFile $file
     * @return object
     */
    public function setCreatePost(Post $post, UploadedFile $file): object;

    /**
     * @param Post $post
     * @param UploadedFile $file
     * @return object
     */
    public function setUpdatePost(Post $post, UploadedFile $file): object;

    /**
     * @param Post $post
     * @return mixed
     */
    public function setDeletePost(Post $post);
}