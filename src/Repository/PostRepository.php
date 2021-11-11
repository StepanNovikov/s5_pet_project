<?php

namespace App\Repository;

use App\Entity\Post;
use App\Repository\RepositoryInterface\PostRepositoryInterface;
use App\Service\FileManagerServiceInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    private $entityManager;
    private $fileManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager,
                                FileManagerServiceInterface $fileManagerService)
    {
        $this->entityManager = $manager;
        $this->fileManager = $fileManagerService;
        parent::__construct($registry, Post::class);
    }

    public function getAllPost(): array
    {
        return parent::findAll();
    }

    public function getOnePost(int $postId): object
    {
        return parent::find($postId);
    }

    public function setCreatePost(Post $post, UploadedFile $file): object
    {
        if($file) {
            $fileName = $this->fileManager->imagePostUpload($file);
            $post->setImage($fileName);
        }
        $post->setCreateAtValue();
        $post->setUpdateAtValue();
        $post->setIsPublished();
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        return $post;
    }

    public function setUpdatePost(Post $post, UploadedFile $file): object
    {
        $fileName = $post->get('image');
        if($file) {
            if($fileName) {
                $this->fileManager->removePostImage($fileName);
            }
            $fileName = $this->fileManager->imagePostUpload($file);
            $post->setImage($fileName);
        }
        $post->setUpdateAtValue();
        $this->entityManager->flush();
    }

    public function setDeletePost(Post $post)
    {
        $fileName = $post->getImage();
        if ($fileName) {
            $this->fileManager->removePostImage($fileName);
        }
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }


}
