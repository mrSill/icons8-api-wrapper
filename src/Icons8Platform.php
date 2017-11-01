<?php

namespace mrSill\Icons8;

/**
 * Class Icons8Platform
 *
 * @package mrSill\Icons8
 * @author  Aliaksandr Sidaruk
 */
class Icons8Platform
{
    const ALL_PLATFORMS        = null;
    const IOS7_PLATFORM        = 'ios7';
    const IOS11_PLATFORM       = 'ios11';
    const WIN10_PLATFORM       = 'win10';
    const WIN8_PLATFORM        = 'win8';
    const MATERIAL_PLATFORM    = 'androidL';
    const COLOR_PLATFORM       = 'color';
    const OFFICE_PLATFORM      = 'office';
    const ULTRAVIOLET_PLATFORM = 'ultraviolet';
    const NOLAN_PLATFORM       = 'nolan';
    const P1EM_PLATFORM        = 'p1em';
    const DOTTY_DOTS_PLATFORM  = 'dotty';
    const DUSK_PLATFORM        = 'dusk';
    const WIRED_PLATFORM       = 'Dusk_Wired';
    const ANDROID_PLATFORM     = 'android';

    /** @var array */
    protected $names = [
        self::IOS7_PLATFORM        => 'iPhone/iOS 7',
        self::IOS7_PLATFORM        => 'iPhone/iOS 11',
        self::WIN10_PLATFORM       => 'Windows 10/Threshold',
        self::WIN8_PLATFORM        => 'Windows 8/Metro',
        self::MATERIAL_PLATFORM    => 'Material',
        self::COLOR_PLATFORM       => 'Color',
        self::OFFICE_PLATFORM      => 'Office',
        self::ULTRAVIOLET_PLATFORM => 'Ultraviolet',
        self::NOLAN_PLATFORM       => 'Nolan',
        self::P1EM_PLATFORM        => '1em',
        self::DOTTY_DOTS_PLATFORM  => 'DottyDots',
        self::DUSK_PLATFORM        => 'Dusk',
        self::WIRED_PLATFORM       => 'Wired',
        self::ANDROID_PLATFORM     => 'Android 4'
    ];

    /**
     * @param string $platform
     *
     * @return string|bool
     */
    public function getName($platform)
    {
        return array_key_exists($platform, $this->names) ? $this->names[$platform] : false;
    }

    /**
     * @return array
     */
    public function getNames()
    {
        return $this->names;
    }
}
