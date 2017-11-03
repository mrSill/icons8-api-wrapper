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
}