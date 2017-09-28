<?php

namespace mrSill\Icons8\Response;

/**
 * Class JsonBodyResponse
 * For new Icons8 API
 * 
 * @package    mrSill\Icons8
 * @subpackage Response
 * @author     Aliaksandr Sidaruk
 */
class JsonBodyResponse extends AbstractResponseBody implements ResponseBodyInterface
{
    /**
     * @return array
     */
    public function toArray()
    {
        return json_decode($this->rawBody);
    }
}