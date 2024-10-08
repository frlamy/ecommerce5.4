<?php

namespace App\EntityListener\ProductListener;

use App\Entity\Product;

class ProductDateListener
{
    public function prePersist(Product $entity)
    {
        if ($entity->getCreatedAt() === null) {
            $entity->setCreatedAt(new \DateTimeImmutable());
        }

        // Update date at every save
        $entity->setUpdatedAt(new \DateTimeImmutable());
    }
}
