<?php
namespace App\Services\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

abstract class Provider
{
    protected $client;
    protected $baseUri;
    protected $headers;
    protected $uri;
    protected $method;
    protected $data;

    const METHOD_GET = 'GET';

    public function __construct(Client $client, string $baseUri, array $headers = [])
    {
        $this->setClient($client);
        $this->setBaseUri($baseUri);
        $this->setHeaders($headers);
        $this->setMethod(self::METHOD_GET);
    }

    /**
     * @param string $baseUri
     */
    public function setBaseUri(string $baseUri)
    {
        $this->baseUri = $baseUri;
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        $this->makeRequest();
        return $this->data;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param string $uri
     * @throws \Exception
     */
    public function setUri(string $uri)
    {
        if (!$uri) {
            $this->throwException('URI is required.');
        }
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function getUri() : string
    {
        return (string)$this->uri;
    }

    /**
     * @param string $method
     * @throws \Exception
     */
    public function setMethod(string $method)
    {
        if (!in_array($method, [self::METHOD_GET])) {
            $this->throwException('Invalid method.');
        }
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod() : string
    {
        return $this->method;
    }

    private function makeRequest()
    {
        try {
            $response = $this->getClient()->request($this->getMethod(), $this->getRequestUri(), $this->getRequestOptions());
            $body = $response->getBody();
            $this->setData($body->getContents());
        } catch (ClientException $e) {
            if (401 === $e->getCode()) {
                $this->throwException('Unauthorized.', $e->getCode());
            } elseif (404 === $e->getCode()) {
                $this->throwException('Resource not found.', $e->getCode());
            } else {
                $this->throwException('Failed to get data.');
            }
        }
    }

    /**
     * @return array
     */
    public abstract function getTransformed() : array;

    /**
     * @return string
     */
    public function getRequestUri()
    {
        return sprintf("%s%s", $this->getBaseUri(), $this->getUri());
    }

    /**
     * @return array
     */
    public function getRequestOptions() : array
    {
        return [
            'headers' => $this->getHeaders()
        ];
    }

    /**
     * @param $message
     * @param int $code
     * @throws \Exception
     */
    public function throwException($message, $code = 400)
    {
        throw new \Exception($message, $code);
    }
}