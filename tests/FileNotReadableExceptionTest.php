<?php

namespace BackEndTea\MigrationHelper\Test;

use BackEndTea\MigrationHelper\FileException;
use BackEndTea\MigrationHelper\FileNotReadableException;

class FileNotReadableExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testItExtendsFileException()
    {
        $exception = new FileNotReadableException();
        $this->assertInstanceOf(FileException::class, $exception);
    }
}