<?php

namespace Tests\Response;

use mrSill\Icons8\Request\Request;
use mrSill\Icons8\Response\JsonBodyResponse;
use mrSill\Icons8\Response\Response;
use mrSill\Icons8\Response\XmlBodyResponse;
use Tests\TestCase;

/**
 * Class ResponseTest
 *
 * @package Tests\Response
 */
class ResponseTest extends TestCase
{
    protected $endpoints = [
        'v1' => 'https://api.icons8.com/api/iconsets/categories',
        'v2' => 'https://api.icons8.com/api/iconsets/v2/categories',
        'v3' => 'https://api.icons8.com/api/iconsets/v3/categories',
    ];

    protected function getResponse($uri)
    {
        $request = new Request();

        $response = $request->request($uri);

        return $response;
    }

    public function testResponse()
    {
        $response = $this->getResponse($this->endpoints['v1']);

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertInstanceOf(
            \GuzzleHttp\Psr7\Response::class,
            $response->getResponse()
        );
    }

    public function testStatusCode()
    {
        $response = $this->getResponse($this->endpoints['v1']);

        // check status code
        $this->assertTrue($response->hasStatusCode(200));
        $this->assertEquals($response->getStatusCode(), 200);
    }

    public function testErrors()
    {
        $response  = $this->getResponse($this->endpoints['v1']);

        $this->assertFalse($response->hasErrors());
        $this->assertNull($response->getError());
    }

    public function testGetBody()
    {
        $response  = $this->getResponse($this->endpoints['v1']);

        $this->assertInstanceOf(
            XmlBodyResponse::class,
            $response->getBody()
        );

        $response  = $this->getResponse($this->endpoints['v2']);

        $this->assertInstanceOf(
            JsonBodyResponse::class,
            $response->getBody()
        );

        $response  = $this->getResponse($this->endpoints['v3']);

        $this->assertInstanceOf(
            JsonBodyResponse::class,
            $response->getBody()
        );
    }

    public function testXMLBody()
    {
        $response  = $this->getResponse($this->endpoints['v1']);

        // check content type
        $this->assertEquals($response->getContentType(), Response::XML_CONTENT_TYPE);

        // $this->setExpectedException(\Exception::class);

        $this->assertTrue(is_array($response->getBody()->toArray()));
    }

    public function testJSONBody()
    {
        $response  = $this->getResponse($this->endpoints['v2']);

        // check content type
        $this->assertEquals($response->getContentType(), Response::JSON_CONTENT_TYPE);

        $response  = $this->getResponse($this->endpoints['v3']);

        // check content type
        $this->assertEquals($response->getContentType(), Response::JSON_CONTENT_TYPE);

        // $this->setExpectedException(\Exception::class);

        $this->assertTrue(is_array($response->getBody()->toArray()));
    }
}