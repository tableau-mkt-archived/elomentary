<?php

/**
 * @file
 * Contains \Eloqua\Client.
 */

namespace Eloqua;

use Eloqua\Api\ApiInterface;
use Eloqua\Exception\InvalidArgumentException;
use Eloqua\HttpClient\HttpClient;
use Eloqua\HttpClient\HttpClientInterface;

/**
 * REST client for Eloqua's API.
 */
class Client
{

  /**
   * @var array
   */
  private $options = array(
    'base_url' => 'https://secure.p01.eloqua.com/API/REST',
    'version' => '2.0',
    'user_agent' => 'Elomentary (http://github.com/tableau-mkt/elomentary)',
    'timeout' => 10,
    'count' => 100,
  );

  /**
   * The Guzzle instance used to communicate with Eloqua.
   *
   * @var HttpClient
   */
  private $httpClient;

  /**
   * Instantiate a new Eloqua client.
   *
   * @param null|HttpClientInterface $httpClient Eloqua HTTP client.
   */
  public function __construct(HttpClientInterface $httpClient = null) {
    $this->httpClient = $httpClient;
  }

  /**
   * The primary interface for interacting with different Eloqua objects.
   *
   * @param string $name
   *   The name of the API instance to return. One of:
   *   - contact: To interact with Eloqua contacts.
   *   - contact_subscription: To interact with Eloqua contact subscriptions.
   *
   * @return ApiInterface
   *
   * @throws InvalidArgumentException
   */
  public function api($name) {
    switch ($name) {
      case 'contact':
      case 'contacts':
        $api = new Api\Data\Contact($this);
        break;

      case 'email':
      case 'emails':
        $api = new Api\Assets\Email($this);
        break;

      case 'customObject':
      case 'customObjects':
        $api = new Api\Assets\CustomObject($this);
        break;

      case 'optionList':
      case 'optionLists':
        $api = new Api\Assets\OptionList($this);
        break;

      case 'program':
      case 'programs':
        $api = new Api\Assets\Program($this);
        break;

      case 'visitor':
      case 'visitors':
        $api = new Api\Data\Visitor($this);
        break;

      default:
        throw new InvalidArgumentException(sprintf('Undefined API instance: "%s"', $name));
    }

    return $api;
  }

  /**
   * Authenticate a user for all subsequent requests.
   *
   * @param string $site
   *   Eloqua site name for the instance against which requests should be made.
   *
   * @param string $login
   *   Eloqua user name with which requests should be made.
   *
   * @param string $password
   *   Password associated with the aforementioned Eloqua user.
   *
   * @param string $baseUrl
   *   Endpoint associated with the aforementioned Eloqua user.
   *
   * @param string $version
   *   API version to use.
   *
   * @throws InvalidArgumentException if any arguments are not specified.
   */
  public function authenticate($site, $login, $password, $baseUrl = null, $version = null) {
    if (empty($site) || empty($login) || empty($password)) {
      throw new InvalidArgumentException('You must specify authentication details.');
    }

    if (isset($baseUrl)) {
      $this->setOption('base_url', $baseUrl);
    }

    if (isset($version)) {
      $this->setOption('version', $version);
    }

    $this->getHttpClient()->authenticate($site, $login, $password);
  }

  /**
   * Gets REST endpoints associated with authentication parameters
   *
   * @param string $site
   *   Eloqua site name for the instance against which requests should be made.
   *
   * @param string $login
   *   Eloqua user name with which requests should be made.
   *
   * @param string $password
   *   Password associated with the aforementioned Eloqua user.
   *
   * @param HttpClientInterface $client
   *   Provides HttpClientInterface dependency injection.
   *
   * @returns array
   *   The list of urls associated with the aforementioned Eloqua user, with the
   *   '/{version}/' part removed.
   *
   * @see http://topliners.eloqua.com/community/code_it/blog/2012/11/30/using-the-eloqua-api--determining-endpoint-urls-logineloquacom
   */
  public function getRestEndpoints($site, $login, $password, HttpClientInterface $client = null) {
    $client = $client ?: new HttpClient(array (
      'base_url' => 'https://login.eloqua.com/id', // @codeCoverageIgnore
      'version'  => '', // @codeCoverageIgnore
    ));

    $authHeader = array (
      'Authorization' => sprintf('Basic %s', base64_encode("$site\\$login:$password")),
    );

    $response = $client->get('https://login.eloqua.com/id', array(), $authHeader);

    $loginObj = $response->json();
    $urls     = $loginObj['urls']['apis']['rest'];

    $stripVersion = function($url) {
      return str_replace('/{version}/', '/', $url);
    };

    return array_map($stripVersion, $urls);
  }

  /**
   * Returns the HttpClient.
   *
   * @return HttpClient
   */
  public function getHttpClient() {
    if ($this->httpClient === NULL) {
      $this->httpClient = new HttpClient($this->options);
    }

    return $this->httpClient;
  }

  /**
   * Sets the HttpClient.
   *
   * @param HttpClientInterface $httpClient
   */
  public function setHttpClient(HttpClientInterface $httpClient) {
    $this->httpClient = $httpClient;
  }

  /**
   * Clears headers.
   */
  public function clearHeaders() {
    $this->getHttpClient()->clearHeaders();
  }

  /**
   * Sets headers.
   *
   * @param array $headers
   */
  public function setHeaders(array $headers) {
    $this->getHttpClient()->setHeaders($headers);
  }

  /**
   * Returns a named option.
   *
   * @param string $name
   *
   * @return mixed
   *
   * @throws InvalidArgumentException
   */
  public function getOption($name) {
    if (!array_key_exists($name, $this->options)) {
      throw new InvalidArgumentException(sprintf('Undefined option: "%s"', $name));
    }

    return $this->options[$name];
  }

  /**
   * Sets a named option.
   *
   * @param string $name
   * @param mixed  $value
   *
   * @throws InvalidArgumentException
   */
  public function setOption($name, $value) {
    if (!array_key_exists($name, $this->options)) {
      throw new InvalidArgumentException(sprintf('Undefined option: "%s"', $name));
    }

    $this->options[$name] = $value;
    $this->getHttpClient()->setOption($name, $value);
  }

}
