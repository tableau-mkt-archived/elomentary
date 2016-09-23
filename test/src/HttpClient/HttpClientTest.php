<?php

/**
 * @file
 * Contains \Eloqua\Tests\HttpClient\HttpClientTest.
 */

namespace Eloqua\Tests\HttpClient;

use Eloqua\HttpClient\HttpClient;
use Eloqua\HttpClient\Message\ResponseMediator;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Client as GuzzleClient;

class HttpClientTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function shouldBeAbleToPassOptionsToConstructor() {
    $httpClient = new HttpClient(array(
      'timeout' => 33
    ), $this->getBrowserMock());

    $options = $this->getPrivateProperty('Eloqua\HttpClient\HttpClient', 'options')->getValue($httpClient);
    $this->assertEquals(33, $options['timeout']);
    $this->assertEquals('https://secure.p01.eloqua.com/API/REST', $options['base_url']);
  }

  /**
   * @test
   */
  public function shouldBeAbleToSetOption() {
    $httpClient = new HttpClient(array(), $this->getBrowserMock());
    $httpClient->setOption('timeout', 1337);

    $options = $this->getPrivateProperty('Eloqua\HttpClient\HttpClient', 'options')->getValue($httpClient);
    $this->assertEquals(1337, $options['timeout']);
  }

  /**
   * @test
   */
  public function shouldSetHeaders() {
    $existingHeaders = array('foo' => 'bar', 'baz' => 'fizz');
    $headersToBeSet = array('fizz' => 'buzz', 'foo' => 'foo');
    $expectedHeaders = array_merge($existingHeaders, $headersToBeSet);

    $httpClient = new HttpClient();
    $property = $this->getPrivateProperty('Eloqua\HttpClient\HttpClient', 'headers');
    $property->setValue($httpClient, $existingHeaders);

    $httpClient->setHeaders($headersToBeSet);
    $actual = \PHPUnit_Framework_Assert::readAttribute($httpClient, 'headers');
    $this->assertSame($expectedHeaders, $actual);
  }

  /**
   * @test
   *
   * Note: GuzzleClient->setConfig() cannot be stubbed since it is declared final
   */
  public function shouldProliferateOptionsToGuzzle() {
    $guzzleMock = $this->getBrowserMock(array('addSubscriber', 'setBaseUrl'));

    $guzzleMock->expects($this->once())
      ->method('setBaseUrl')
      ->with('test/2.0');

    $httpClient = new HttpClient(array(), $guzzleMock);
    $httpClient->setOption('base_url', 'test');
  }

  /**
   * @test
   * @dataProvider getAuthenticationFullData
   */
  public function shouldAuthenticateUsingAllGivenParameters($site, $login, $password) {
    $client = new GuzzleClient();
    $listeners = $client->getEventDispatcher()->getListeners('request.before_send');
    $this->assertCount(1, $listeners);

    $httpClient = new HttpClient(array(), $client);
    $httpClient->authenticate($site, $login, $password);

    $listeners = $client->getEventDispatcher()->getListeners('request.before_send');
    $this->assertCount(2, $listeners);

    $authListener = $listeners[1][0];
    $this->assertInstanceOf('Eloqua\HttpClient\Listener\AuthListener', $authListener);
  }

  public function getAuthenticationFullData() {
    return array(
      array('My.Company', 'My.Login', 'Battery.Horse.Staple'),
    );
  }

  /**
   * @test
   */
  public function shouldDoGETRequest() {
    $path = '/some/path';
    $parameters = array('a' => 'b');
    $headers = array('c' => 'd');

    $client = $this->getBrowserMock();

    $httpClient = new HttpClient(array(), $client);
    $httpClient->get($path, $parameters, $headers);
  }

  /**
   * @test
   */
  public function shouldDoPOSTRequest() {
    $path = '/some/path';
    $body = 'a = b';
    $headers = array('c' => 'd');

    $client = $this->getBrowserMock();
    $client->expects($this->once())
      ->method('createRequest')
      ->with('POST', $path, $this->isType('array'), $body);

    $httpClient = new HttpClient(array(), $client);
    $httpClient->post($path, $body, $headers);
  }

  /**
   * @test
   */
  public function shouldDoPOSTRequestWithoutContent() {
    $path = '/some/path';

    $client = $this->getBrowserMock();
    $client->expects($this->once())
      ->method('createRequest')
      ->with('POST', $path, $this->isType('array'));

    $httpClient = new HttpClient(array(), $client);
    $httpClient->post($path);
  }

  /**
   * @test
   */
  public function shouldDoPATCHRequest() {
    $path = '/some/path';
    $body = 'a = b';
    $headers = array('c' => 'd');

    $client = $this->getBrowserMock();

    $httpClient = new HttpClient(array(), $client);
    $httpClient->patch($path, $body, $headers);
  }

  /**
   * @test
   */
  public function shouldDoDELETERequest() {
    $path = '/some/path';
    $body = 'a = b';
    $headers = array('c' => 'd');

    $client = $this->getBrowserMock();

    $httpClient = new HttpClient(array(), $client);
    $httpClient->delete($path, $body, $headers);
  }

  /**
   * @test
   */
  public function shouldDoPUTRequest() {
    $path = '/some/path';
    $headers = array('c' => 'd');

    $client = $this->getBrowserMock();

    $httpClient = new HttpClient(array(), $client);
    $httpClient->put($path, $headers);
  }

  /**
   * @test
   */
  public function shouldDoCustomRequest() {
    $path = '/some/path';
    $body = 'a = b';
    $options = array('c' => 'd');

    $client = $this->getBrowserMock();

    $httpClient = new HttpClient(array(), $client);
    $httpClient->request($path, $body, 'HEAD', $options);
  }

  /**
   * @test
   */
  public function shouldHandlePagination() {
    $url = 'http://example.com';
    $path = '/some/path';
    $body = 'a = b';
    $headers = array('c' => 'd');

    $response = new Response(200, NULL, json_encode(array(
      'page' => 2,
      'pageSize' => 10,
      'total' => 30,
    )));
    $response->setInfo(array('url' => $url));

    $expected_pagination = array(
      'first' => array($url => array('page' => 1, 'count' => 10)),
      'last' => array($url => array('page' => 3, 'count' => 10)),
      'next' => array($url => array('page' => 3, 'count' => 10)),
      'prev' => array($url => array('page' => 1, 'count' => 10)),
    );

    $client = $this->getBrowserMock();
    $httpClient = new HttpClient(array(), $client);
    $httpClient->request($path, $body, 'HEAD', $headers);

    $this->assertEquals($expected_pagination, ResponseMediator::getPagination($response));
  }

  /**
   * @test
   */
  public function shouldAllowToReturnRawContent() {
    $path = '/some/path';
    $parameters = array('a = b');
    $headers = array('c' => 'd');

    $message = $this->getMock('Guzzle\Http\Message\Response', array(), array(200));
    $message->expects($this->once())
      ->method('getBody')
      ->will($this->returnValue('Just raw context'));

    $client = $this->getBrowserMock();
    $client->expects($this->once())
      ->method('send')
      ->will($this->returnValue($message));

    $httpClient = new HttpClient(array(), $client);
    $response = $httpClient->get($path, $parameters, $headers);

    $this->assertEquals("Just raw context", $response->getBody());
    $this->assertInstanceOf('Guzzle\Http\Message\MessageInterface', $response);
  }

  /**
   * @test
   */
  public function shouldGetLastRequest() {
    $expectedProperty = 'last request';

    $httpClient = new HttpClient();
    $property = $this->getPrivateProperty('Eloqua\HttpClient\HttpClient', 'lastRequest');
    $property->setValue($httpClient, $expectedProperty);

    $this->assertEquals($expectedProperty, $httpClient->getLastRequest());
  }

  /**
   * @test
   */
  public function shouldGetLastResponse() {
    $expectedProperty = 'last response';

    $httpClient = new HttpClient();
    $property = $this->getPrivateProperty('Eloqua\HttpClient\HttpClient', 'lastResponse');
    $property->setValue($httpClient, $expectedProperty);

    $this->assertEquals($expectedProperty, $httpClient->getLastResponse());
  }

  /**
   * @test
   */
  public function shouldAddSubscriber() {
    $mockSubscriber = $this->getMock('Symfony\Component\EventDispatcher\EventSubscriberInterface');
    $listenerClient = $this->getBrowserMock(array('addSubscriber'));
    $listenerClient->expects($this->once())
      ->method('addSubscriber')
      ->with($mockSubscriber);

    $httpClient = new HttpClient(array(), $listenerClient);
    $httpClient->addSubscriber($mockSubscriber);
  }

  /**
   * @test
   * @expectedException \Eloqua\Exception\ErrorException
   */
  public function shouldThrowErrorExceptionOnLogicException() {
    $listenerClient = $this->getBrowserMock();
    $listenerClient->expects($this->once())
      ->method('send')
      ->will($this->throwException(new \LogicException()));

    $httpClient = $this->getMock('Eloqua\HttpClient\HttpClient', array('send', 'createRequest'), array(
      array(),
      $listenerClient,
    ));
    $httpClient->request('/path', '');
  }

  /**
   * @test
   * @expectedException \Eloqua\Exception\RuntimeException
   */
  public function shouldThrowRuntimeExceptionOnRuntimeException() {
    $listenerClient = $this->getBrowserMock();
    $listenerClient->expects($this->once())
      ->method('send')
      ->will($this->throwException(new \RuntimeException()));

    $httpClient = $this->getMock('Eloqua\HttpClient\HttpClient', array('send', 'createRequest'), array(
      array(),
      $listenerClient,
    ));
    $httpClient->request('/path', '');
  }

  protected function getBrowserMock(array $methods = array()) {
    $mock = $this->getMock(
      'Guzzle\Http\Client',
      array_merge(
        array('send', 'createRequest'),
        $methods
      )
    );

    $mock->expects($this->any())
      ->method('createRequest')
      ->with(
        $this->anything(),
        $this->anything(),
        $this->anything(),
        $this->anything(),
        // Ensure that all requests have a default 10 second timeout applied.
        $this->callback(function($options) {
          return $options['connect_timeout'] === 10 && $options['timeout'] === 10;
        })
      )
      ->will($this->returnValue($this->getMock('Guzzle\Http\Message\Request', array(), array('GET', 'some'))));

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
