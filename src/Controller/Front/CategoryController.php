<?php

namespace App\Controller\Front;

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
     * @Route("/{slug}-c{id}.html", name="category.view")
     */
    public function viewAction(int $id): Response
    {
        $category = $this->em->getRepository(Category::class)->findOneBy(['id' => $id ]);

        return $this->render('@template/category/view.html.twig', [
            'category' => $category,
            'level' => 'sm',
            'header' => 'h5',
        ]);
    }

    /**
     * @Route("/toutes-nos-catégories.html", name="category.list") Response
     */
    public function listAction(): Response
    {
        // Todo query à la mano pour meilleure sélection. Tri par popularité ie.
        $categories = $this->em->getRepository(Category::class)->findAll();

        return $this->render('@template/category/list.html.twig', [
            'categories' => $categories,
        ]);
    }
}
