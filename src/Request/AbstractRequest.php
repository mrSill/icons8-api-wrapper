<?php

namespace mrSill\Icons8\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;

/**
 * Class AbstractRequest
 *
 * @package mrSill\Icons8\Request
 */
abstract class AbstractRequest
{
    const ENDPOINT = 'https://api.icons8.com/api/iconsets/';

    const DEFAULT_TIMEOUT = 2.0;

    const AUTH_WITH_HEADER = 'header';
    const AUTH_WITH_QUERY  = 'query';
    const AUTH_WITH_COOKIE = 'cookie';

    const AUTH_HEADER_NAME = 'AUTH-ID';
    const AUTH_QUERY_NAME  = 'auth-id';
    const AUTH_COOKIE_NAME = 'AUTH_ID';

    /** @var \GuzzleHttp\Client */
    protected $httpClient;

    /** @var array */
    protected $headers = [];
    /** @var array */
    protected $cookies = [];
    /** @var array */
    protected $queries = [];

    /**
     * Request constructor.
     *
     * @param string $endpoint
     * @param float  $timeout
     */
    public function __construct($endpoint = self::ENDPOINT, $timeout = self::DEFAULT_TIMEOUT)
    {
        $this->httpClient = new Client([
            // Base URI is used with relative requests
            'base_uri' => $endpoint,
            'timeout'  => $timeout,
        ]);
    }

    /**
     * @param string $token
     * @param string $authType
     *
     * @return $this
     * @throws \Exception
     */
    public function setAuth($token, $authType = self::AUTH_WITH_HEADER)
    {
        if (empty($token)) {
            throw new \Exception('Invalid auth token');
        }

        switch ($authType) {
            case self::AUTH_WITH_HEADER:
                $this->setHeader(self::AUTH_HEADER_NAME, $token);
                break;
            case self::AUTH_WITH_QUERY:
                $this->setQuery(self::AUTH_QUERY_NAME, $token);
                break;
            case self::AUTH_WITH_COOKIE:
                $this->setCookie(self::AUTH_COOKIE_NAME, $token);
                break;
            default:
                throw new \Exception(sprintf('Unsupported auth type %s', $authType));
        }

        return $this;
    }

    /**
     * @param string $key   a header key
     * @param string $value a header value
     *
     * @return $this
     */
    protected function setHeader($key, $value = null)
    {
        $this->headers[$key] = $value;

        return $this;
    }

    /**
     * @param string|array $query
     * @param string       $value
     *
     * @return $this
     */
    public function setQuery($query, $value = null)
    {
        if (is_array($query)) {
            $this->queries = array_merge($this->queries, $query);
        }
        else {
            $this->queries[$query] = $value;
        }

        return $this;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    protected function setCookie($key, $value)
    {
        $this->cookies[$key] = $value;

        return $this;
    }

    /**
     * Make an HTTP GET request - for retrieving data
     *
     * @param   string $endpoint URL of the API request method
     * @param   array  $query    Assoc array of arguments (usually your data)
     *
     * @return  \mrSill\Icons8\Response\Response
     */
    abstract function request($endpoint, array $query = []);

    /**
     * @return array
     */
    protected function getRequestParams()
    {
        $params = [];

        if ($this->headers) {
            $params['headers'] = $this->getHeaders();
        }

        if ($this->cookies) {
            $params['cookies'] = $this->getCookies();
        }

        return $params;
    }

    /**
     * @return array
     */
    protected function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return \GuzzleHttp\Cookie\CookieJar
     */
    protected function getCookies()
    {
        $jar = new CookieJar();

        foreach ($this->cookies as $name => $value) {
            $cookie = new SetCookie();
            $cookie->setName($name);
            $cookie->setValue($value);

            $jar->setCookie($cookie);
        }

        return $jar;
    }

    /**
     * Get URI for Request
     *
     * @param string $endpoint
     *
     * @return string
     */
    protected function buildQuery($endpoint)
    {
        $separator = '?';

        $query = $this->queries ? $separator . $this->getQueries() : null;

        return $endpoint . $query;
    }

    /**
     * @return string
     */
    protected function getQueries()
    {
        return http_build_query($this->queries);
    }
}