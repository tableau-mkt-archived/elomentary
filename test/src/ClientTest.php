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
  public function shouldAuthenticateUsingAllGivenParameters($site, $login, $password, $baseUrl = null) {
    $httpClient = $this->getHttpClientMock();
    $httpClient->expects($this->once())
      ->method('authenticate')
      ->with($site, $login, $password);

    $client = new Client($httpClient);
    $client->authenticate($site, $login, $password, $baseUrl);
  }

  public function getAuthenticationData() {
    return array(
        array('My.Company', 'My.Login', 'Battery.Horse.Staple'),
        array('My.Company', 'My.Login', 'Battery.Horse.Staple', 'https://secure.eloqua.com/API/REST'),
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
   * @dataProvider getEndpointResponses
   */
  public function shouldReturnEndpoints($response, $expected) {
    $guzzleResponse = $this->getMock('Guzzle\Http\Message\Response', array('json'), array(''));
    $guzzleResponse
      ->expects($this->once())
      ->method('json')
      ->will($this->returnValue($response));

    $httpClient = $this->getHttpClientMock();
    $httpClient->expects($this->once())
      ->method('get')
      ->will($this->returnValue($guzzleResponse));

    $client = new Client($httpClient);
    $urls = $client->getRestEndpoints('My.Company', 'My.Login', 'Battery.Horse.Staple', $httpClient);

    $this->assertSame($urls, $expected);
  }

  public function getEndpointResponses() {
    return array(
      array (
        array (
          'urls' => array (
            'apis' => array (
              'rest' => array (
                'standard' => 'https://secure.p03.eloqua.com/API/REST/{version}/',
                'data'     => 'https://secure.p03.eloqua.com/API/Data/{version}/',
                'bulk'     => 'https://secure.p03.eloqua.com/API/Bulk/{version}/',
        )))),
        array (
          'standard' => 'https://secure.p03.eloqua.com/API/REST/',
          'data'     => 'https://secure.p03.eloqua.com/API/Data/',
          'bulk'     => 'https://secure.p03.eloqua.com/API/Bulk/',

        )
      ),

    );
  }

  /**
   * @test
   * @expectedException Exception
   */
  public function shouldThrowExceptionIfEndpointsNotReturned() {
    $guzzleResponse = $this->getMock('Guzzle\Http\Message\Response', array('json'), array(''));
    $guzzleResponse
      ->expects($this->once())
      ->method('json')
      ->will($this->returnValue(''));

    $httpClient = $this->getHttpClientMock();
    $httpClient->expects($this->once())
      ->method('get')
      ->will($this->returnValue($guzzleResponse));

    $client = new Client($httpClient);
    $urls = $client->getRestEndpoints('My.Company', 'My.Login', 'Battery.Horse.Staple', $httpClient);
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

  public function getApiClassProvider() {
    return array(
      array('contact', 'Eloqua\Api\Data\Contact'),
      array('contacts', 'Eloqua\Api\Data\Contact'),
      array('email', 'Eloqua\Api\Assets\Email'),
      array('emails', 'Eloqua\Api\Assets\Email'),
      array('customObject', 'Eloqua\Api\Data\CustomObject'),
      array('customObjects', 'Eloqua\Api\Data\CustomObject'),
    );
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
