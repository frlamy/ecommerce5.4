<?php

namespace App\Controller\Admin;

use App\Entity\Product;
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

    /** @var SluggerInterface */
    private $slugger;

    public function __construct(EntityManagerInterface $em, SluggerInterface $slugger) {
        $this->em = $em;
        $this->slugger = $slugger;
    }

    /**
     * @Route("/index", name="admin.product.index")
     */
    public function index(): Response
    {
        // TODO PAGINATED CONTENT
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
            // TODO : listener date et slug
            $product->setSlug($this->slugger->slug($product->getName()));
            $product->setCreatedAt(new \DateTimeImmutable());
            $product->setUpdatedAt(new \DateTimeImmutable());

            $this->em->persist($product);
            $this->em->flush();

            return $this->redirectToRoute('admin.product.edit', ['id' => $product->getId()]);
        }

        return $this->render('/admin/product/form.html.twig', [
            'formView' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{slug}-p{id}", name="admin.product.edit", requirements={"slug": "[a-z0-9\-]+", "id":"\d+"})
     */
    public function editAction(int $id): Response
    {
        $product = $this->em->getRepository(Product::class)->find($id);

        if (null === $product) {
            return $this->redirectToRoute('admin.category.index');
        }

        dd('stop');
        //todo

        $form = $this->createForm(ProductType::class, $product);

        return $this->render('/admin/product/update.html.twig', [
            'formView' => $form->createView(),
        ]);
    }
}
