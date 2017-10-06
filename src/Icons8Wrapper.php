<?php

namespace mrSill\Icons8;

use GuzzleHttp\Exception\RequestException;
use mrSill\Icons8\Request\Request;
use mrSill\Icons8\Icons8Platform as Platform;

/**
 * Class Icons8Wrapper
 *
 * @package mrSill\Icons8
 * @author  Aliaksandr Sidaruk
 */
class Icons8Wrapper
{
    const AMOUNT = 25;

    /** @var \mrSill\Icons8\Request\Request */
    protected $request;
    /** @var array */
    protected $lastQuery = [];
    /** @var  \mrSill\Icons8\Response\Response */
    protected $lastResponse;

    /**
     * @param string|null $authToken
     */
    public function __construct($authToken = null)
    {
        $this->request = new Request();
        $this->request->setAuthToken($authToken);
    }

    /**
     * Return one icon by id.
     *
     * @param int $iconID the icon id
     *
     * @return array
     */
    public function getIconById($iconID)
    {
        return $this->getIconByIDs([$iconID]);
    }

    /**
     * returns one or several icons by ids.
     *
     * @param array $iconIDs the icon’s id
     *
     * @return array
     */
    public function getIconByIDs($iconIDs = [])
    {
        $query = ['id' => join(',', $iconIDs)];

        $result = $this->apiCall('icon', $query);

        return $result;
    }

    /**
     * Returns all icons in alphabetical order.
     *
     * @param string $amount   the maximum number of icons which you'd like to
     *                         receive; the default and maximum value is 25
     * @param int    $offset   the offset from the first received result; default is 0
     * @param string $platform the platform that we are searching icons for
     *
     * @return array
     */
    public function getAllIcons($amount = self::AMOUNT, $offset = 0, $platform = Platform::ALL_PLATFORMS)
    {
        $query = [
            'amount'   => $amount,
            'offset'   => $offset,
            'platform' => $platform
        ];

        $result = $this->apiCall('icons', $query);

        return $result;
    }

    /**
     * Returns icons that were found by specified search criteria.
     *
     * @param string $term     the name or tag of the icon or any other phrase;
     *                         e.g. use "@round" to find icons with the tag "round"
     *                         and "=circle" to find icons with the name "circle"
     * @param int    $amount   the maximum number of icons which you'd like to receive
     * @param int    $offset   the offset from the first received result; default is 0
     * @param string $platform the platform that we are searching icons for
     *
     * @return array
     */
    public function searchIcons($term, $amount = self::AMOUNT, $offset = 0, $platform = Platform::ALL_PLATFORMS)
    {
        $query = [
            'term'     => $term,
            'amount'   => $amount,
            'offset'   => $offset,
            'platform' => $platform
        ];

        $result = $this->apiCall('search', $query);

        return $result;
    }

    /**
     * Returns several icons sorted by date, newest first
     *
     * @param string $amount   the maximum number of icons which you'd like to receive;
     *                         the default and maximum value is 25
     * @param int    $offset   the offset from the first received result; default is 0
     * @param string $platform the platform that we are searching icons for
     *
     * @return array
     */
    public function getNewestIcons($amount = self::AMOUNT, $offset = 0, $platform = Platform::ALL_PLATFORMS)
    {
        $query = [
            'amount'   => $amount,
            'offset'   => $offset,
            'platform' => $platform
        ];

        $result = $this->apiCall('latest', $query);

        return $result;
    }

    /**
     * Returns icons similar to the specified one.
     *
     * @param int    $id     the icon’s id
     * @param string $amount the maximum number of icons which you'd like to receive;
     *                       the default and maximum value is 25
     * @param int    $offset the offset from the first received result; default is 0
     *
     * @return array
     */
    public function getSimilarIcons($id, $amount = self::AMOUNT, $offset = 0)
    {
        $query = [
            'id'     => $id,
            'amount' => $amount,
            'offset' => $offset
        ];

        $result = $this->apiCall('similar', $query);

        return $result;
    }

