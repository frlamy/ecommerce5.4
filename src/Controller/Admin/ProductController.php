<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("admin/product")
 */
class ProductController extends AbstractController
{
    /** @var EntityManagerInterface  */
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @Route("/index", name="admin.product.index")
     */
    public function index(): Response
    {
        // TODO PAGINATED CONTENT //
        $products = $this->em->getRepository(Product::class)->findAll();

        return $this->render('admin/product/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/create", name="admin.product.create")
     */
    public function createAction(Request $request): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($product);
            $this->em->flush();

            $this->addFlash('success', 'Le produit '. $product->getName() .' a bien été créé');

            return $this->redirectToRoute('admin.product.edit', ['id' => $product->getId(), 'slug' => $product->getSlug()]);
        }

        return $this->render('/admin/product/form.html.twig', [
            'formView' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{slug}-p{id}", name="admin.product.edit", requirements={"slug": "[a-z0-9\-]+", "id":"\d+"})
     */
    public function editAction(int $id, Request $request): Response
    {
        $product = $this->em->getRepository(Product::class)->find($id);

        if (null === $product) {
            return $this->redirectToRoute('admin.category.index');
        }

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', 'Le produit '. $product->getName() .' a bien été modifié');
            return $this->redirectToRoute('admin.product.index');
        }

        return $this->render('/admin/product/form.html.twig', [
            'formView' => $form->createView(),
            'product' => $product
        ]);
    }
}
