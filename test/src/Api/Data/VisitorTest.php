<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Data\VisitorTest.
 */

namespace Eloqua\Tests\Api\Data;

use Eloqua\Tests\Api\TestCase;

class VisitorTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchVisitors() {
    $guid = 'oMg-wtFBbq-1337';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('data/visitors', array('search' => "externalId=$guid"))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search("externalId=$guid"));
  }

  /**
   * @test
   */
  public function shouldSearchVisitorsWithOptions() {
    $guid = 'oMg-wtFBbq-1337';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('data/visitors', array_merge(array('search' => "externalId=$guid"), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search("externalId=$guid", $options));
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Data\Visitor';
  }

}
