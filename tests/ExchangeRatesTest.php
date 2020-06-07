<?php
namespace Tests;

use App\Services\Providers\ExchangeRates;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;


class ExchangeRatesTest extends TestCase
{
    protected $mockFile;
    protected $mockBaseUri;

    protected function setUp()
    {
        parent::setUp();
        $this->mockFile = dirname(__DIR__).'/tests/data/exchangeratesapi.json';
        $this->mockBaseUri = 'http://mocked.exchangeratesapi.xyz/';
    }

    public function testInputFileExist()
    {
        $this->assertFileExists($this->mockFile);
    }

    public function testShouldThrowExceptionForEmptyUriArgument()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('URI is required.');
        $this->expectExceptionCode(400);

        $mockObj = $this->makeMock(400);

        $mockObj->setUri('');
        $mockObj->getData();
    }

    public function testShouldThrowExceptionForInvalidUriArgument()
    {
        $uri = 'INVALID';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Failed to get data.');
        $this->expectExceptionCode(400);

        $mockObj = $this->makeMock(400);

        $mockObj->setUri($uri);
        $mockObj->getData();
    }

    public function testShouldThrowExceptionForUnauthorized()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unauthorized.');
        $this->expectExceptionCode(401);

        $mockObj = $this->makeMock(401);

        $mockObj->getData();
    }

    public function testShouldReturnData()
    {
        $body = file_get_contents($this->mockFile);

        $mockObj = $this->makeMock(200, $body);

        $mockObj->setUri('latest');

        $this->assertEquals($body, $mockObj->getData());
    }

    public function testShouldReturnTransformedData()
    {
        $body = file_get_contents($this->mockFile);

        $mockObj = $this->makeMock(200, $body);

        $mockObj->setUri('latest');

        $this->assertArrayHasKey('CAD', $mockObj->getTransformed());
    }

    public function testMethodShouldValid()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid method.');
        $this->expectExceptionCode(400);

        $mockObj = $this->makeMock(400);

        $mockObj->setMethod('Invalid');
        $mockObj->getData();
    }

    private function makeMock($status, $body = null)
    {
        $mock = new MockHandler([new Response($status, [], $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return new ExchangeRates($client, $this->mockBaseUri);
    }

}