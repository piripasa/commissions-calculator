<?php

namespace App\Services\Readers;

class FileReader extends Reader
{
    /**
     * FileReader constructor.
     * @param string $filePath
     * @throws \Exception
     */
    function __construct(string $filePath)
    {
        parent::__construct($filePath);
    }

    public function read()
    {
        $data = [];
        $file = new \SplFileObject($this->getFilePath());
        while (!$file->eof()) {
            $data[] = json_decode($file->fgets(), true);
        }

        $this->setData($data);
    }

    public function getData()
    {
        return array_filter($this->data);
    }
}