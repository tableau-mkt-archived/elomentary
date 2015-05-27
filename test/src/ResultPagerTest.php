<?php

namespace Eloqua\Tests;

use Eloqua;
use Eloqua\Client;
use Eloqua\ResultPager;
use Eloqua\HttpClient\HttpClientInterface;
use Eloqua\Tests\Mock\TestResponse;

/**
 * ResultPagerTest
 */
class ResultPagerTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   *
   * description fetchAll
   */
  public function shouldGetAllResults() {
    $loops = 3;
    $content = array();
    for ($i = 0; $i < 10; $i++ ){
      $content['elements'][] = array($i);
    }
    $responseMock = new TestResponse($loops, $content);

    // HttpClient mock.
    $httpClientMock = $this->getHttpClientMock($responseMock);
    $httpClientMock
      ->expects($this->exactly($loops - 1))
      ->method('get')
      ->will($this->returnValue($responseMock));

    $clientMock = $this->getClientMock($httpClientMock);

    // ContactApi Mock
    $method = 'search';
    $contactApiMock = $this->getApiMock('Eloqua\Api\Data\Contact');
    $contactApiMock
      ->expects($this->once())
      ->method($method)
      ->will($this->returnValue($content));

    // Run fetchAll on result paginator
    $paginator = new Eloqua\ResultPager($clientMock);
    $result = $paginator->fetchAll($contactApiMock, $method, array('foo*'));

    $this->assertEquals($loops * count($content['elements']), count($result['elements']));
  }

  /**
   * @test
   *
   * description fetch
   */
  public function shouldGetSomeResults() {
    $url = 'http://example.com';
    $resultContent = array(
      'page' => 2,
      'pageSize' => 10,
      'total' => 30,
    );
    $pagination = array(
      'first' => array($url => array('page' => 1, 'count' => 10)),
      'last' => array($url => array('page' => 3, 'count' => 10)),
      'next' => array($url => array('page' => 3, 'count' => 10)),
      'prev' => array($url => array('page' => 1, 'count' => 10)),
    );

    $responseMock = $this->getResponseMock($url, $resultContent);
    $httpClient = $this->getHttpClientMock($responseMock);
    $client = $this->getClientMock($httpClient);

    $contactApiMock = $this->getApiMock('Eloqua\Api\Data\Contact');

    $contactApiMock
      ->expects($this->once())
      ->method('show')
      ->with(1337)
      ->will($this->returnValue($resultContent));

    $paginator = new Eloqua\ResultPager($client);
    $result = $paginator->fetch($contactApiMock, 'show', array(1337));

    $this->assertEquals($resultContent, $result);
    $this->assertEquals($pagination, $paginator->getPagination());
  }

  /**
   * @test
   *
   * description postFetch
   */
  public function postFetch() {
    $url = 'http://example.com';
    $resultContent = array(
      'page' => 2,
      'pageSize' => 10,
      'total' => 30,
    );

    $pagination = array(
      'first' => array($url => array('page' => 1, 'count' => 10)),
      'last' => array($url => array('page' => 3, 'count' => 10)),
      'next' => array($url => array('page' => 3, 'count' => 10)),
      'prev' => array($url => array('page' => 1, 'count' => 10)),
    );

    $responseMock = $this->getResponseMock($url, $resultContent);
    $httpClient = $this->getHttpClientMock($responseMock);
    $client = $this->getClientMock($httpClient);

    $paginator = new Eloqua\ResultPager($client);
    $paginator->postFetch();

    $this->assertEquals($paginator->getPagination(), $pagination);
  }

  /**
   * @test
   *
   * description fetchNext
   */
  public function fetchNext() {
    $url = 'http://example.com';
    $resultContent = array(
      'page' => 1,
      'pageSize' => 10,
      'total' => 30,
    );

    $responseMock = $this->getResponseMock($url, $resultContent);
    // Expected 3 times, 2 for setup and 1 for the actual test
    $responseMock
      ->expects($this->exactly(3))
      ->method('getBody');

    $httpClient = $this->getHttpClientMock($responseMock);
    $httpClient
      ->expects($this->once())
      ->method('get')
      ->with($url, $this->arrayHasKey('page'))
      ->will($this->returnValue($responseMock));

    $client = $this->getClientMock($httpClient);

    $paginator = new Eloqua\ResultPager($client);
    $paginator->postFetch();

    $this->assertEquals($paginator->fetchNext(), $resultContent);
  }

  /**
   * @test
   *
   * description hasNext
   */
  public function shouldHaveNext() {
    $responseMock = $this->getResponseMock('http://example.com', array(
      'page' => 1,
      'pageSize' => 10,
      'total' => 30,
    ));
    $httpClient = $this->getHttpClientMock($responseMock);
    $client = $this->getClientMock($httpClient);

    $paginator = new Eloqua\ResultPager($client);
    $paginator->postFetch();

    $this->assertEquals($paginator->hasNext(), true);
    $this->assertEquals($paginator->hasPrevious(), false);
  }

  /**
   * @test
   */
  public function fetchPrevious() {
    $url = 'http://example.com';
    $resultContent = array(
      'page' => 3,
      'pageSize' => 10,
      'total' => 30,
    );
    $responseMock = $this->getResponseMock($url, $resultContent);
    $httpClient = $this->getHttpClientMock($responseMock);
    $httpClient
      ->expects($this->once())
      ->method('get')
      ->with($url, $this->arrayHasKey('page'))
      ->will($this->returnValue($responseMock));
    $client = $this->getClientMock($httpClient);

    $paginator = new Eloqua\ResultPager($client);
    $paginator->postFetch();

    $this->assertSame($resultContent, $paginator->fetchPrevious());
  }

  /**
   * @test
   *
   * description hasPrevious
   */
  public function shouldHavePrevious() {
    $responseMock = $this->getResponseMock('http://example.com', array(
      'page' => 3,
      'pageSize' => 10,
      'total' => 30,
    ));
    $httpClient = $this->getHttpClientMock($responseMock);
    $client = $this->getClientMock($httpClient);

    $paginator = new Eloqua\ResultPager($client);
    $paginator->postFetch();

    $this->assertEquals($paginator->hasPrevious(), true);
    $this->assertEquals($paginator->hasNext(), false);
  }

  /**
   * @test
   */
  public function fetchFirst() {
    $url = 'http://example.com';
    $resultContent = array(
      'page' => 3,
      'pageSize' => 10,
      'total' => 30,
    );
    $responseMock = $this->getResponseMock($url, $resultContent);
    $httpClient = $this->getHttpClientMock($responseMock);
    $httpClient
      ->expects($this->once())
      ->method('get')
      ->with($url, $this->arrayHasKey('page'))
      ->will($this->returnValue($responseMock));
    $client = $this->getClientMock($httpClient);

    $paginator = new Eloqua\ResultPager($client);
    $paginator->postFetch();

    $this->assertSame($resultContent, $paginator->fetchFirst());
  }

  /**
   * @test
   */
  public function fetchLast() {
    $url = 'http://example.com';
    $resultContent = array(
      'page' => 1,
      'pageSize' => 10,
      'total' => 30,
    );
    $responseMock = $this->getResponseMock($url, $resultContent);
    $httpClient = $this->getHttpClientMock($responseMock);
    $httpClient
      ->expects($this->once())
      ->method('get')
      ->with($url, $this->arrayHasKey('page'))
      ->will($this->returnValue($responseMock));
    $client = $this->getClientMock($httpClient);

    $paginator = new Eloqua\ResultPager($client);
    $paginator->postFetch();

    $this->assertSame($resultContent, $paginator->fetchLast());
  }

  protected function getResponseMock($url, $response) {
    $responseMock = $this->getMock('Guzzle\Http\Message\Response', array(), array(200));
    $responseMock
      ->expects($this->any())
      ->method('getInfo')
      ->with('url')
      ->will($this->returnValue($url));
    $responseMock
      ->expects($this->any())
      ->method('getBody')
      ->with(TRUE)
      ->will($this->returnValue(json_encode($response)));

    return $responseMock;
  }

  protected function getClientMock(HttpClientInterface $httpClient = null) {
    // if no httpClient isset use the default HttpClient mock
    if (!$httpClient) {
      $httpClient = $this->getHttpClientMock();
    }

    $client = new \Eloqua\Client($httpClient);
    $client->setHttpClient($httpClient);

    return $client;
  }

  protected function getHttpClientMock($responseMock = null) {
    // Mock the client interface.
    $clientInterfaceMock = $this->getMock('Guzzle\Http\Client', array('send'));
    $clientInterfaceMock
      ->expects($this->any())
      ->method('send');

    // Create the httpClient mock.
    $httpClientMock = $this->getMock('Eloqua\HttpClient\HttpClient', array(), array(array(), $clientInterfaceMock));

    if ($responseMock) {
      $httpClientMock
        ->expects($this->any())
        ->method('getLastResponse')
        ->will($this->returnValue($responseMock));
    }

    return $httpClientMock;
  }

  protected function getApiMock($apiClass) {
    $client = $this->getClientMock();

    return $this->getMockBuilder($apiClass)
      ->setConstructorArgs(array($client))
      ->getMock();
  }

}
