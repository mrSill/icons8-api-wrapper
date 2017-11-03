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

        $this->assertAttributeSame(
            [Request::AUTH_HEADER_NAME => self::AUTH_TOKEN],
            'headers',
            $stub->setAuth(self::AUTH_TOKEN),
            'Auth with default type is fail'
        );

        $this->assertAttributeSame(
            [Request::AUTH_HEADER_NAME => self::AUTH_TOKEN],
            'headers',
            $stub->setAuth(self::AUTH_TOKEN, Request::AUTH_WITH_HEADER),
            'Auth with http header is fail'
        );

        $this->assertAttributeSame(
            [Request::AUTH_COOKIE_NAME => self::AUTH_TOKEN],
            'cookies',
            $stub->setAuth(self::AUTH_TOKEN, Request::AUTH_WITH_COOKIE),
            'Auth with cookie is fail'
        );

        $this->assertAttributeSame(
            [Request::AUTH_QUERY_NAME => self::AUTH_TOKEN],
            'queries',
            $stub->setAuth(self::AUTH_TOKEN, Request::AUTH_WITH_QUERY),
            'Auth with http query is fail'
        );

        try {
            // Empty auth token
            $stub->setAuth(null);
            // Unsupported auth method
            $stub->setAuth(self::AUTH_TOKEN, 'Unsupported');
            // Impossible. Set FAIL
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->throwException($e);
        }
    }

    public function testSetQuery()
    {
        $stub = $this->getAbstractRequestMock();

        $query = [
            'foo' => 'bar',
            'bar' => 'foo'
        ];

        // Set queries as array
        $this->assertAttributeSame(
            $query,
            'queries',
            $stub->setQuery($query)
        );

        $query['bar'] = 'bar';

        // Set query as key-value
        $this->assertAttributeSame(
            $query,
            'queries',
            $stub->setQuery('bar', 'bar')
        );
    }
}