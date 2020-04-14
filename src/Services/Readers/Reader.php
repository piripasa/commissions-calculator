<?php

namespace App\Services\Readers;

abstract class Reader
{
    protected $filePath;
    protected $data = [];

    /**
     * Reader constructor.
     * @param string $filePath
     * @throws \Exception
     */
    function __construct(string $filePath)
    {
        $this->setFilePath($filePath);
    }

    /**
     * @param string $filePath
     * @throws \Exception
     */
    public function setFilePath(string $filePath)
    {
        if (!file_exists($filePath)) {
            throw new \Exception('Wrong path');
        }

        $this->filePath = $filePath;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    abstract public function getData();

    abstract public function read();
}