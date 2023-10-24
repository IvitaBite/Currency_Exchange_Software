<?php

declare(strict_types=1);

namespace App;

class Currency
{
    private float $rate;
    private string $base;

    public function __construct(float $rate, string $base)
    {
        $this->rate = $rate;
        $this->base = $base;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function getBase(): string
    {
        return $this->base;
    }
}