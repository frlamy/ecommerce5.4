<?php

namespace App\Controller\Front;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function homepage(): Response
    {
        return $this->render('front/homepage/view.html.twig', [
        ]);
    }
}
