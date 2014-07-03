<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Data\Contact\ContactListTest.
 */

namespace Eloqua\Tests\Api\Data\Contact;

use Eloqua\Tests\Api\TestCase;

class ContactListTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchList() {
    $contact_list_id = 1337;
    $contact_email = '*';
    $expected_response = array('response');

    $api = $this->getApiMock(array($contact_list_id));
    $api->expects($this->once())
      ->method('get')
      ->with('data/contacts/list/' . $contact_list_id)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($contact_email));
  }

  /**
   * @test
   */
  public function shouldSearchListWithOptions() {
    $contact_list_id = 1337;
    $contact_email = '*';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock(array($contact_list_id));
    $api->expects($this->once())
      ->method('get')
      ->with('data/contacts/list/' . $contact_list_id, array_merge(array('search' => $contact_email), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($contact_email, $options));
  }

  /**
   * @test
   */
  public function shouldExportList() {
    $contact_list_id = 1337;
    $contact_list_data = array();

    $api = $this->getApiMock(array($contact_list_id));
    $api->expects($this->once())
      ->method('post')
      ->with('data/contacts/list/' . $contact_list_id . '/export')
      ->will($this->returnValue($contact_list_data));

    $this->assertEquals($contact_list_data, $api->export($contact_list_data));
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Data\Contact\ContactList';
  }

}
