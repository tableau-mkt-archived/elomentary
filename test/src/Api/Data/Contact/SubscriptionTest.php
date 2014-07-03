<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Data\Contact/SubscriptionTest.
 */

namespace Eloqua\Tests\Api\Data\Contact;

use Eloqua\Exception\InvalidArgumentException;
use Eloqua\Tests\Api\TestCase;

class SubscriptionTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchSubscriptions() {
    $contact_id = 1337;
    $subscription_name = 'Foo Bar';
    $expected_response = array('response');

    $api = $this->getApiMock(array($contact_id));
    $api->expects($this->once())
      ->method('get')
      ->with('data/contact/' . $contact_id . '/email/groups/subscription')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($subscription_name));
  }

  /**
   * @test
   */
  public function shouldSearchSubscriptionsWithOptions() {
    $contact_id = 1337;
    $subscription_name = 'Foo Bar';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock(array($contact_id));
    $api->expects($this->once())
      ->method('get')
      ->with('data/contact/' . $contact_id . '/email/groups/subscription', array_merge(array('search' => $subscription_name), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($subscription_name, $options));
  }

  /**
   * @test
   */
  public function shouldShowSubscriptionJustId() {
    $contact_id = 1337;
    $group_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock(array($contact_id));
    $api->expects($this->once())
      ->method('get')
      ->with('data/contact/' . $contact_id . '/email/group/' . $group_id . '/subscription', array(
        'depth' => 'complete',
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($group_id));
  }

  /**
   * @test
   */
  public function shouldShowSubscriptionWithDepth() {
    $contact_id = 1337;
    $group_id = 7331;
    $group_depth = 'minimal';
    $expected_response = array('response');

    $api = $this->getApiMock(array($contact_id));
    $api->expects($this->once())
      ->method('get')
      ->with('data/contact/' . $contact_id . '/email/group/' . $group_id . '/subscription', array(
        'depth' => $group_depth,
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($group_id, $group_depth));
  }

  /**
   * @test
   */
  public function shouldShowSubscriptionWithExtensions() {
    $contact_id = 1337;
    $group_id = 7331;
    $group_depth = 'minimal';
    $group_extensions = 'extension123';
    $expected_response = array('response');

    $api = $this->getApiMock(array($contact_id));
    $api->expects($this->once())
      ->method('get')
      ->with('data/contact/' . $contact_id . '/email/group/' . $group_id . '/subscription', array(
        'depth' => $group_depth,
        'extensions' => $group_extensions,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($group_id, $group_depth, $group_extensions));
  }

  /**
   * @test
   */
  public function shouldUpdateSubscription() {
    $contact_id = 1337;
    $group_id = 7331;
    $group_data = array('contactId' => $contact_id);

    $api = $this->getApiMock(array($contact_id));
    $api->expects($this->once())
      ->method('put')
      ->with('data/contact/' . $contact_id . '/email/group/' . $group_id . '/subscription', $group_data)
      ->will($this->returnValue($group_data));

    $this->assertEquals($group_data, $api->update($group_id, $group_data));
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Data\Contact\Subscription';
  }

}
