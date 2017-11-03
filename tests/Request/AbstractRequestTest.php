<?php

namespace Tests\Request;

use mrSill\Icons8\Request\AbstractRequest;
use mrSill\Icons8\Request\Request;
use mrSill\Icons8\Response\Response;
use Tests\TestCase;

class AbstractRequestTest extends TestCase
{
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getAbstractRequestMock()
    {
        return $this->getMockForAbstractClass(AbstractRequest::class);
    }

    public function testAbstractRequest()
    {
        $stub = $this->getAbstractRequestMock();

        $stub->expects($this->any())
            ->method('request')
            ->will($this->returnValue(Response::class));
    }

    public function testSetAuth()
    {
        $stub = $this->getAbstractRequestMock();

        $this->setExpectedException(\Exception::class);

        // Empty auth token
        $this->throwException($stub->setAuth(null));

        // Unsupported auth method
        $this->throwException($stub->setAuth(self::AUTH_TOKEN, 'Unsupported'));

        $this->assertInstanceOf(
            Request::class,
            $stub->setAuth(self::AUTH_TOKEN),
            'Auth with default type is fail'
        );

        $this->assertInstanceOf(
            Request::class,
            $stub->setAuth(self::AUTH_TOKEN, Request::AUTH_WITH_HEADER),
            'Auth with http header is fail'
        );

        $this->assertInstanceOf(
            Request::class,
            $stub->setAuth(self::AUTH_TOKEN, Request::AUTH_WITH_COOKIE),
            'Auth with cookie is fail'
        );

        $this->assertInstanceOf(
            Request::class,
            $stub->setAuth(self::AUTH_TOKEN, Request::AUTH_WITH_QUERY),
            'Auth with http query is fail'
        );
    }
}