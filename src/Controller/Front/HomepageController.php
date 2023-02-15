<?php

namespace App\Controller\Front;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    protected $logger;

    protected $manager;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $manager)
    {
        $this->logger = $logger;
        $this->manager = $manager;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function homepage(): Response
    {
        $products = $this->manager->getRepository(Product::class)->findBy([], ['updatedAt' => 'DESC'], 3);

        return $this->render('front/homepage/view.html.twig', [
            'products' => $products
        ]);
    }
}
