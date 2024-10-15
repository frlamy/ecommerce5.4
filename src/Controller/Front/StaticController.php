<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends AbstractController
{
    /**
     * @Route("/about", name="static.about")
     */
    public function aboutAction(): Response
    {
        return $this->render('static/about.html.twig', [
            'controller_name' => 'StaticController',
        ]);
    }

    /**
     * @Route("/help", name="static.help")
     */
    public function helpAction(): Response
    {
        return $this->render('static/help.html.twig', [
            'controller_name' => 'StaticController',
        ]);
    }
}
