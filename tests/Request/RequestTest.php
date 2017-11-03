<?php

namespace Tests\Request;

use mrSill\Icons8\Request\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testRequest()
    {
        $request = new Request();
        $this->assertInstanceOf('mrSill\Icons8\Request\Request', $request);

        $response = $request->request('categories');
        $this->assertInstanceOf('mrSill\Icons8\Response\Response', $response);
    }

    public function testSetAuth()
    {
        $request = new Request();

        try {
            // Wrong Auth type
            $request->setAuth(ICONS8_TEST_TOKEN, 'Unsupported_Auth_Type');
            $this->assertTrue(false);

            // Wrong Auth token
            $request->setAuth(null, Request::AUTH_WITH_HEADER);
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }

        try {
            $request->setAuth(ICONS8_TEST_TOKEN);
            $this->assertTrue(true);
        } catch (\Exception $e) {
            echo $e->getMessage();
            $this->assertTrue(false);
        }
    }
}