<?php

/**
 * @file
 * Contains \Eloqua\Tests\ClientTest.
 */

namespace Eloqua\Tests;

use Eloqua\Client;
use Eloqua\Exception\InvalidArgumentException;

class ClientTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function shouldNotHaveToPassHttpClientToConstructor() {
    $client = new Client();
    $this->assertInstanceOf('Eloqua\HttpClient\HttpClient', $client->getHttpClient());
  }

  /**
   * @test
   */
  public function shouldPassHttpClientInterfaceToConstructor() {
    $client = new Client($this->getHttpClientMock());
    $this->assertInstanceOf('Eloqua\HttpClient\HttpClientInterface', $client->getHttpClient());
  }

  /**
   * @test
   * @dataProvider getAuthenticationData
   */
  public function shouldAuthenticateUsingAllGivenParameters($site, $login, $password) {
    $httpClient = $this->getHttpClientMock();
    $httpClient->expects($this->once())
      ->method('authenticate')
      ->with($site, $login, $password);

    $client = new Client($httpClient);
    $client->authenticate($site, $login, $password);
  }

  public function getAuthenticationData() {
    return array(
      array('My.Company', 'My.Login', 'Battery.Horse.Staple'),
    );
  }

  /**
   * @test
   * @expectedException InvalidArgumentException
   */
  public function shouldThrowExceptionWhenAuthenticatingWithEmptyCreds()
  {
    $httpClient = $this->getHttpClientMock(array('addListener'));

    $client = new Client($httpClient);
    $client->authenticate('', '', '');
  }

  /**
   * @test
   */
  public function shouldClearHeaders() {
    $httpClient = $this->getHttpClientMock(array('clearHeaders'));
    $httpClient->expects($this->once())->method('clearHeaders');

    $client = new Client($httpClient);
    $client->clearHeaders();
  }

  /**
   * @test
   */
  public function shouldSetHeaders() {
    $headers = array('header1', 'header2');

    $httpClient = $this->getHttpClientMock();
    $httpClient->expects($this->once())->method('setHeaders')->with($headers);

    $client = new Client($httpClient);
    $client->setHeaders($headers);
  }

  /**
   * @test
   * @dataProvider getApiClassProvider
   */
  public function shouldGetApiInstance($apiName, $class) {
    $client = new Client();
    $this->assertInstanceOf($class, $client->api($apiName));
  }

  /**
   * @test
   * @expectedException InvalidArgumentException
   */
  public function shouldNotGetApiInstance() {
    $client = new Client();
    $client->api('not_a_thing');
  }

  public function getApiClassProvider() {
    return array(
      array('contact', 'Eloqua\Api\Data\Contact'),
      array('contacts', 'Eloqua\Api\Data\Contact'),
    );
  }

  public function getHttpClientMock(array $methods = array()) {
    $methods = array_merge(
      array('get', 'post', 'patch', 'put', 'delete', 'request', 'setOption', 'setHeaders', 'authenticate'),
      $methods
    );

    return $this->getMock('Eloqua\HttpClient\HttpClientInterface', $methods);
  }

}
