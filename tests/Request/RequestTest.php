<?php

namespace Tests\Request;

use mrSill\Icons8\Request\Request;
use mrSill\Icons8\Icons8Platform as Platform;
use Tests\TestCase;

/**
 * Class RequestTest
 *
 * @package Tests\Request
 */
class RequestTest extends TestCase
{
    public function testRequest()
    {
        $request = new Request();

        // Deprecated auth method
        $this->assertAttributeSame(
            self::AUTH_TOKEN,
            'authToken',
            $request->setAuthToken(self::AUTH_TOKEN)
        );

        $this->assertInstanceOf(
            'mrSill\Icons8\Response\Response',
            $request->request('categories')
        );
    }

    public function testSetQuery()
    {
        $request = new Request();

        $query = ['platform' => Platform::IOS7_PLATFORM];
        $this->assertAttributeSame(
            $query,
            'queries',
            $request->setQuery(['platform' => Platform::IOS7_PLATFORM]),
            'Set query fail'
        );

        $query['platform'] = Platform::ALL_PLATFORMS;
        $this->assertAttributeSame(
            $query,
            'queries',
            $request->setQuery('platform', Platform::ALL_PLATFORMS),
            'Reset query value fail'
        );
    }

    public function testFailSetAuth()
    {
        $request = new Request();

        try {
            // Empty auth token
            $request->setAuth(null);

            // Impossible. Set FAIL
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->throwException($e);
        }

        try {
            // Unsupported auth method
            $request->setAuth(self::AUTH_TOKEN, 'Unsupported');

            // Impossible. Set FAIL
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->throwException($e);
        }
    }

    public function testRequestWithAuthQuery()
    {
        $request = new Request();

        $this->assertAttributeSame(
            [Request::AUTH_HEADER_NAME => self::AUTH_TOKEN],
            'headers',
            $request->setAuth(self::AUTH_TOKEN),
            'Auth with http header fail'
        );

        $this->assertAttributeSame(
            [Request::AUTH_COOKIE_NAME => self::AUTH_TOKEN],
            'cookies',
            $request->setAuth(self::AUTH_TOKEN, Request::AUTH_WITH_COOKIE),
            'Auth with cookie is fail'
        );

        $this->assertAttributeSame(
            [Request::AUTH_QUERY_NAME => self::AUTH_TOKEN],
            'queries',
            $request->setAuth(self::AUTH_TOKEN, Request::AUTH_WITH_QUERY),
            'Auth with http query is fail'
        );

        $this->assertInstanceOf(
            'mrSill\Icons8\Response\Response',
            $request->request('categories')
        );
    }
}