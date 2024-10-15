<?php

namespace App\Controller\Front;

use App\Form\Front\GlobalSearchType;
use App\Helper\MenuBuilderHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainMenuController extends AbstractController
{
    protected $menuBuilder;

    public function __construct(MenuBuilderHelper $menuBuilder)
    {
        $this->menuBuilder = $menuBuilder;
    }

    public function headerAction(): Response
    {
        $navigation = $this->menuBuilder->getHeaderNavigation();

        // Todo Add search form in ajax
//        $searchForm = $this->createForm(GlobalSearchType::class, null, [
//            'method' => 'GET',
//            'action' => $this->generateUrl('ajax_global_search'),
//        ]);

        return $this->render('@template/navbar/organism/navbar.html.twig', [
            'navigation' => $navigation,
        ]);
    }
}
