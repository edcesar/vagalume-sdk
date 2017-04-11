<?php

namespace VagalumeSdk;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use VagalumeSdk\Enum\TypeEnum;
use VagalumeSdk\Exception\VagalumeSdkException;
use VagalumeSdk\Exception\VagalumeSdkInvalidTypeException;
use VagalumeSdk\Exception\VagalumeSdkNotFoundException;
use VagalumeSdk\Exception\VagalumeSdkNullOrEmptyException;

class Vagalume
{
    private $protectedEndpoint = 'http://api.vagalume.com.br';
    private $publicEndpoint = 'https://www.vagalume.com.br';
    private $apiKey;
    private $httpClient;

    /**
     * Vagalume constructor.
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->httpClient = new Client();
    }

    /**
     * @param string $name
     * @return string
     * @throws VagalumeSdkNullOrEmptyException
     */
    public function getArtist($name = null)
    {
        if (is_null($name) || empty($name)) {
            throw new VagalumeSdkNullOrEmptyException('Artist name is required');
        }
        return $this->getResponseContent(
            $this->makePublicRequest([$name])
        );
    }

    /**
     * @param string $artistName
     * @return string
     * @throws VagalumeSdkNullOrEmptyException
     */
    public function getDiscography($artistName = null)
    {
        if (is_null($artistName) || empty($artistName)) {
            throw new VagalumeSdkNullOrEmptyException('Artist name is required');
        }
        return $this->getResponseContent(
            $this->makePublicRequest([
                sprintf('%s/discografia', $artistName)
            ])
        );
    }

    /**
     * @return string
     */
    public function getHotspots()
    {
        return $this->getResponseContent(
            $this->makeProtectedRequest([], 'hotspots.php')
        );
    }

    /**
     * @return string
     */
    public function getNews()
    {
        return $this->getResponseContent(
            $this->makePublicRequest(['news'])
        );
    }

    /**
     * @param array $types
     * @param string $radioName
     * @return string
     * @throws VagalumeSdkInvalidTypeException
     */
    public function getRadios(array $types, $radioName)
    {
        $allowedTypes = [ TypeEnum::ARTIST, TypeEnum::ALBUM, TypeEnum::MUSIC ];
        $invalidTypes = array_filter($types, function($type) use ($allowedTypes) {
            return ! in_array($type, $allowedTypes);
        });

        if (! empty($invalidTypes)) {
            throw new VagalumeSdkInvalidTypeException(
                sprintf('Invalid type [ Allowed types : %s ]', implode(',', $allowedTypes))
            );
        }
        return $this->getResponseContent(
            $this->makeProtectedRequest(['type' => implode('', $types), 'radio' => $radioName], 'radio.php')
        );
    }

    /**
     * @param string $artistId
     * @param int $limit
     * @return string
     * @throws VagalumeSdkNullOrEmptyException
     */
    public function getArtistImage($artistId = null, $limit = 10)
    {
        if (is_null($artistId) || empty($artistId)) {
            throw new VagalumeSdkNullOrEmptyException('Artist ID is required');
        }
        return $this->getResponseContent(
            $this->makeProtectedRequest(['bandID' => $artistId, 'limit' => $limit], 'image.php')
        );
    }

    /**
     * @param ResponseInterface $response
     * @return string
     * @throws VagalumeSdkException
     * @throws VagalumeSdkNotFoundException
     */
    private function getResponseContent(ResponseInterface $response)
    {
        try {
            $content = $response->getBody()->getContents();

            if (preg_match("/(<!DOCTYPE html>)/i", $content)) {
                throw new VagalumeSdkNotFoundException('Register not found');
            }
        } catch (ClientException $e) {
            if ($e->getCode() === 404) {
                throw new VagalumeSdkNotFoundException('Register not found');
            }
            throw new VagalumeSdkException($e->getMessage(), $e->getCode());
        }
        return $content;
    }

    /**
     * @param array $data
     * @param string $filename
     * @param string $method
     * @return ResponseInterface
     */
    private function makePublicRequest(array $data, $filename = 'index.js', $method = 'GET')
    {
        $url = sprintf('%s/%s/%s', $this->publicEndpoint, array_shift($data), $filename);

        return $this->makeRequest($url, $method);
    }

    /**
     * @param array $data
     * @param string $filename
     * @param string $method
     * @return ResponseInterface
     */
    private function makeProtectedRequest(array $data, $filename, $method = 'GET')
    {
        $queryString = null;

        if (! empty($data)) {
            $queryString = sprintf('&%s', http_build_query($data));
        }
        $url = sprintf('%s/%s?apikey=%s%s', $this->protectedEndpoint, $filename, $this->getApiKey(), $queryString);

        return $this->makeRequest($url, $method);
    }

    /**
     * @param string $url
     * @param string $method
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function makeRequest($url, $method = 'GET')
    {
        return $this->getHttpClient()->request($method, $url);
    }

    /**
     * @return string
     */
    private function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    private function getHttpClient()
    {
        return $this->httpClient;
    }
}