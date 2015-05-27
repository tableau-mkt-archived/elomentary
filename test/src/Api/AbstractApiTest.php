<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\AbstractApiTest.
 */

namespace Eloqua\Tests\Api;

use Eloqua\Api\AbstractApi;

class AbstractApiTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function shouldPassGETRequestToClient() {
    $expectedPath = '/path';
    $expectedCount = 1;
    $expectedArray = array('value');
    $expectedArg1 = array('param1' => 'param1value');
    $expectedArg2 = array('header1' => 'header1value');

    $listenerResponse = $this->getMock('Guzzle\Http\Message\Response', array(), array(200));
    $listenerResponse->expects($this->once())
      ->method('getBody')
      ->will($this->returnValue(json_encode($expectedArray)));

    $httpClient = $this->getHttpMock();
    $httpClient
      ->expects($this->any())
      ->method('get')
      ->with($expectedPath, $expectedArg1 + array('count' => $expectedCount), $expectedArg2)
      ->will($this->returnValue($listenerResponse));
    $client = $this->getClientMock();
    $client->setHttpClient($httpClient);

    $api = $this->getAbstractApiObject($client);
    $api->setCount($expectedCount);

    $this->assertEquals($expectedArray, $api->get($expectedPath, $expectedArg1, $expectedArg2));
  }

  /**
   * @test
   */
  public function shouldPassPOSTRequestToClient() {
    $expectedPath = '/path';
    $expectedArray = array('value');
    $expectedArg1 = array('param1' => 'param1value');
    $expectedArg2 = array('option1' => 'option1value');

    $listenerResponse = $this->getMock('Guzzle\Http\Message\Response', array(), array(200));
    $listenerResponse->expects($this->once())
      ->method('getBody')
      ->will($this->returnValue(json_encode($expectedArray)));

    $httpClient = $this->getHttpMock();
    $httpClient
      ->expects($this->once())
      ->method('post')
      ->with($expectedPath, json_encode($expectedArg1), $expectedArg2)
      ->will($this->returnValue($listenerResponse));
    $client = $this->getClientMock();
    $client->setHttpClient($httpClient);

    $api = $this->getAbstractApiObject($client);

    $this->assertEquals($expectedArray, $api->post($expectedPath, $expectedArg1, $expectedArg2));
  }

  /**
   * @test
   */
  public function shouldPassPATCHRequestToClient() {
    $expectedPath = '/path';
    $expectedArray = array('value');
    $expectedArg1 = array('param1' => 'param1value');
    $expectedArg2 = array('option1' => 'option1value');

    $listenerResponse = $this->getMock('Guzzle\Http\Message\Response', array(), array(200));
    $listenerResponse->expects($this->once())
      ->method('getBody')
      ->will($this->returnValue(json_encode($expectedArray)));

    $httpClient = $this->getHttpMock();
    $httpClient
      ->expects($this->once())
      ->method('patch')
      ->with($expectedPath, json_encode($expectedArg1), $expectedArg2)
      ->will($this->returnValue($listenerResponse));
    $client = $this->getClientMock();
    $client->setHttpClient($httpClient);

    $api = $this->getAbstractApiObject($client);

    $this->assertEquals($expectedArray, $api->patch($expectedPath, $expectedArg1, $expectedArg2));
  }

  /**
   * @test
   */
  public function shouldPassPUTRequestToClient() {
    $expectedPath = '/path';
    $expectedArray = array('value');
    $expectedArg1 = array('param1' => 'param1value');
    $expectedArg2 = array('option1' => 'option1value');

    $listenerResponse = $this->getMock('Guzzle\Http\Message\Response', array(), array(200));
    $listenerResponse->expects($this->once())
      ->method('getBody')
      ->will($this->returnValue(json_encode($expectedArray)));

    $httpClient = $this->getHttpMock();
    $httpClient
      ->expects($this->once())
      ->method('put')
      ->with($expectedPath, json_encode($expectedArg1), $expectedArg2)
      ->will($this->returnValue($listenerResponse));
    $client = $this->getClientMock();
    $client->setHttpClient($httpClient);

    $api = $this->getAbstractApiObject($client);

    $this->assertEquals($expectedArray, $api->put($expectedPath, $expectedArg1, $expectedArg2));
  }

  /**
   * @test
   */
  public function shouldPassDELETERequestToClient() {
    $expectedPath = '/path';
    $expectedArray = array('value');
    $expectedArg1 = array('param1' => 'param1value');
    $expectedArg2 = array('option1' => 'option1value');

    $listenerResponse = $this->getMock('Guzzle\Http\Message\Response', array(), array(200));
    $listenerResponse->expects($this->once())
      ->method('getBody')
      ->will($this->returnValue(json_encode($expectedArray)));

    $httpClient = $this->getHttpMock();
    $httpClient
      ->expects($this->once())
      ->method('delete')
      ->with($expectedPath, json_encode($expectedArg1), $expectedArg2)
      ->will($this->returnValue($listenerResponse));
    $client = $this->getClientMock();
    $client->setHttpClient($httpClient);

    $api = $this->getAbstractApiObject($client);

    $this->assertEquals($expectedArray, $api->delete($expectedPath, $expectedArg1, $expectedArg2));
  }

  /**
   * @test
   * @dataProvider baseUrlTestProvider
   */
  public function shouldSetBaseUrl($childClass, $requestedUrl) {
    $client = $this->getMock('Eloqua\Client', array('setOption'), array($this->getHttpMock()));

    $client->expects($this->once())
      ->method('setOption')
      ->with('base_url', $requestedUrl);

    $this->getMockForAbstractClass($childClass, array($client));
  }

  /**
   * @test
   */
  public function shouldSetCount() {
    $expectedCount = 123;

    $api = $this->getAbstractApiObject($this->getClientMock());
    $response = $api->setCount($expectedCount);

    $this->assertEquals($expectedCount, \PHPUnit_Framework_Assert::readAttribute($api, 'count'));
    $this->assertInstanceOf('Eloqua\Api\AbstractApi', $response);
  }

  /**
   * @test
   */
  public function shouldGetCount() {
    $expectedCount = 321;

    $api = $this->getAbstractApiObject($this->getClientMock());
    $property = $this->getPrivateProperty('Eloqua\Api\AbstractApi', 'count');
    $property->setValue($api, $expectedCount);

    $this->assertEquals($expectedCount, $api->getCount());
  }

  public function baseUrlTestProvider() {
    return array (
      array ('Eloqua\Api\AbstractApi', 'https://secure.eloqua.com/API/REST'),
      array ('Eloqua\Api\AbstractBulkApi', 'https://secure.eloqua.com/API/bulk'),
    );
  }

  protected function getAbstractApiObject($client) {
    return new AbstractApiTestInstance($client);
  }

  /**
   * @return \Eloqua\Client
   */
  protected function getClientMock() {
    return new \Eloqua\Client($this->getHttpMock());
  }

  /**
   * @return \Eloqua\HttpClient\HttpClientInterface
   */
  protected function getHttpMock() {
    return $this->getMock('Eloqua\HttpClient\HttpClient', array(), array(array(), $this->getHttpClientMock()));
  }

  protected function getHttpClientMock() {
    $mock = $this->getMock('Guzzle\Http\Client', array('send'));
    $mock
      ->expects($this->any())
      ->method('send');

    return $mock;
  }

  /**
   * Returns a private property.
   *
   * @param string $className
   * @param string $propertyName
   * @return \ReflectionProperty
   */
  protected function getPrivateProperty($className, $propertyName) {
    $reflector = new \ReflectionClass( $className );
    $property = $reflector->getProperty( $propertyName );
    $property->setAccessible( true );

    return $property;
  }

}

