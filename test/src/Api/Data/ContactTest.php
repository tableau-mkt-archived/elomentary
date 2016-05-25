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
  public function shouldShowContactJustId() {
    $contact_id = 1337;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('data/contact/' . $contact_id, array(
        'depth' => 'complete',
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($contact_id));
  }

  public function shouldShowContactWithDepth() {
    $contact_id = 1337;
    $contact_depth = 'minimal';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('data/contact/' . $contact_id, array(
        'depth' => $contact_depth,
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($contact_id, $contact_depth));
  }

  public function shouldShowContactWithExtensions() {
    $contact_id = 1337;
    $contact_depth = 'complete';
    $contact_extensions = 'extension123';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('data/contact/' . $contact_id, array(
        'depth' => $contact_depth,
        'extensions' => $contact_extensions,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($contact_id, $contact_depth, $contact_extensions));
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
    $api = $this->getApiMock();
    $this->assertInstanceOf('Eloqua\Api\Data\Contact\Subscription', $api->subscriptions($contact_id));
  }

  /**
   * @test
   */
  public function shouldGetLists() {
    $contact_list_id = 1337;
    $api = $this->getApiMock();
    $this->assertInstanceOf('Eloqua\Api\Data\Contact\ContactList', $api->lists($contact_list_id));
  }

  /**
   * @test
   */
  public function shouldGetSegments() {
    $contact_segment_id = 1337;
    $api = $this->getApimock();
    $this->assertInstanceOf('Eloqua\Api\Data\Contact\Segment', $api->segments($contact_segment_id));
  }

  /**
   * @test
   */
  public function shouldGetFilters() {
    $contact_filter_id = 1337;
    $api = $this->getApiMock();
    $this->assertInstanceOf('Eloqua\Api\Data\Contact\Filter', $api->filters($contact_filter_id));
  }

  /**
   * @test
   */
  public function shouldGetViews() {
    $contact_view_id = 1337;
    $api = $this->getApiMock();
    $this->assertInstanceOf('Eloqua\Api\Data\Contact\View', $api->views($contact_view_id));
  }

  /**
   * @test
   */
  public function shouldGetFields() {
    $api = $this->getApiMock();
    $this->assertInstanceOf('Eloqua\Api\Assets\Contact\Field', $api->fields());
  }

  /**
   * @test
   */
  public function shouldGetSharedLists() {
    $api = $this->getApiMock();
    $this->assertInstanceOf('Eloqua\Api\Assets\Contact\SharedList', $api->sharedLists());
  }

  /**
   * @test
   */
  public function shouldGetBulkClient() {
    $api = $this->getApiMock();
    $this->assertInstanceOf('Eloqua\Api\Data\Contact\Bulk', $api->bulk());
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Data\Contact';
  }

}
