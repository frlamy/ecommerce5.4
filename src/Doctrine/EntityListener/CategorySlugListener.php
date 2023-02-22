<?php

namespace App\Doctrine\EntityListener;

use App\Entity\Category;
use Cocur\Slugify\Slugify;

class CategorySlugListener
{
    protected $slugger;

    public function __construct(Slugify $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Category $entity): void
    {
        if (empty($entity->getSlug())) {
            $entity->setSlug($this->slugger->slugify($entity->getName()));
        }
    }

}
