<?php

namespace App\EntityListener\CategoryListener;

use App\Entity\Category;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategorySlugListener
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Category $entity)
    {
        if (empty($entity->getSlug())) {
            $entity->setSlug($this->slugger->slug($entity->getName())->lower());
        }
    }

}
