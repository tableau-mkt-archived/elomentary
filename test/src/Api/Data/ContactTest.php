<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Data\ContactTest.
 */

namespace Eloqua\Tests\Api\Data;

use Eloqua\Exception\InvalidArgumentException;
use Eloqua\Tests\Api\TestCase;

class ContactTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchContacts() {
    $email_address = 'foobar@example.com';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('data/contacts', array('search' => $email_address))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($email_address));
  }

  /**
   * @test
   */
  public function shouldSearchContactsWithOptions() {
    $email_address = 'foobar@example.com';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('data/contacts', array_merge(array('search' => $email_address), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($email_address, $options));
  }

  /**
   * @test
   */
  public function shouldShowContact() {
    $contact_id = 1337;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('data/contact/' . $contact_id)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($contact_id));
  }

  /**
   * @test
   */
  public function shouldUpdateContact() {
    $contact_id = 1337;
    $contact_data = array('emailAddress' => 'foobar@example.com');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('put')
      ->with('data/contact/' . $contact_id, $contact_data)
      ->will($this->returnValue($contact_data));

    $this->assertEquals($contact_data, $api->update($contact_id, $contact_data));
  }

  /**
   * @test
   */
  public function shouldRemoveContact() {
    $contact_id = 1337;
    $expected_response = null;

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('delete')
      ->with('data/contact/' . $contact_id)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->remove($contact_id));
  }

  /**
   * @test
   */
  public function shouldCreateContact() {
    $contact_data = array('emailAddress' => 'foobar@example.com');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('data/contact', $contact_data)
      ->will($this->returnValue($contact_data));

    $this->assertEquals($contact_data, $api->create($contact_data));
  }

  /**
   * @test
   * @expectedException InvalidArgumentException
   */
  public function shouldThrowExceptionCreateNoAddress() {
    $contact_data = array('firstName' => 'Foo');
    $api = $this->getApiMock();
    $api->create($contact_data);
  }

  /**
   * @test
   */
  public function shouldGetSubscriptions() {
    $contact_id = 1337;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('data/contact/' . $contact_id . '/email/groups/subscription')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->subscriptions($contact_id));
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Data\Contact';
  }

}
