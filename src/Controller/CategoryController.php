<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/{slug}-c{id}", name="category_view")
     */
    public function viewAction(string $slug, int $id): Response
    {
        $category = $this->em->getRepository(Category::class)->findOneBy(['id' => $id ]);
        return $this->render('front/category/view.html.twig', [
            'category' => $category
        ]);
    }
}
