# Phinx Csv Seeder

[![Build Status](https://travis-ci.org/BackEndTea/Phinx-CSV-Seeder.svg?branch=master)](https://travis-ci.org/BackEndTea/Phinx-CSV-Seeder)

## Instalation

```bash
$ composer require backendtea/phinx-csv-seeder
```

## Requirements

* PHP 5.6 or higher
* robmorgan/phinx version 0.8.1 or higher

## Usage

Basic usage: 
```php
<?php

use BackEndTea\MigrationHelper\CsvSeeder;

class UserSeeder extends CsvSeeder
{
    protected $csvHeaders = ['header'];

    public function run()
    {
        $this->insertCsv('users', __DIR__ . '/users.csv');
    }
}
```
Will try and insert all csv records into the given table. The keys in the csv file are required
to match the keys in the database. Any values for a row not specified become their defaults.

