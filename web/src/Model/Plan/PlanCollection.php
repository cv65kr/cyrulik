<?php

declare(strict_types=1);

namespace App\Model\Plan;

use Doctrine\Common\Collections\ArrayCollection;

final class PlanCollection extends ArrayCollection
{
    public function addItem(PlanItem $element): bool
    {
        return parent::add($element);
    }
}