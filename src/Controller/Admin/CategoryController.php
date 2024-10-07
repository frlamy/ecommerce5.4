<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin/category")
 */
class CategoryController extends AbstractController
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
     * @Route("/index", name="admin.category.index")
     */
    public function index(): Response
    {
        $categories = $this->em->getRepository(Category::class)->findAll();

        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/create", name="admin.category.create")
     */
    public function createAction(Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // TODO : listener date et slug
            $category->setSlug($this->slugger->slug($category->getName()));
            $category->setCreatedAt(new \DateTimeImmutable());
            $category->setUpdatedAt(new \DateTimeImmutable());

            $this->em->persist($category);
            $this->em->flush();

            return $this->redirectToRoute('admin.category.edit', ['id' => $category->getId()]);
        }

        return $this->render('/admin/category/form.html.twig', [
            'formView' => $form->createView(),
        ]);
    }

    /**
     * @Route("/update/{slug}-c{id}", name="admin.category.edit", requirements={"slug": "[a-z0-9\-]+", "id":"\d+"})
     */
    public function editAction(int $id): Response
    {
        $category = $this->em->getRepository(Category::class)->find($id);

        if (null === $category) {
            return $this->redirectToRoute('admin.category.index');
        }

        dd('stop');
        //todo

        $form = $this->createForm(CategoryType::class, $category);

        return $this->render('/admin/category/form.html.twig', [
            'formView' => $form->createView(),
            'category' => $category
        ]);
    }
}
