<?php

namespace Tests;

use mrSill\Icons8\Icons8Platform;

/**
 * Class Icons8PlatformTests
 *
 * @package Tests
 */
class Icons8PlatformTests extends TestCase
{
    public function testPlatform()
    {
        $platform = new Icons8Platform();

        $this->assertTrue(is_array($platform->getNames()));

        $this->assertNull($platform->getName(Icons8Platform::ALL_PLATFORMS));

        $this->assertTrue(is_string($platform->getName(Icons8Platform::IOS7_PLATFORM)));

        $this->assertFalse($platform->getName('undefined'));
    }
}