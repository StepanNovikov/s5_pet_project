<?php


namespace App\Service\User;


use App\Entity\User;
use App\Repository\RepositoryInterface\UserRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private $userRepository;
    private $passwordEncoder;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserRepositoryInterface $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function handleCreate(User $user)
    {
        $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        $user->setRoles(["ROLE_ADMIN"]);
        $this->userRepository->setCreate($user);

        return $this;
    }

    public function handleUpdate(User $user)
    {
        $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        $this->userRepository->setSave($user);

        return $this;
    }
}