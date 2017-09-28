<?php

namespace mrSill\Icons8\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as RequestService;
use mrSill\Icons8\Response\Response;

/**
 * 
 */
class Request
{
    const API_ENDPOINT = 'https://api.icons8.com/api/iconsets';
    const TIMEOUT      = 2.0;
    /** @var \GuzzleHttp\Client */
    private $client;
    
    public function __construct()
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => self::API_ENDPOINT,
            'timeout'  => self::TIMEOUT,
        ]);
    }
    
    /**
     * Make an HTTP GET request - for retrieving data
     * 
     * @param   string $apiMethod URL of the API request method
     * @param   array $args Assoc array of arguments (usually your data)
     * 
     * @return  Response
     */
    public function request($apiMethod, array $args = [])
    {
        $request = new RequestService('GET', $this->getURI($apiMethod), $args);
        
        return new Response($this->client->send($request));
    }
    
    /**
     * Get URI for Request
     * 
     * @param string $apiMethod
     * 
     * @return string
     */
    private function getURI($apiMethod)
    {
        return self::API_ENDPOINT . '/' . $apiMethod;
    }
}