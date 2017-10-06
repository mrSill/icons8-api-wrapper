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
    const API_ENDPOINT = 'https://api.icons8.com/api/iconsets/';
    const TIMEOUT      = 5.0;

    /** @var \GuzzleHttp\Client */
    private $client;

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
        $this->setHeader('AUTH-ID', $token);

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
     * @param   array  $query     Assoc array of queries
     *
     * @return  Response
     */
    public function request($apiMethod, array $query = [])
    {
        return $this->get($this->buildQuery($apiMethod, $query));
    }

    /**
     * @param string $endpoint
     *
     * @return \mrSill\Icons8\Response\Response
     */
    public function get($endpoint)
    {
        $request = new RequestService(
            'GET',
            $endpoint,
            $this->headers
        );

        return new Response($this->client->send($request));
    }

    /**
     * Get URI for Request
     *
     * @param string       $apiMethod
     * @param array|string $query
     *
     * @return string
     */
    protected function buildQuery($apiMethod, array $query = [])
    {
        if (!empty($query)) {
            $query = is_array($query)
                ? http_build_query($query)
                : $query;
        } else {
            $query = null;
        }

        return sprintf("%s?%s", $apiMethod, $query);
    }
}