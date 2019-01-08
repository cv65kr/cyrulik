<?php

declare(strict_types=1);

namespace App\Model;

final class PricingOrder
{
    private $choices = [
        0 => 'Monthly payment',
        1 => 'Yearly payment',
    ];

    /** @var int */
    private $mode = 0;

    /**
     * @return int
     */
    public function getMode(): int
    {
        return $this->mode;
    }

    /**
     * @param int $mode
     */
    public function setMode(int $mode): void
    {
        $this->mode = $mode;
    }

    /**
     * @return array
     */
    public function getChoices(): array
    {
        return $this->choices;
    }
}