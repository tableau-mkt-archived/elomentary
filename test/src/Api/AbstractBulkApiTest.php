<?php

namespace Eloqua\Tests\Api;


class AbstractBulkApiTest extends \PHPUnit_Framework_TestCase {
  /**
   * @test
   */
  public function shouldGetAndSetResponse() {
    $key = '1';
    $value = '2';
    $mock = $this->getMockForAbstractClass('Eloqua\Api\AbstractBulkApi', array(), '', false);

    $mock->setResponse($key, $value);
    $this->assertEquals($value, $mock->getResponse($key));
  }

  /**
   * @test
   */
  public function shouldGetExpectedResponse() {
    $key = '1';
    $value = '2';
    $expected = '3';
    $mock = $this->getMockForAbstractClass('Eloqua\Api\AbstractBulkApi', array(), '', false);

    $mock->setResponse($key, $value);
    $this->assertEquals($expected, $mock->getResponse($key, $expected));
  }

  /**
   * @test
   * @expectedException InvalidArgumentException
   */
  public function shouldThrowExceptionOnUnavailableResponse() {
    $key = '1';
    $mock = $this->getMockForAbstractClass('Eloqua\Api\AbstractBulkApi', array(), '', false);

    $mock->getResponse($key);
  }

  /**
   * @test
   */
  public function shouldMap() {
    $input = '1';
    $return = '2';

    $mock = $this->getBulkMock(null, null, 'map', $return);
    $mock->expects($this->once())
      ->method('post')
      ->with($this->anything(), $input)
      ->will($this->returnValue($return));

    $this->assertEquals($return, $mock->map($input));
  }

  /**
   * @test
   */
  public function shouldUpload() {
    $input = '1';
    $mapResponse = array ('uri' => '/test/');
    $return = '2';

    $uriInput = trim($mapResponse['uri'], '/');

    $mock = $this->getBulkMock('map', $mapResponse, 'load', $return);
    $mock->expects($this->once())
      ->method('post')
      ->with("$uriInput/data", $input)
      ->will($this->returnValue($return));

    $this->assertEquals($return, $mock->upload($input));
  }

  /**
   * @test
   */
  public function shouldSync() {
    $return = '1';
    $mapResponse = array ('uri' => '/test/');
    $syncedInstanceUri = array ('syncedInstanceUri' => $mapResponse['uri']);

    $mock = $this->getBulkMock('map', $mapResponse, 'sync', $return);
    $mock->expects($this->once())
      ->method('post')
      ->with('syncs', $syncedInstanceUri)
      ->will($this->returnValue($return));

    $this->assertEquals($return, $mock->sync());
  }

  /**
   * @test
   */
  public function shouldCheckWaitingStatus() {
    $syncResponse = array ('uri' => '/test/');
    $return = '1';

    $mock = $this->getBulkMock('sync', $syncResponse, 'status', $return);
    $mock->expects($this->once())
      ->method('get')
      ->with(trim($syncResponse['uri'], '/'))
      ->will($this->returnValue($return));

    $this->assertEquals($return, $mock->status(false));
  }

  /**
   * @test
   * @dataProvider waitingStatusProvider
   */
  public function shouldReturnCorrectWaitingStatus($status, $expected) {
    $status = array ('status' => $status);

    $mock = $this->getBulkMock();
    $this->assertEquals($expected, $mock->isWaitingStatus($status));
  }

  public function waitingStatusProvider() {
    return array (
      array ('active', true),
      array ('pending', true),
      array ('something-else', false),
    );
  }

  /**
   * @test
   */
  public function shouldDownload() {
    $return = '1';
    $statusResponse = array ('syncedInstanceUri' => '/test/');
    $uri = trim($statusResponse['syncedInstanceUri'], '/');

    $mock = $this->getBulkMock('status', $statusResponse);
    $mock->expects($this->once())
      ->method('get')
      ->with("$uri/data")
      ->will($this->returnValue($return));

    $this->assertEquals($return, $mock->download());
  }

  /**
   * @test
   */
  public function shouldRequestLog() {
    $statusResponse = array ('uri' => '/test/');
    $uri = trim($statusResponse['uri'], '/');
    $return = '1';

    $mock = $this->getBulkMock('status', $statusResponse);
    $mock->expects($this->once())
      ->method('get')
      ->with("$uri/logs")
      ->will($this->returnValue($return));

    $this->assertEquals($return, $mock->log());
  }

  /**
   * Helper for getting AbstractBulkApi mock
   *
   * @param string $getResponseMethod
   *   Value to be passed to getResponse()
   *
   * @param mixed $getResponseValue
   *   Value to be returned from getResponse()
   *
   * @param string $setResponseMethod
   *   Value to be passed to setResponse()
   *
   * @param mixed $setResponseValue
   *   Value to be returned from setResponse()
   *
   * @return \PHPUnit_Framework_MockObject_MockObject
   */
  public function getBulkMock($getResponseMethod = null, $getResponseValue = null, $setResponseMethod = null, $setResponseValue = null) {
    $httpClient = $this->getMock('Guzzle\Http\Client', array('send'));
    $httpClient
      ->expects($this->any())
      ->method('send');

    $mock = $this->getMock('Eloqua\HttpClient\HttpClient', array(), array(array(), $httpClient));

    $client = new \Eloqua\Client($mock);
    $client->setHttpClient($mock);

    $bulkMock = $this->getMockForAbstractClass('Eloqua\Api\AbstractBulkApi', array($client), '', TRUE, TRUE, TRUE, array('post', 'get', 'setResponse', 'getResponse'));

    if (isset($getResponseMethod)) {
      $bulkMock->expects($this->once())
        ->method('getResponse')
        ->with($getResponseMethod, null)
        ->will($this->returnValue($getResponseValue));
    }

    if (isset($setResponseMethod)) {
      $bulkMock->expects($this->once())
        ->method('setResponse')
        ->with($setResponseMethod, $setResponseValue)
        ->will($this->returnValue($setResponseValue));
    }

    return $bulkMock;
  }
}
