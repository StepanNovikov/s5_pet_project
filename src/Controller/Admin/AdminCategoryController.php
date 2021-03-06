<?php


namespace App\Controller\Admin;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\RepositoryInterface\CategoryRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AdminBaseController
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/admin/category", name="admin_category")
     */
    public function index()
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Категории';
        $forRender['category'] = $this->categoryRepository->getAllCategory();
        return $this->render('admin/category/index.html.twig',$forRender);
    }

    /**
     * @Route("/admin/category/create", name="admin_category_create")
     */
    public function create(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->categoryRepository->setCreateCategory($category);
            $this->addFlash('success','Категория успешно добавлена');

            return $this->redirectToRoute('admin_category');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Категории';
        $forRender['form'] = $form->createView();
        return $this->render('admin/category/form.html.twig',$forRender);
    }

    /**
     * @Route("/admin/category/update/{id}",name="admin_category_update")
     * @param int $id
     * @param Request $request
     */
    public function update(int $id, Request $request)
    {
        $category = $this->categoryRepository->getOneCategory($id);
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if($form->get('save')->isClicked()) {
                $this->categoryRepository->setUpdateCategory($category);
                $this->addFlash('success','Категория обновлена');
            }
            if($form->get('delete')->isClicked()) {
                $this->categoryRepository->setDeleteCategory($category);
                $this->addFlash('success','Категория удалена');
            }
            return $this->redirectToRoute('admin_category');
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Редактирование категории';
        $forRender['form'] = $form->createView();
        return $this->render('admin/category/form.html.twig',$forRender);
    }
}