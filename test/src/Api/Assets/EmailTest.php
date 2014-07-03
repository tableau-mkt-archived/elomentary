<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Assets\EmailTest.
 */

namespace Eloqua\Tests\Api\Assets;

use Eloqua\Tests\Api\TestCase;

class EmailTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchEmails() {
    $term = 'Never Gonna Give*';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/emails', array('search' => $term))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($term));
  }

  /**
   * @test
   */
  public function shouldSearchEmailsWithOptions() {
    $term = 'Never Gonna Give*';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/emails', array_merge(array('search' => $term), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($term, $options));
  }

  /**
   * @test
   */
  public function shouldGetGroups() {
    $api = $this->getApiMock();
    $this->assertInstanceOf('Eloqua\Api\Assets\Email\Group', $api->groups());
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Assets\Email';
  }

}
