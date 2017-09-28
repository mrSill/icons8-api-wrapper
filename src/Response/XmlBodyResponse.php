<?php

namespace mrSill\Icons8\Response;

/**
 * Class XmlBodyResponse
 * For base Icons8 API
 * 
 * @package    mrSill\Icons8
 * @subpackage Response
 * @author     Aliaksandr Sidaruk
 */
class XmlBodyResponse extends AbstractResponseBody implements ResponseBodyInterface
{
    /**
     * @return array
     */
    public function toArray()
    {
        $xml = simplexml_load_string($this->rawBody);
        $json = json_encode($xml);
        return json_decode($json,TRUE);
    }
}