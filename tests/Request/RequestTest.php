<?php

namespace Tests\Request;

use mrSill\Icons8\Request\Request;
use mrSill\Icons8\Icons8Platform as Platform;
use Tests\TestCase;

class RequestTest extends TestCase
{
    public function testRequest()
    {
        $request = new Request();
        $this->assertInstanceOf('mrSill\Icons8\Request\Request', $request);

        $request->setQuery(['platform' => Platform::IOS7_PLATFORM]);

        $request->setQuery('platform', Platform::ALL_PLATFORMS);

        $response = $request->request('categories');
        $this->assertInstanceOf('mrSill\Icons8\Response\Response', $response);
    }

    public function testDeprecatedSetAuth()
    {
        $request = new Request();

        // Deprecated auth method
        $request->setAuthToken(self::AUTH_TOKEN);
    }

    public function testSetAuth()
    {
        $request = new Request();

        try {
            // Wrong Auth type
            $request->setAuth(self::AUTH_TOKEN, 'Unsupported_Auth_Type');
            $this->assertTrue(false);

            // Wrong Auth token
            $request->setAuth(null);
            $this->assertTrue(false);
        } catch (\Exception $e) {
            echo $e->getMessage();
            $this->assertTrue(true);
        }

        try {
            // With default auth type
            $request->setAuth(self::AUTH_TOKEN);
            $this->assertTrue(true);

            // With http header auth type
            $request->setAuth(self::AUTH_TOKEN, Request::AUTH_WITH_HEADER);
            $this->assertTrue(true);

            // With http header auth type
            $request->setAuth(self::AUTH_TOKEN, Request::AUTH_WITH_COOKIE);
            $this->assertTrue(true);

            // With http header auth type
            $request->setAuth(self::AUTH_TOKEN, Request::AUTH_WITH_QUERY);
            $this->assertTrue(true);
        } catch (\Exception $e) {
            echo $e->getMessage();
            $this->assertTrue(false);
        }
    }
}