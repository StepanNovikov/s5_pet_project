<?php


namespace App\Controller\Admin;


use App\Entity\Post;
use App\Form\PostType;
use App\Repository\RepositoryInterface\CategoryRepositoryInterface;
use App\Repository\RepositoryInterface\PostRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostController extends AdminBaseController
{
    private $categoryRepository;
    private $postRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository, PostRepositoryInterface $postRepository) {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * @Route("/admin/post", name="admin_post")
     */
    public function index()
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Посты';
        $forRender['post'] = $this->postRepository->getAllPost();
        $forRender['check_category'] = $this->categoryRepository->getAllCategory();
        return $this->render('admin/post/index.html.twig',$forRender);
    }

    /**
     * @Route("/admin/post/create", name="admin_post_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $file= $form->get('image')->getData();
            $this->postRepository->setCreatePost($post,$file);

            $this->addFlash('success','Пост успешно добавлен');

            return $this->redirectToRoute('admin_post');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Посты';
        $forRender['form'] = $form->createView();
        return $this->render('admin/post/form.html.twig',$forRender);
    }

    /**
     * @Route("/admin/post/update/{id}",name="admin_post_update")
     * @param int $id
     * @param Request $request
     */
    public function update(int $id, Request $request)
    {
        $post = $this->postRepository->getOnePost($id);
        $form = $this->createForm(PostType::class,$post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if($form->get('save')->isClicked()) {
                $file = $form->get('image')->getData();
                $this->postRepository->setUpdatePost($post,$file);
                $this->addFlash('success','Поста обновлен');
            }
            if($form->get('delete')->isClicked()) {
                $this->postRepository->setDeletePost($post);
                $this->addFlash('success','Пост удален');
            }
            return $this->redirectToRoute('admin_post');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Редактирование поста';
        $forRender['form'] = $form->createView();
        return $this->render('admin/post/form.html.twig',$forRender);
    }
}