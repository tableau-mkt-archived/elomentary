<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Data\Contact\SegmentTest.
 */

namespace Eloqua\Tests\Api\Data\Contact;

use Eloqua\Tests\Api\TestCase;

class SegmentTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchSegment() {
    $segment_list_id = 1337;
    $contact_email = '*';
    $expected_response = array('response');

    $api = $this->getApiMock(array($segment_list_id));
    $api->expects($this->once())
      ->method('get')
      ->with('data/contacts/segment/' . $segment_list_id)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($contact_email));
  }

  /**
   * @test
   */
  public function shouldSearchSegmentWithOptions() {
    $segment_list_id = 1337;
    $contact_email = '*';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock(array($segment_list_id));
    $api->expects($this->once())
      ->method('get')
      ->with('data/contacts/segment/' . $segment_list_id, array_merge(array('search' => $contact_email), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($contact_email, $options));
  }

  /**
   * @test
   */
  public function shouldSearchSegmentIncluded() {
    $segment_list_id = 1337;
    $contact_email = '*';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock(array($segment_list_id));
    $api->expects($this->once())
      ->method('get')
      ->with('data/contacts/segment/' . $segment_list_id . '/included', array_merge(array('search' => $contact_email), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->searchIncluded($contact_email, $options));
  }

  /**
   * @test
   */
  public function shouldSearchSegmentExcluded() {
    $segment_list_id = 1337;
    $contact_email = '*';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock(array($segment_list_id));
    $api->expects($this->once())
      ->method('get')
      ->with('data/contacts/segment/' . $segment_list_id . '/excluded', array_merge(array('search' => $contact_email), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->searchExcluded($contact_email, $options));
  }

  /**
   * @test
   */
  public function shouldExportSegment() {
    $segment_list_id = 1337;
    $contact_segment_data = array();

    $api = $this->getApiMock(array($segment_list_id));
    $api->expects($this->once())
      ->method('post')
      ->with('data/contacts/segment/' . $segment_list_id . '/export')
      ->will($this->returnValue($contact_segment_data));

    $this->assertEquals($contact_segment_data, $api->export($contact_segment_data));
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Data\Contact\Segment';
  }

}
