<?php

namespace App\Taxes;

use RuntimeException;

class TaxCalculator
{
    protected $tva;

    public function __construct(float $tva)
    {
        $this->tva = $tva;
    }

    /**
     * @param float $price
     * @return float
     */
    public function getTva(float $price): float
    {
        return $price * (19/100);
    }

    /**
     * @param float $price
     * @return float
     */
    public function getNetPrice(float $price): float
    {
        $netPrice = $price - $this->getTva($price);

        if ($netPrice <= 0) {
            throw new RuntimeException("Net price can't be less than 0");
        }

        return $netPrice;
    }

}
