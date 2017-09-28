<?php

namespace mrSill\Icons8\Response;

/**
 * Class Response
 * 
 * @package    mrSill\Icons8
 * @subpackage Response
 * @author     Aliaksandr Sidaruk
 */
class Response
{
    const XML_CONTENT_TYPE  = 'application/xhtml+xml';
    const JSON_CONTENT_TYPE = 'application/json';
    
    /** @var \GuzzleHttp\Psr7\Response */
    protected $response;
    
    /**
     * @param \GuzzleHttp\Psr7\Response $response
     */
    public function __construct(\GuzzleHttp\Psr7\Response $response)
    {
        $this->response = $response;
    }
    
    /**
     * @return \GuzzleHttp\Response
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * @return ResponseBodyInterface
     */
    public function getBody()
    {
        if ($this->getContentType() == self::XML_CONTENT_TYPE) {
            return new XmlBodyResponse($this->getRawBody());
        }
        elseif ($this->getContentType() == self::JSON_CONTENT_TYPE) {
            return new JsonBodyResponse($this->getRawBody());
        }
        else {
            throw new \Exception('Unsupported Content-Type ' . $this->getContentType());
        }
    }
    
    /**
     * @return string
     */
    private function getRawBody()
    {
        return $this->response->getBody()->getContents();
    }
    
    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }
    
    /**
     * @param int $code
     * 
     * @return bool
     */
    public function hasStatusCode($code)
    {
        return $code == $this->getStatusCode();
    }
    
    /**
     * @return string|null
     */
    public function getContentType()
    {
        return $this->response->hasHeader('Content-Type')
            ? is_array($this->response->getHeader('Content-Type'))
                ? join(',', $this->response->getHeader('Content-Type'))
                : $this->response->getHeader('Content-Type')
            : null;
    }
    
    /**
     * @return bool
     */
    public function hasErrors()
    {
        $body = $this->getBody()->toArray();
        
        return isset($body['error']);
    }
    
    /**
     * @return string|null
     */
    public function getError()
    {
        $body = $this->getBody()->toArray();
        
        return isset($body['error']) ? $body['error'] : null;
    }
}