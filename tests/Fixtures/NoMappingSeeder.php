<?php

use BackEndTea\MigrationHelper\CsvSeeder;

class NoMappingSeeder extends CsvSeeder
{

    public function run()
    {
        $this->insertCsv('users', __DIR__ . '/nomap.csv');
    }
}