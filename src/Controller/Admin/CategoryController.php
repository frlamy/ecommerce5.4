<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Form\CategoryType;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/category")
 */
class CategoryController extends AbstractController
{
    private $em;

    private $categoryRepository;

    public function __construct(EntityManagerInterface $em, CategoryRepository $categoryRepository)
    {
        $this->em = $em;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * @Route("/create", name="admin_category_create")
     */
    public function createAction(Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var Category $category */
            $category = $form->getData();

            $category
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
            ;

            $this->em->persist($category);

            $this->em->flush();

            return $this->redirectToRoute('admin_category_edit', ['id' => $category->getId()]);

        }

        return $this->render('/admin/category/create.html.twig', [
            'formView' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit-c{id}", name="admin_category_edit")
     */
    public function editAction(int $id, Request $request)
    {
        $category = $this->categoryRepository->findOneBy(['id' => $id]);

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var Category $category */
            $category = $form->getData();

            $category->setUpdatedAt(new \DateTimeImmutable());

            $this->em->flush();

            return $this->redirectToRoute('admin_category_list');
        }

        return $this->render('/admin/category/edit.html.twig', [
                'formView' => $form->createView(),
                'category' => $category,
            ]
        );
    }

    /**
     * @Route("/list", name="admin_category_list")
     */
    public function listAction(Request $request)
    {
        //TODO FILTERS FOR SORTING
        $filters = [];

        $page = (int) $request->query->get('page', 1);

        $paginationData = $this->categoryRepository->getPaginationData(Category::CATEGORY_PER_PAGE, $filters);

        // add the page number to filters, to optimize queries
        $filters['page'] = $page;

        $categories = $this->categoryRepository->getPaginated($page, Category::CATEGORY_PER_PAGE, $filters);

        return $this->render('/admin/category/list.html.twig', [
            'categories' => $categories,
            'totalCategories' => $paginationData['total'],
            'pageCount' => $paginationData['pageCount'],
            'currentPage' => $page
        ]);
    }

}
