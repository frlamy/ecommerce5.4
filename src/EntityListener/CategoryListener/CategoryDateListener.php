<?php

namespace App\EntityListener\CategoryListener;

use App\Entity\Category;

class CategoryDateListener
{
    public function prePersist(Category $entity)
    {
        if ($entity->getCreatedAt() === null) {
            $entity->setCreatedAt(new \DateTimeImmutable());
        }

        // Update date at every save
        $entity->setUpdatedAt(new \DateTimeImmutable());
    }
}
