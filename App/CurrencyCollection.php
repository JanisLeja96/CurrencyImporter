<?php

namespace App;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;

class CurrencyCollection
{
    private array $currencies = [];

    public function add(Currency $currency)
    {
        $this->currencies[] = $currency;
    }

    public function get(): array
    {
        return $this->currencies;
    }
}