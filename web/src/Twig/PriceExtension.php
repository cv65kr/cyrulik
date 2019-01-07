<?php

declare(strict_types=1);

namespace App\Twig;

use App\Helper\PriceHelper;
use Twig_Extension;
use Twig_SimpleFilter;

final class PriceExtension extends Twig_Extension
{
    /** @var PriceHelper */
    private $priceHelper;

    /**
     * PriceExtension constructor.
     */
    public function __construct(PriceHelper $priceHelper)
    {
        $this->priceHelper = $priceHelper;
    }

    public function getFilters(): array
    {
        return [
            'price' => new Twig_SimpleFilter('price', [$this, 'convertPrice']),
        ];
    }

    public function convertPrice(int $price): float
    {
        return $this->priceHelper->convertToHumanPrice($price);
    }
}
