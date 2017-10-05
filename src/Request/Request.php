<?php

namespace mrSill\Icons8\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as RequestService;
use mrSill\Icons8\Response\Response;

/**
 * Class Request
 *
 * @package mrSill\Icons8\Request
 * @author  Aliaksandr Sidaruk
 */
class Request
{
    const API_ENDPOINT    = 'https://api.icons8.com/api/iconsets/';
    const API_ENDPOINT_V3 = 'https://api.icons8.com/api/iconsets/v3/';
    const TIMEOUT         = 2.0;

    /** @var \GuzzleHttp\Client */
    private $client;

    /** @var string */
    private $authToken;

    private $headers = [];

    public function __construct($endpoint = self::API_ENDPOINT, $timeout = self::TIMEOUT)
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $endpoint,
            'timeout'  => $timeout,
        ]);
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setAuthToken($token)
    {
        $this->authToken = $token;

        return $this;
    }

    /**
     * @param string $key   a header key
     * @param string $value a header value
     *
     * @return $this
     */
    public function setHeader($key, $value = null)
    {
        $this->headers[$key] = $value;

        return $this;
    }

    /**
     * Make an HTTP GET request - for retrieving data
     *
     * @param   string $apiMethod URL of the API request method
     * @param   array  $args      Assoc array of arguments (usually your data)
     *
     * @return  Response
     */
    public function request($apiMethod, array $query = [])
    {
        if ($this->authToken) {
            $this->setHeader('AUTH-ID', $this->authToken);
        }

        $request = new RequestService(
            'GET',
            $this->getURI($apiMethod, $query),
            $this->headers
        );

        return new Response($this->client->send($request));
    }

    /**
     * Get URI for Request
     *
     * @param string $apiMethod
     *
     * @return string
     */
    private function getURI($apiMethod, $query)
    {
        return sprintf("%s?%s", $apiMethod, http_build_query($query));
    }
}