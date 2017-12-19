<?php

namespace BackEndTea\MigrationHelper\Test;

use BackEndTea\MigrationHelper\FileException;
use BackEndTea\MigrationHelper\FileNotFoundException;

class FileNotFoundExceptionTest extends \PHPUnit\Framework\TestCase
{

    public function testIsInstanceOfFileException()
    {
        $exception = new FileNotFoundException();
        $this->assertInstanceOf(FileException::class, $exception);
    }

}