<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    /** @var EntityManagerInterface  */
    private $em;

    /** @var SluggerInterface */
    private $slugger;

    public function __construct(EntityManagerInterface $em, SluggerInterface $slugger) {
        $this->em = $em;
        $this->slugger = $slugger;
    }

    /**
     * @Route("/list", name="admin.product.list")
     */
    public function index(): Response
    {
        $products = $this->em->getRepository(Product::class)->findAll();

        return $this->render('admin/product/list.html.twig', [
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
            // TODO : listener date et slug
            $product->setSlug($this->slugger->slug($product->getName()));
            $product->setCreatedAt(new \DateTimeImmutable());
            $product->setUpdatedAt(new \DateTimeImmutable());

            $this->em->persist($product);
            $this->em->flush();

            return $this->redirectToRoute('admin.product.update', ['id' => $product->getId()]);
        }

        return $this->render('/admin/product/create.html.twig', [
            'formView' => $form->createView(),
        ]);
    }

    /**
     * @Route("/update/c-{id}", name="admin.product.update", requirements={"id":"\d+"})
     */
    public function updateAction(int $id): Response
    {
        $product = $this->em->getRepository(Product::class)->find($id);

        dd('stop');
        //todo
        $form = $this->createForm(ProductType::class, $product);
        return $this->render('/admin/product/update.html.twig', [
            'formView' => $form->createView(),
        ]);
    }
}
