<?php

namespace Eloqua;

use Eloqua\Api\ApiInterface;
use Eloqua\HttpClient\Message\ResponseMediator;

/**
 * Pager class for supporting pagination in Eloqua classes
 */
class ResultPager implements ResultPagerInterface {
  /**
   * @var \Eloqua\Client client
   */
  protected $client;

  /**
   * @var array pagination
   * Comes from pagination details in Eloqua API results
   */
  protected $pagination;

  /**
   * The Eloqua client to use for pagination. This must be the same instance
   * from which you got the API instance:
   *
   * $client = new \Eloqua\Client();
   * $api = $client->api('someApi');
   * $pager = new \Eloqua\ResultPager($client);
   *
   * @param \Eloqua\Client $client
   *
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }

  /**
   * {@inheritdoc}
   */
  public function getPagination() {
    return $this->pagination;
  }

  /**
   * {@inheritdoc}
   */
  public function fetch(ApiInterface $api, $method, array $parameters = array()) {
    $result = call_user_func_array(array($api, $method), $parameters);
    $this->postFetch();

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function fetchAll(ApiInterface $api, $method, array $parameters = array()) {
    // Get the perPage from the API.
    $perPage = $api->getCount();

    // Set parameters count to Eloqua max to minimize number of requests
    $api->setCount(1000);

    $result = call_user_func_array(array($api, $method), $parameters);
    $this->postFetch();

    while ($this->hasNext()) {
      $next = $this->fetchNext();
      $result['elements'] = array_merge($result['elements'], $next['elements']);
    }

    // Restore the original perPage
    $api->setCount($perPage);

    // Blow away the pager data; it's irrelevant now.
    unset($result['page'], $result['pageSize'], $result['total']);

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function postFetch() {
    $this->pagination = ResponseMediator::getPagination($this->client->getHttpClient()->getLastResponse());
  }

  /**
   * {@inheritdoc}
   */
  public function hasNext() {
    return $this->has('next');
  }

  /**
   * {@inheritdoc}
   */
  public function fetchNext() {
    return $this->get('next');
  }

  /**
   * {@inheritdoc}
   */
  public function hasPrevious() {
    return $this->has('prev');
  }

  /**
   * {@inheritdoc}
   */
  public function fetchPrevious() {
    return $this->get('prev');
  }

  /**
   * {@inheritdoc}
   */
  public function fetchFirst() {
    return $this->get('first');
  }

  /**
   * {@inheritdoc}
   */
  public function fetchLast() {
    return $this->get('last');
  }

  /**
   * {@inheritdoc}
   */
  protected function has($key) {
    return !empty($this->pagination) && isset($this->pagination[$key]);
  }

  /**
   * {@inheritdoc}
   */
  protected function get($key) {
    if ($this->has($key)) {
      $url = key($this->pagination[$key]);
      $result = $this->client->getHttpClient()->get($url, $this->pagination[$key][$url]);
      $this->postFetch();

      return ResponseMediator::getContent($result);
    }
  } // @codeCoverageIgnore
}