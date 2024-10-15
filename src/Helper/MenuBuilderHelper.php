<?php

namespace App\Helper;

use App\Repository\CategoryRepository;

class MenuBuilderHelper
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }
    public function getHeaderNavigation()
    {
        $items = [];

        return $items;
    }

    private function getCategoriesForNav()
    {
        $menuItems = [];

        foreach ($this->categoryRepository->getRootHubsForMenu() as $hub) {
            $menuItems[] = [
                'id' => $hub->getId(),
                'isSecondary' => $hub->isSecondary(),
                'category_class' => $hub->getCategoryClass(),
                'name' => $hub->getName(),
                'url' => $this->router->generate('hub',
                    ['slug' => $hub->getSlug()],
                    $referenceType
                ),
                'countHubs' => count($hub->getChildrenForMenu()),
            ];
        }

        return $menuItems;
        $categories = $this->categoryRepository->findAll();

        foreach ($categories as $category) {

        }
    }
}
