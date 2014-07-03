<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Data\Contact\FilterTest.
 */

namespace Eloqua\Tests\Api\Data\Contact;

use Eloqua\Tests\Api\TestCase;

class FilterTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchFilter() {
    $contact_filter_id = 1337;
    $contact_email = '*';
    $expected_response = array('response');

    $api = $this->getApiMock(array($contact_filter_id));
    $api->expects($this->once())
      ->method('get')
      ->with('data/contacts/filter/' . $contact_filter_id)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($contact_email));
  }

  /**
   * @test
   */
  public function shouldSearchFilterWithOptions() {
    $contact_filter_id = 1337;
    $contact_email = '*';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock(array($contact_filter_id));
    $api->expects($this->once())
      ->method('get')
      ->with('data/contacts/filter/' . $contact_filter_id, array_merge(array('search' => $contact_email), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($contact_email, $options));
  }

  /**
   * @test
   */
  public function shouldExportFilter() {
    $contact_filter_id = 1337;
    $contact_filter_data = array();

    $api = $this->getApiMock(array($contact_filter_id));
    $api->expects($this->once())
      ->method('post')
      ->with('data/contacts/filter/' . $contact_filter_id . '/export')
      ->will($this->returnValue($contact_filter_data));

    $this->assertEquals($contact_filter_data, $api->export($contact_filter_data));
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Data\Contact\Filter';
  }

}
