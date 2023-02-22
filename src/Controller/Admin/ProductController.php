<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Form\ProductType;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/create", name="admin_product_create")
     */
    public function createAction(Request $request): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var Product $product */
            $product = $form->getData();
            $product
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
            ;
        }

        return $this->render('admin/product/create.html.twig', [
            'formView' => $form->createView(),
        ]);
    }
}
