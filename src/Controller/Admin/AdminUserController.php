<?php


namespace App\Controller\Admin;


use App\Entity\User;
use App\Form\UserType;
use App\Repository\RepositoryInterface\UserRepositoryInterface;
use App\Service\User\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUserController extends AdminBaseController
{
    private $userRepository;
    private $userService;

    public function __construct(UserRepositoryInterface $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function index()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Пользователи';
        $forRender['users'] = $this->userRepository->getAll();
        return $this->render('admin/user/index.html.twig',$forRender);
    }

    /**
     * @Route("admin/user/create",name="admin_user_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->userService->handleCreate($user);
            $this->addFlash('success', 'Пользователь создан');
            return $this->redirectToRoute('admin_user');
        }

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Форма создания пользователя';
        $forRender['form'] = $form->createView();
        return $this->render('admin/user/form.html.twig',$forRender);
    }

    /**
     * @Route("/admin/user/update/{userId}",name="admin_user_update")
     * @param Request $request
     * @param int $userId
     */
    public function updateAction(Request $request,int $userId)
    {
        $user = $this->userRepository->getOne($userId);
        $formUser = $this->createForm(UserType::class,$user);
        $formUser->handleRequest($request);
        if($formUser->isSubmitted() && $formUser->isValid())
        {
            $this->userService->handleUpdate($user);
            $this->addFlash('success','Данные пользовтеля изменены');
            return $this->redirectToRoute('admin_user');
        }

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Редактирование пользователя';
        $forRender['form'] = $formUser->createView();
        return $this->render('admin/user/form.html.twig',$forRender);
    }
}