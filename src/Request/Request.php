<?php

namespace mrSill\Icons8\Request;

use GuzzleHttp\Psr7\Request as RequestService;
use mrSill\Icons8\Response\Response;

/**
 * Class Request
 *
 * @package mrSill\Icons8\Request
 * @author  Aliaksandr Sidaruk
 */
class Request extends AbstractRequest
{
    const API_ENDPOINT_V1 = 'https://api.icons8.com/api/iconsets/';
    const API_ENDPOINT_V2 = 'https://api.icons8.com/api/iconsets/v2/';
    const API_ENDPOINT_V3 = 'https://api.icons8.com/api/iconsets/v3/';

    /** @var string */
    private $authToken;

    /**
     * @param string $token
     *
     * @return $this
     * @deprecated
     * @see setAuth()
     */
    public function setAuthToken($token)
    {
        $this->setHeader('AUTH-ID', $token);

        return $this;
    }

    /**
     * Make an HTTP GET request - for retrieving data
     *
     * @param   string $endpoint URL of the API request method
     * @param   array  $query    Assoc array of arguments (usually your data)
     *
     * @return Response
     */
    public function request($endpoint, array $query = [])
    {
        try {
            if ($this->authToken) {
                $this->setAuth($this->authToken);
            }
        } catch (\Exception $e) {
            // Auth is fail. Ignore this error
        }

        $this->setQuery($query);

        $request = new RequestService(
            'GET',
            $this->buildQuery($endpoint)
        );

        return new Response($this->httpClient->send($request, $this->getRequestParams()));
    }

    /**
     * Simple alias for request method
     *
     * @param string $endpoint
     *
     * @return \mrSill\Icons8\Response\Response
     */
    public function get($endpoint)
    {
        return $this->request($endpoint);
    }
}