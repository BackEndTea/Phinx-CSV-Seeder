<?php

namespace BackEndTea\MigrationHelper;

class FileNotReadableException extends FileException
{
    public static function fileNotReadable($fileName)
    {
        return new self(\sprintf(
            'File %s is not readable',
            $fileName
        ));
    }
}