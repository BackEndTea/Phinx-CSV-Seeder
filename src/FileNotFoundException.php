<?php

namespace BackEndTea\MigrationHelper;

class FileNotFoundException extends FileException
{
    public static function fileNotFound($filename)
    {
        return new self(\sprintf(
            'Unable to find the file: "%s".',
            $filename
        ));
    }
}