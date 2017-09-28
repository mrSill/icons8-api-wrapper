<?php

namespace mrSill\Icons8\Response;

/**
 * Class AbstractResponseBody
 * 
 * @package    mrSill\Icons8
 * @subpackage Response
 * @author     Aliaksandr Sidaruk
 */
abstract class AbstractResponseBody
{
    /** @var string */
    protected $rawBody;
    
    /**
     * @param string $rawBody
     */
    public function __construct($rawBody)
    {
        $this->rawBody = $rawBody;
    }
}