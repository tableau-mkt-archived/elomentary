<?php

namespace Eloqua\Api;

use Eloqua\Client;
use Eloqua\HttpClient\Message\ResponseMediator;
use Eloqua\Exception\InvalidArgumentException;

/**
 * Abstract class for API classes.
 */
abstract class AbstractApi implements ApiInterface {

  /**
   * The client
   *
   * @var Client
   */
  protected $client;

  /**
   * Number of items per page (Eloqua pagination)
   *
   * @var null|int
   */
  protected $count;

  /**
   * @param Client $client
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }

  public function configure() {}

  /**
   * @return null|int
   */
  public function getCount() {
    return $this->count;
  }

  /**
   * @param null|int $perPage
   */
  public function setCount($count) {
    $this->count = ($count === NULL ? $count : (int) $count);

    return $this;
  }

  /**
   * Sends a GET request with query parameters.
   *
   * @param string $path
   *   The request path.
   *
   * @param array $parameters
   *   GET request parameters.
   *
   * @param array $requestHeaders
   *   The request headers.
   *
   * @return \Guzzle\Http\EntityBodyInterface|mixed|string
   */
  protected function get($path, array $parameters = array(), $requestHeaders = array()) {
    if ($this->count !== NULL && !isset($parameters['count'])) {
      $parameters['count'] = $this->count;
    }
    $response = $this->client->getHttpClient()->get($path, $parameters, $requestHeaders);

    return ResponseMediator::getContent($response);
  }

  /**
   * Sends a POST request with JSON-encoded parameters.
   *
   * @param string $path
   *   The request path.
   *
   * @param object|array $parameters
   *   POST parameters to be JSON encoded.
   *
   * @param array $requestHeaders
   *   The request headers.
   *
   * @returns \Eloqua\HttpClient\Message\ResponseMediator
   */
  protected function post($path, $parameters = array(), $requestHeaders = array()) {
    return $this->postRaw(
      $path,
      $this->createJsonBody($parameters),
      $requestHeaders
    );
  }

  /**
   * Sends a POST request with raw data.
   *
   * @param string $path
   *   The request path
   * .
   * @param $body
   *   The request body.
   * @param array $requestHeaders
   *   The request headers.
   *
   * @return \Guzzle\Http\EntityBodyInterface|mixed|string
   */
  protected function postRaw($path, $body, $requestHeaders = array()) {
    $response = $this->client->getHttpClient()->post(
      $path,
      $body,
      $requestHeaders
    );

    return ResponseMediator::getContent($response);
  }


  /**
   * Sends a PATCH request with JSON-encoded parameters.
   *
   * @param string $path
   *   The request path.
   *
   * @param array $parameters
   *   The POST parameters to be JSON encoded.
   *
   * @param array $requestHeaders
   *   Request headers.
   */
  protected function patch($path, array $parameters = array(), $requestHeaders = array()) {
    $response = $this->client->getHttpClient()->patch(
      $path,
      $this->createJsonBody($parameters),
      $requestHeaders
    );

    return ResponseMediator::getContent($response);
  }


  /**
   * Sends a PUT request with JSON-encoded parameters.
   *
   * @param string $path
   *   The request path.
   *
   * @param array|object $parameters
   *   The POST parameters to be JSON encoded.
   *
   * @param array $requestHeaders
   *   The request headers.
   *
   * @returns ResponseMediator
   *   API response body, the object or array created by Eloqua
   */
  protected function put($path, $parameters = array(), $requestHeaders = array()) {
    $response = $this->client->getHttpClient()->put(
      $path,
      $this->createJsonBody($parameters),
      $requestHeaders
    );

    return ResponseMediator::getContent($response);
  }


  /**
   * Sends a DELETE request with JSON-encoded parameters.
   *
   * @param string $path
   *   The request path.
   *
   * @param array $parameters
   *   The POST parameters to be JSON encoded.
   *
   * @param array $requestHeaders
   *   The request headers.
   */
  protected function delete($path, array $parameters = array(), $requestHeaders = array()) {
    $response = $this->client->getHttpClient()->delete(
      $path,
      $this->createJsonBody($parameters),
      $requestHeaders
    );

    return ResponseMediator::getContent($response);
  }

  /**
   * Creates a JSON encoded version of an array of parameters.
   *
   * @param array|object $parameters
   *   The request parameters
   *
   * @return null|string
   */
  protected function createJsonBody($parameters) {
    return (count($parameters) === 0) ? null : json_encode($parameters, empty($parameters) ? JSON_FORCE_OBJECT : 0);
  }

  /**
   * Checks for required values in arrays.
   *
   * @param array $array
   * @param string $key
   *
   * @throws InvalidArgumentException
   */
  protected function validateExists($array, $key) {
    if (!array_key_exists($key, $array) || empty($array[$key])) {
      throw new InvalidArgumentException("You must specify a non-empty value for $key.");
    }
  }

  /**
   * Parses Eloqua responses into specific object types.
   * See /src/api/DataStructures for possible types.
   *
   * @param array|object $obj
   *   Response object from Eloqua API
   *
   * @param string $type
   *   Name of object to cast $obj to, ex. \Eloqua\DataStructures\CustomObject
   *
   * @return mixed
   */
  public function parse($obj, $type) {
    return $type::load($obj);
  }
}
