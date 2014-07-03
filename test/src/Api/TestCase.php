<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\TestCase.
 */

namespace Eloqua\Tests\Api;

abstract class TestCase extends \PHPUnit_Framework_TestCase {

  abstract protected function getApiClass();

  protected function getApiMock($constructor_args = array()) {
    $httpClient = $this->getMock('Guzzle\Http\Client', array('send'));
    $httpClient
      ->expects($this->any())
      ->method('send');

    $mock = $this->getMock('Eloqua\HttpClient\HttpClient', array(), array(array(), $httpClient));

    $client = new \Eloqua\Client($mock);
    $client->setHttpClient($mock);

    return $this->getMockBuilder($this->getApiClass())
      ->setMethods(array('get', 'post', 'postRaw', 'patch', 'delete', 'put'))
      ->setConstructorArgs(array_merge(array($client), $constructor_args))
      ->getMock();
  }

}
