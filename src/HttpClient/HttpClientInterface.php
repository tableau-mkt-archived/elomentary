<?php

/**
 * @file
 * Contains \Eloqua\HttpClient\HttpClientInterface.
 */

namespace Eloqua\HttpClient;

use Eloqua\Exception\InvalidArgumentException;

/**
 * Performs requests on the Eloqua REST API.
 */
interface HttpClientInterface
{
  /**
   * Sends a GET request.
   *
   * @param string $path
   *   The request path.
   *
   * @param array $parameters
   *   GET request parameters.
   *
   * @param array $headers
   *   Request headers for this call only.
   *
   * @return array
   */
  public function get($path, array $parameters = array(), array $headers = array());

  /**
   * Sends a POST request.
   *
   * @param string $path
   *   The request path.
   *
   * @param mixed $body
   *   The request body.
   *
   * @param array $headers
   *   Request headers for this call only.
   *
   * @return array
   */
  public function post($path, $body = null, array $headers = array());

  /**
   * Sends a PATCH request.
   *
   * @param string $path
   *   The request path.
   *
   * @param mixed $body
   *   The request body.
   *
   * @param array $headers
   *   Request headers for this call only.
   *
   * @return array
   */
  public function patch($path, $body = null, array $headers = array());

  /**
   * Sends a PUT request.
   *
   * @param string $path
   *   The request path
   *
   * @param mixed $body
   *   The request body.
   *
   * @param array $headers
   *   Request headers for this call only.
   *
   * @return array
   */
  public function put($path, $body, array $headers = array());

  /**
   * Sends a DELETE request.
   *
   * @param string $path
   *   The request path.
   *
   * @param mixed $body
   *   The request body.
   *
   * @param array $headers
   *   Request headers for this call only.
   *
   * @return array
   */
  public function delete($path, $body = null, array $headers = array());

  /**
   * Sends a request to the server, receives a response, decodes the response
   * and returns an associative array of data.
   *
   * @param string $path
   *   The request path.
   *
   * @param mixed $body
   *   The request body.
   *
   * @param string $httpMethod
   *   The HTTP request method to be used.
   *
   * @param array $headers
   *   The request headers.
   *
   * @return array
   */
  public function request($path, $body, $httpMethod = 'GET', array $headers = array());

  /**
   * Changes an option value.
   *
   * @param string $name
   *   The option name.
   *
   * @param mixed $value
   *   The optional value.
   *
   * @throws InvalidArgumentException
   */
  public function setOption($name, $value);

  /**
   * Sets HTTP headers
   *
   * @param array $headers
   */
  public function setHeaders(array $headers);

  /**
   * @param string $site
   *   Eloqua site name for the instance against which requests should be made.
   *
   * @param string $login
   *   Eloqua user name with which requests should be made.
   *
   * @param string $password
   *   Password associated with the aforementioned Eloqua user.
   */
  public function authenticate($site, $login, $password);
}