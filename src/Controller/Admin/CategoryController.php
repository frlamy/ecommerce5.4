<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/create", name="admin_category_create")
     */
    public function index(): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        return $this->render('/admin/category/create.html.twig', [
            'formView' => $form->createView(),
        ]);
    }
}
