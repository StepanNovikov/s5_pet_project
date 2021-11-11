<?php


namespace App\Repository\RepositoryInterface;


use App\Entity\User;

interface UserRepositoryInterface
{
    /**
     * @param User $user
     * @return mixed
     */
    public function setCreate(User $user);

    /**
     * @param User $user
     * @return mixed
     */
    public function setSave(User $user);


    /**
     * @param int $userId
     * @return object
     */
    public function getOne(int $userId): object;

    /**
     * @return User[]
     */
    public function getAll(): array;
}