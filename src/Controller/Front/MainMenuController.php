<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainMenuController extends AbstractController
{
    public function headerAction(): Response
    {
        //récupérer les catégories + template
        return $this->render('front/navbar/navbar.html.twig', [
        ]);
    }
}
