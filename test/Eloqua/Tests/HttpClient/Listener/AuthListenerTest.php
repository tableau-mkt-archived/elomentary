<?php

/**
 * @file
 * Contains \Eloqua\Tests\HttpClient\Listener\AuthListenerTest.
 */

namespace Eloqua\Tests\HttpClient\Listener;

use Eloqua\HttpClient\Listener\AuthListener;

class AuthListenerTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   * @expectedException \Eloqua\Exception\RuntimeException
   */
  public function shouldHaveCredentials() {
    $listener = new AuthListener('', '', '');
    $listener->onRequestBeforeSend($this->getEventMock());
  }

  /**
   * @test
   */
  public function shouldSetAuthBasicHeader() {
    $expected = 'Basic ' . base64_encode('My.Company\\My.Login:Battery.Horse.Staple');

    $request = $this->getMock('Guzzle\Http\Message\RequestInterface');
    $request->expects($this->once())
      ->method('setHeader')
      ->with('Authorization', $expected);
    $request->expects($this->once())
      ->method('getHeader')
      ->with('Authorization')
      ->will($this->returnValue($expected));

    $listener = new AuthListener('My.Company', 'My.Login', 'Battery.Horse.Staple');
    $listener->onRequestBeforeSend($this->getEventMock($request));

    $this->assertEquals($expected, $request->getHeader('Authorization'));
  }

  private function getEventMock($request = null) {
    $mock = $this->getMockBuilder('Guzzle\Common\Event')->getMock();

    if ($request) {
      $mock->expects($this->any())
        ->method('offsetGet')
        ->will($this->returnValue($request));
    }

    return $mock;
  }
}
