<?php

namespace App\Helper;

use App\Repository\CategoryRepository;
use Symfony\Component\Routing\RouterInterface;

class MenuBuilderHelper
{
    /** @var CategoryRepository */
    protected $categoryRepository;

    /** @var RouterInterface */
    protected $router;

    public function __construct(CategoryRepository $categoryRepository, RouterInterface $router)
    {
        $this->categoryRepository = $categoryRepository;
        $this->router = $router;
    }

    public function getHeaderNavigation()
    {
        $items = [];

        // Get all categories to display on navbar
        $menuItems = $this->getCategoriesForNav();

        // Todo menu déroulant pour les catégories dans un array d'items, ensuite des items spécifiques pour les autres liens à construire.
        // Regarder sur les autres sites pour s'inspirer des fonctionnalités.

        return [
            'homepage_link' => [
                'url' => $this->router->generate('homepage'),
                'name' => 'E-CO-5.4',
            ],
            'about_link' => [
                'url' => $this->router->generate('static.about'),
                'name' => 'À propos',
                'type' => 'item',
            ],
            'help_link' => [
                'url' => $this->router->generate('static.help'),
                'name' => 'Aide',
                'type' => 'item',
            ],
            'categories_link' => $menuItems,
            'login_link' => [] // Todo
        ];
    }

    private function getCategoriesForNav(): array
    {
        $menuItems = [];

        foreach ($this->categoryRepository->findCategoriesForMenuField() as $category) {
            $menuItems[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'url' => $this->router->generate('category.view',
                    ['slug' => $category->getSlug(), 'id' => $category->getId()]
                ),
            ];
        }

        return $menuItems;
    }
}
