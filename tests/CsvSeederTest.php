<?php

namespace BackEndTea\MigrationHelper\Test;

use BackEndTea\MigrationHelper\FileNotFoundException;
use PDO;
use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;

class CsvSeederTest extends \PHPUnit\Framework\TestCase
{
    private $serverName = 'localhost';
    private $dbName = 'phinx_test';
    private $username = 'root';

    public function setUp()
    {
        $phinx = new PhinxApplication();
        $input = new ArgvInput(['phinx', 'migrate', '--environment=development']);
        $output = new NullOutput();
        $phinx->doRun($input,$output);
    }

    public function tearDown()
    {
        $phinx = new PhinxApplication();
        $input = new ArgvInput(['phinx', 'rollback', '--environment=development']);
        $output = new NullOutput();
        $phinx->doRun($input,$output);
    }

    public function testItThrowsFileErrorWhenFileDoesNotExist()
    {
        $phinx = new PhinxApplication();
        $input = new ArgvInput(['phinx', 'seed:run', '-s WrongFileSeeder']);
        $output = new BufferedOutput();

        $this->expectException(FileNotFoundException::class);
        $phinx->doRun($input, $output);
    }

    public function testItWorksWhenNoMappingIsSupplied()
    {
        $phinx = new PhinxApplication();
        $input = new ArgvInput(['phinx', 'seed:run', '-s NoMappingSeeder']);
        $output = new BufferedOutput();

        $phinx->doRun($input, $output);
        $this->assertNotContains('error', $output->fetch());

        //Now we check the database
        $conn = new PDO("mysql:host=".$this->serverName.";dbname=". $this->dbName, $this->username);
        $result =$conn->query('SELECT * FROM users;');
        $result = $result->fetchAll();
        $this->assertSame('1', $result[0]['id']);
        $this->assertSame('jan', $result[0]['name']);
        $this->assertSame('jan@example.com', $result[0]['email']);
        $this->assertSame('2', $result[1]['id']);
        $this->assertSame('henk', $result[1]['name']);
        $this->assertSame('henk@example.com', $result[1]['email']);

        //Assert the headers did not get added
        $this->assertFalse(isset($result[2]));
    }

    public function testItWorksWithGzippedFile()
    {
        $phinx = new PhinxApplication();
        $input = new ArgvInput(['phinx', 'seed:run', '-s GzippedSeeder']);
        $output = new BufferedOutput();

        $phinx->doRun($input, $output);
        $this->assertNotContains('error', $output->fetch());

        //Now we check the database
        $conn = new PDO("mysql:host=".$this->serverName.";dbname=". $this->dbName, $this->username);
        $result =$conn->query('SELECT * FROM users;');
        $result = $result->fetchAll();
        $this->assertSame('1', $result[0]['id']);
        $this->assertSame('jan', $result[0]['name']);
        $this->assertSame('jan@example.com', $result[0]['email']);
        $this->assertSame('2', $result[1]['id']);
        $this->assertSame('henk', $result[1]['name']);
        $this->assertSame('henk@example.com', $result[1]['email']);

        //Assert the headers did not get added
        $this->assertFalse(isset($result[2]));
    }
}