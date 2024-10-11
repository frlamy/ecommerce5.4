<?php

namespace App\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class PriceTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        if (null === $value) {
            return null;
        }

        return $value / 100;
    }

    public function reverseTransform($value)
    {
        if (null === $value) {
            return null;
        }

        return $value * 100;
    }
}
