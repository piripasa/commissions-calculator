<?php

namespace Tests;

use App\Services\Readers\FileReader;
use PHPUnit\Framework\TestCase;


class FileReaderTest extends TestCase
{
    protected $rootPath;

    protected function setUp()
    {
        parent::setUp();
        $this->rootPath = dirname(__DIR__, 1);
    }

    public function testInputFileExist()
    {
        $this->assertFileExists($this->rootPath . '/input.txt');
    }

    public function testInputFileMissing()
    {
        $this->assertFileNotExists($this->rootPath . '/missing.txt');
    }

    public function testCanReadFile()
    {
        $file = new FileReader($this->rootPath . '/input.txt');
        $file->read();
        $this->assertTrue(is_array($file->getData()));
    }

    public function testFileHasContent()
    {
        $file = new FileReader($this->rootPath . '/input.txt');
        $file->read();
        $this->assertGreaterThan(0, count($file->getData()));
    }

    public function testEmptyFile()
    {
        $file = new FileReader($this->rootPath . '/tests/data/empty.txt');
        $file->read();
        $this->assertEquals(0, count($file->getData()));
    }

    public function testMissingFile()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Wrong path');
        new FileReader($this->rootPath . '/missing.txt');
    }

}