    /**
     * Returns the total number of icons for different platforms.
     *
     * @param string $since the optional date to calculate the total number of
     *                      icons that were created after it. It should be in
     *                      format "four year digits - dash - two month number digits
     *                      - dash - two day number digits.
     *                      For example 2014-12-31 means "31th of December, 2014".
     *
     * @return array
     */
    public function getTotalIcons($since = null)
    {
        $query = [
            'since' => $since
        ];

        $result = $this->apiCall('total', $query);

        return $result;
    }

    /**
     * Returns links to lists with information about icons in JSON format.
     *
     * @param string $platform the platform that we are searching icons for
     *
     * @return array
     */
    public function getInfoList($platform = Platform::ALL_PLATFORMS)
    {
        $query = [
            'platform' => $platform
        ];

        $result = $this->apiCall('list', $query);

        return $result;
    }

    /**
     * Returns list of categories.
     *
     * @param string $platform the platform that we are searching categories for
     * @param string $language the language code to get localized result
     *                         Possible values: en-US , fr-FR , de-DE , it-IT , pt-BR , pl-PL , ru-RU , es-ES
     *
     * @return array
     */
    public function getCategories($platform = Platform::ALL_PLATFORMS, $language = 'en_US')
    {
        $query = [
            'platform' => $platform,
            'language' => $language
        ];

        $result = $this->apiCall('v3/categories', $query);

        return $result;
    }

    /**
     * Returns information about one specified category and the list of icons in it.
     *
     * @param string $category   the name of the icons' category, case insensitive
     * @param int    $amount     the maximum number of icons which you'd like to receive
     * @param int    $offset     the offset from the first received result; default is 0
     * @param string $platform   the platform that we are searching categories for
     * @param string $attributes icon's special attributes, like "filled" or "outlined"
     *
     * @return array
     */
    public function getCategory($category, $amount = self::AMOUNT, $offset = 0, $platform = Platform::ALL_PLATFORMS, $attributes = null)
    {
        $query = [
            'category'   => $category,
            'amount'     => $amount,
            'offset'     => $offset,
            'platform'   => $platform,
            'attributes' => $attributes
        ];

        $result = $this->apiCall('category', $query);

        return $result;
    }

    /**
     * Returns suggestions for icon's names and tags by the specified string.
     *
     * @param string $term     the name or tag of the icon or any other phrase
     * @param int    $amount   the maximum number of icons which you'd like to receive
     * @param string $platform the platform that we are searching icons for
     *
     * @return array
     */
    public function suggest($term, $amount = self::AMOUNT, $platform = Platform::ALL_PLATFORMS)
    {
        $query = [
            'term'     => $term,
            'amount'   => $amount,
            'platform' => $platform
        ];

        $result = $this->apiCall('search', $query);

        return $result;
    }

    /**
     * @param string $method a API method
     * @param array  $query  parameters
     *
     * @return array
     */
    private function apiCall($method, array $query = [])
    {
        $answer = [
            'success'    => false,
            'parameters' => $query
        ];

        try {
            $this->lastResponse = $this->request->request($method, $query);
            $result = (array)$this->lastResponse->getBody()->toArray();

            if (isset($result['error'])) {
                $answer['error'] = [
                    'message' => $result['error'],
                    'code'    => 400
                ];
            } else {
                $answer['success'] = true;
                $answer['result'] = $result['result'];
            }
        } catch (RequestException $e) {
            $request = $e->getRequest();

            $answer['error'] = [
                'message' => $e->getMessage(),
                'code'    => $e->getCode()
            ];

            if ($e->hasResponse()) {
                $this->lastResponse = $e->getResponse();
            } else {
                $this->lastResponse = null;
            }
        } catch (\Exception $e) {
            $answer['error'] = [
                'message' => $e->getMessage(),
                'code'    => $e->getCode()
            ];
        }

        return $answer;
    }

    /**
     * Return last response object
     *
     * @return \mrSill\Icons8\Response\Response
     */
    public function lastResponse()
    {
        return $this->lastResponse;
    }
}