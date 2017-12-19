<?php

use BackEndTea\MigrationHelper\CsvSeeder;

class GzippedSeeder extends CsvSeeder
{

    public function run()
    {
        $this->insertCsv('users', __DIR__ . '/nomap.csv.gz');
    }

}