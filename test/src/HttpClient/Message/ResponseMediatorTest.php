<?php

/**
 * @file
 * Contains \Eloqua\Tests\HttpClient\Message\ResponseMediatorTest.
 */

namespace Eloqua\Tests\HttpClient\Message;


use Eloqua\HttpClient\Message\ResponseMediator;

class ResponseMediatorTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function shouldReturnRawBodyOnJsonError() {
    $expectedResponse = 'not{json}';

    $listenerResponse = $this->getmock('Guzzle\Http\Message\Response', array(), array(200));
    $listenerResponse->expects($this->once())
      ->method('getBody')
      ->with(TRUE)
      ->will($this->returnValue($expectedResponse));

    $this->assertEquals($expectedResponse, ResponseMediator::getContent($listenerResponse));
  }

  /**
   * @test
   */
  public function shouldReturnNullPaginationOnImproperResponse() {
    $mockResponse = array();

    $listenerResponse = $this->getMock('Guzzle\Http\Message\Response', array(), array(200));
    $listenerResponse->expects($this->once())
      ->method('getBody')
      ->with(TRUE)
      ->will($this->returnValue(json_encode($mockResponse)));

    $this->assertSame(NULL, ResponseMediator::getPagination($listenerResponse));

  }

}
