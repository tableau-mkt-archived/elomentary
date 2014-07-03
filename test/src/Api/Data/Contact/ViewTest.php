<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Data\Contact\View.
 */

namespace Eloqua\Tests\Api\Data\Contact;

use Eloqua\Tests\Api\TestCase;

class ViewTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchView() {
    $contact_view_id = 1337;
    $contact_email = '*';
    $expected_response = array('response');

    $api = $this->getApiMock(array($contact_view_id));
    $api->expects($this->once())
      ->method('get')
      ->with('data/contact/view/' . $contact_view_id . '/contacts')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($contact_email));
  }

  /**
   * @test
   */
  public function shouldSearchViewWithOptions() {
    $contact_view_id = 1337;
    $contact_email = '*';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock(array($contact_view_id));
    $api->expects($this->once())
      ->method('get')
      ->with('data/contact/view/' . $contact_view_id . '/contacts', array_merge(array('search' => $contact_email), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($contact_email, $options));
  }

  /**
   * @test
   */
  public function shouldShowContactView() {
    $contact_view_id = 1337;
    $contact_id = 7331;
    $contact_list_data = array();

    $api = $this->getApiMock(array($contact_view_id));
    $api->expects($this->once())
      ->method('get')
      ->with('data/contact/view/' . $contact_view_id . '/contact/' . $contact_id)
      ->will($this->returnValue($contact_list_data));

    $this->assertEquals($contact_list_data, $api->show($contact_id));
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Data\Contact\View';
  }

}
