<?php

use BackEndTea\MigrationHelper\CsvSeeder;

class WrongFileSeeder extends CsvSeeder
{

    public function run()
    {
        $this->insertCsv('users', __DIR__ . 'fake.csv');
    }

}