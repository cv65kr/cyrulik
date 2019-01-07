<?php

declare(strict_types=1);

namespace App\Model\Plan;

final class PlanItem
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var int */
    private $pricePerMonth;

    /** @var int */
    private $pricePerYear = 0;

    /**
     * PlanItem constructor.
     */
    private function __construct(
        string $id,
        string $name,
        int $pricePerMonth,
        int $pricePerYear
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->pricePerMonth = $pricePerMonth;
        $this->pricePerYear = $pricePerYear;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            (string) $data['id'],
            (string) $data['name'],
            (int) $data['pricePerMonth'],
            (int) $data['pricePerYear']
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPricePerMonth(): int
    {
        return $this->pricePerMonth;
    }

    public function setPricePerMonth(int $pricePerMonth): void
    {
        $this->pricePerMonth = $pricePerMonth;
    }

    public function getPricePerYear(): int
    {
        return $this->pricePerYear;
    }

    public function setPricePerYear(int $pricePerYear): void
    {
        $this->pricePerYear = $pricePerYear;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'pricePerMonth' => $this->getPricePerMonth(),
            'pricePerYear' => $this->getPricePerYear(),
        ];
    }
}
