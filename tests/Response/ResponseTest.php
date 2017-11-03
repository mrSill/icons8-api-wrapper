<?php

namespace Tests\Response;

use mrSill\Icons8\Request\Request;
use mrSill\Icons8\Response\Response;
use mrSill\Icons8\Response\XmlBodyResponse;

/**
 * Class ResponseTest
 *
 * @package Tests\Response
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    protected function getResponse()
    {
        $request = new Request();

        return $request->request('categories');
    }

    public function testV1Response()
    {
        $response  = $this->getResponse();

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertInstanceOf(
            \GuzzleHttp\Psr7\Response::class,
            $response->getResponse()
        );
        // check status code
        $this->assertTrue($response->hasStatusCode(200));
        $this->assertEquals($response->getStatusCode(), 200);

        // check content type
        $this->assertEquals($response->getContentType(), Response::XML_CONTENT_TYPE);

        $this->assertFalse($response->hasErrors());
        $this->assertNull($response->getError());

        // $this->setExpectedException(\Exception::class);

        $this->assertInstanceOf(
            XmlBodyResponse::class,
            $response->getBody()
        );

        $this->assertTrue(is_array($response->getBody()->toArray()));
    }
}