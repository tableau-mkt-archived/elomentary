<?php

/**
 * @file
 * Contains \Eloqua\HttpClient\HttpClient.
 */

namespace Eloqua\HttpClient;

use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;

use Eloqua\Exception\ErrorException;
use Eloqua\Exception\RuntimeException;
use Eloqua\HttpClient\Listener\AuthListener;
use Eloqua\HttpClient\Listener\ErrorListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Performs requests on the Eloqua REST API.
 */
class HttpClient implements HttpClientInterface {
  protected $options = array(
    'base_url' => 'https://secure.eloqua.com/API/REST',
    'version' => '2.0',
    'user_agent' => 'Elomentary (http://github.com/tableau-mkt/elomentary)',
    'timeout' => 10,
    'count' => 100,
  );

  protected $headers = array();

  private $lastResponse;
  private $lastRequest;

  /**
   * @param array $options
   * @param ClientInterface $client
   */
  public function __construct(array $options = array(), ClientInterface $client = null) {
    $this->options = array_merge($this->options, $options);
    $client = $client ?: new GuzzleClient($this->options['base_url'] . '/' . $this->options['version'], $this->options);
    $this->client  = $client;

    $this->addListener('request.error', array(new ErrorListener($this->options), 'onRequestError'));
    $this->clearHeaders();
  }

  /**
   * {@inheritDoc}
   */
  public function setOption($name, $value) {
    $this->options[$name] = $value;

    $this->client->setBaseUrl($this->options['base_url'] . '/' . $this->options['version']);
  }

  /**
   * {@inheritDoc}
   */
  public function setHeaders(array $headers) {
    $this->headers = array_merge($this->headers, $headers);
  }

  /**
   * Clears used headers
   */
  public function clearHeaders() {
    $this->headers = array(
      'Content-type' => 'application/json',
      'User-Agent' => sprintf('%s', $this->options['user_agent']),
    );
  }

  public function addListener($eventName, $listener) {
    $this->client->getEventDispatcher()->addListener($eventName, $listener);
  }

  public function addSubscriber(EventSubscriberInterface $subscriber) {
    $this->client->addSubscriber($subscriber);
  }

  /**
   * {@inheritDoc}
   */
  public function get($path, array $parameters = array(), array $headers = array()) {
    return $this->request($path, null, 'GET', $headers, array('query' => $parameters));
  }

  /**
   * {@inheritDoc}
   */
  public function post($path, $body = null, array $headers = array()) {
    return $this->request($path, $body, 'POST', $headers);
  }

  /**
   * {@inheritDoc}
   */
  public function patch($path, $body = null, array $headers = array()) {
    return $this->request($path, $body, 'PATCH', $headers);
  }

  /**
   * {@inheritDoc}
   */
  public function delete($path, $body = null, array $headers = array()) {
    return $this->request($path, $body, 'DELETE', $headers);
  }

  /**
   * {@inheritDoc}
   */
  public function put($path, $body, array $headers = array()) {
    return $this->request($path, $body, 'PUT', $headers);
  }

  /**
   * {@inheritDoc}
   */
  public function request($path, $body = null, $httpMethod = 'GET', array $headers = array(), array $options = array()) {
    $request = $this->createRequest($httpMethod, $path, $body, $headers, $options);

    try {
      $response = $this->client->send($request);
    } catch (\LogicException $e) {
      throw new ErrorException($e->getMessage());
    } catch (\RuntimeException $e) {
      throw new RuntimeException($e->getMessage());
    }

    $this->lastRequest  = $request;
    $this->lastResponse = $response;

    return $response;
  }

  /**
   * {@inheritDoc}
   */
  public function authenticate($site, $login, $password) {
    $this->addListener('request.before_send', array(
      new AuthListener($site, $login, $password), 'onRequestBeforeSend'
    ));
  }

  /**
   * @return Request
   */
  public function getLastRequest() {
    return $this->lastRequest;
  }

  /**
   * @return Response
   */
  public function getLastResponse() {
    return $this->lastResponse;
  }

  protected function createRequest($httpMethod, $path, $body = null, array $headers = array(), array $options = array()) {
    return $this->client->createRequest(
      $httpMethod,
      $path,
      array_merge($this->headers, $headers),
      $body,
      $options
    );
  }
}
