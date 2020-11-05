<?php

use App\Controllers\CurrencyController;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;

require_once 'App/bootstrap.php';

$currencyImporter = new CurrencyController();
$currencyImporter->parse();
$currencyImporter->saveToDatabase();