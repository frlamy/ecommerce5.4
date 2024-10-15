<?php

namespace App\Controller\Front;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/p{id}.html", name="product_view")
     */
    public function viewAction(int $id): Response
    {
        $product = $this->em->getRepository(Product::class)->findOneBy(['id' => $id]);

        if (!$product) {
            $this->createNotFoundException("This product does not exist");
        }

        if ($product->getPublishedAt() !== Product::STATUS_PUBLISHED) {
            $this->createNotFoundException("This product is not published");
        }

        return $this->render('@template/product/view.html.twig', [
            'p' => $product,
            'level' => 'lg',
            'header' => 'h1',
        ]);
    }

}
