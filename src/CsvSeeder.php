<?php

namespace BackEndTea\MigrationHelper;

use Phinx\Seed\AbstractSeed;

abstract class CsvSeeder extends AbstractSeed
{
    /**
     * Delimiter of the csv file, defaults to ','
     *
     * @var string
     */
    public $csvDelimiter = ',';

    /**
     * Row to start from
     *
     * @var int
     */
    public $offSetRows = 0;

    /**
     * @var string
     */
    private $fileName;

    public function insertCsv($table, $filename)
    {
        $this->fileName = $filename;
        $toInsert = $this->seedFromCSV();
        $this->insert($table, $toInsert);
    }

    private function seedFromCSV()
    {
        $handle = $this->getFile();
        $data = [];
        ini_set('auto_detect_line_endings', 1);
        while (($csvRows = fgetcsv($handle, 0, $this->csvDelimiter))  !== false) {
            $data[]  = $csvRows;
        }
        $mapping = $data[0];
        fclose($handle);

        return $this->buildToInsertArray($data, $mapping);
    }

    /**
     * @return resource
     *
     * @throws FileException
     */
    private function getFile()
    {
        $this->checkFileIsUsable();

        $handle = $this->isGzipped() ? gzopen($this->fileName, 'r') : fopen($this->fileName, 'r');
        if ($handle === false) {
            throw new FileException('Error while opening file ' . $this->fileName);
        }
        return $handle;
    }

    /**
     * @throws FileException
     */
    private function checkFileIsUsable()
    {
        if (!file_exists($this->fileName))
        {
            throw FileNotFoundException::fileNotFound($this->fileName);
        }

        if (!is_readable($this->fileName))
        {
            throw FileNotReadableException::fileNotReadable($this->fileName);
        }
    }



    /**
     * Check if the file is gzipped,
     *
     * @return bool
     */
    private function isGzipped()
    {
        // check if file is gzipped
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_mime_type = finfo_file($finfo, $this->fileName);
        finfo_close($finfo);
        $gzipped = strcmp($file_mime_type, "application/x-gzip") == 0;

        return $gzipped;
    }

    /**
     * Build up array to insert into database
     *
     * @param array $csvRows
     * @param array $mapping
     * @return array
     */
    private function buildToInsertArray($csvRows, $mapping)
    {
        $toBuild = [];
        $offset =  1 ;
        for ($i = $offset; $i < count($csvRows); $i++) {
            $temp = [];
            foreach ($mapping as $key => $value) {
                $temp[$value] = $csvRows[$i][$key];
            }
            $toBuild[] = $temp;
        }

        return $toBuild;
    }






}