class AbstractApiTestInstance extends AbstractApi {

  /**
   * {@inheritDoc}
   */
  public function get($path, array $parameters = array(), $requestHeaders = array()) {
    return parent::get($path, $parameters, $requestHeaders);
  }

  /**
   * {@inheritDoc}
   */
  public function post($path, $parameters = array(), $requestHeaders = array()) {
    return parent::post($path, $parameters, $requestHeaders);
  }

  /**
   * {@inheritDoc}
   */
  public function patch($path, array $parameters = array(), $requestHeaders = array()) {
    return parent::patch($path, $parameters, $requestHeaders);
  }

  /**
   * {@inheritDoc}
   */
  public function put($path, $parameters = array(), $requestHeaders = array()) {
    return parent::put($path, $parameters, $requestHeaders);
  }

  /**
   * {@inheritDoc}
   */
  public function delete($path, array $parameters = array(), $requestHeaders = array()) {
    return parent::delete($path, $parameters, $requestHeaders);
  }

  /**
   * @{inheritdoc}
   */
  public function search($search, array $options = array()) {}

}

class ExposedAbstractApiTestInstance extends AbstractApi {

  /**
   * {@inheritDoc}
   */
  public function get($path, array $parameters = array(), $requestHeaders = array()) {
    return parent::get($path, $parameters, $requestHeaders);
  }


  /**
   * @{inheritdoc}
   */
  public function search($search, array $options = array()) {}

}
