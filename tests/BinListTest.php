<?php
namespace Tests;

use App\Services\Providers\BinList;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;


class BinListTest extends TestCase
{
    protected $mockFile;
    protected $mockBaseUri;

    protected function setUp()
    {
        parent::setUp();
        $this->mockFile = dirname(__DIR__).'/tests/data/binlist.json';
        $this->mockBaseUri = 'http://mocked.binlist.xyz/';
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
        $mockObj->makeRequest();
    }

    public function testShouldThrowExceptionForInvalidUriArgument()
    {
        $uri = 'INVALID';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Failed to get data.');
        $this->expectExceptionCode(400);

        $mockObj = $this->makeMock(400);

        $mockObj->setUri($uri);
        $mockObj->makeRequest();
    }

    public function testShouldThrowExceptionForUnauthorized()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unauthorized.');
        $this->expectExceptionCode(401);

        $mockObj = $this->makeMock(401);

        $mockObj->makeRequest();
    }

    public function testShouldReturnData()
    {
        $body = file_get_contents($this->mockFile);

        $mockObj = $this->makeMock(200, $body);

        $mockObj->setUri('45717360');
        $mockObj->makeRequest();

        $this->assertEquals($body, $mockObj->getData());
    }

    public function testShouldReturnTransformedData()
    {
        $body = file_get_contents($this->mockFile);

        $mockObj = $this->makeMock(200, $body);

        $mockObj->setUri('45717360');
        $mockObj->makeRequest();

        $this->assertArrayHasKey('alpha2', $mockObj->getTransformed());
    }

    public function testParamShouldArray()
    {
        $this->expectException(\TypeError::class);

        $mockObj = $this->makeMock(200);

        $mockObj->setParam(null);
        $mockObj->makeRequest();
    }

    public function testMethodShouldValid()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid method.');
        $this->expectExceptionCode(400);

        $mockObj = $this->makeMock(400);

        $mockObj->setMethod('Invalid');
        $mockObj->makeRequest();
    }

    private function makeMock($status, $body = null)
    {
        $mock = new MockHandler([new Response($status, [], $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return new BinList($client, $this->mockBaseUri);
    }

}