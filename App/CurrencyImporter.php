<?php

namespace App;

use Sabre\Xml\Service;

class CurrencyImporter
{
    private CurrencyCollection $currencyCollection;
    private array $data;

    public function __construct()
    {
        $this->currencyCollection = new CurrencyCollection();
        $this->data = $this->getRawData();
    }

    public function getRawData()
    {
        $service = new Service();
        $result = $service->parse(file_get_contents('https://www.bank.lv/vk/ecb.xml'));
        return $result;
    }

    public function parse()
    {
        foreach ($this->data[1]['value'] as $currency) {
            $this->currencyCollection->add(new Currency(
                $currency['value'][0]['value'],
                $currency['value'][1]['value']));
        }
    }

    public function getCurrencies(): CurrencyCollection
    {
        return $this->currencyCollection;
    }

    public function saveToDatabase(): void
    {
        foreach ($this->currencyCollection->get() as $currency) {
            $result = $this->findInDatabase($currency->getName());
            if (!$result) {
                $this->insertIntoDatabase($currency);
            } else {
                $this->updateInDatabase($currency);
            }
        }
    }

    private function findInDatabase(string $name)
    {
        return query()->select('*')
            ->from('currencies')
            ->where('name = :name')
            ->setParameter('name', $name)
            ->execute()
            ->fetchAssociative();
    }

    private function insertIntoDatabase(Currency $currency)
    {
        query()->insert('currencies')
            ->values([
                'name' => '?',
                'rate' => '?'
            ])
            ->setParameter(0, $currency->getName())
            ->setParameter(1, $currency->getRate())
            ->execute();
    }

    private function updateInDatabase(Currency $currency)
    {
        query()->update('currencies')
            ->set('currencies.rate', $currency->getRate())
            ->where('name = :name')
            ->setParameter('name', $currency->getName())
            ->execute();
    }

    public static function getFromDatabase(): array
    {
        return query()->select('*')
            ->from('currencies')
            ->execute()
            ->fetchAllAssociative();
    }
}