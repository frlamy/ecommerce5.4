<?php

namespace App\EntityListener\ProductListener;

use App\Entity\Product;

class ProductDateListener
{
    public function prePersist(Product $entity): void
    {
        if ($entity->getCreatedAt() === null) {
            $entity->setCreatedAt(new \DateTimeImmutable());

            // Update date at every save
            $entity->setUpdatedAt(new \DateTimeImmutable());
        }
    }

    public function preUpdate(Product $entity)
    {
        // Update date at every save
        $entity->setUpdatedAt(new \DateTimeImmutable());

        if ($entity->getStatus() === Product::STATUS_PUBLISHED && $entity->getPublishedAt() === null) {
            $entity->setPublishedAt(new \DateTimeImmutable());
        }
    }
}
