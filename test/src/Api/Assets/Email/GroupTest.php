<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Assets\Email\GroupTest.
 */

namespace Eloqua\Tests\Api\Assets\Email;

use Eloqua\Tests\Api\TestCase;

class GroupTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchGroups() {
    $group_name = 'Foo Bar';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/groups')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($group_name));
  }

  /**
   * @test
   */
  public function shouldSearchGroupsWithOptions() {
    $group_name = 'Foo Bar';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/groups', array_merge(array('search' => $group_name), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($group_name, $options));
  }

  /**
   * @test
   */
  public function shouldShowGroupJustId() {
    $group_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/group/' . $group_id, array(
        'depth' => 'complete',
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($group_id));
  }

  /**
   * @test
   */
  public function shouldShowGroupWithDepth() {
    $group_id = 7331;
    $group_depth = 'minimal';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/group/' . $group_id, array(
        'depth' => $group_depth,
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($group_id, $group_depth));
  }

  /**
   * @test
   */
  public function shouldShowGroupWithExtensions() {
    $group_id = 7331;
    $group_depth = 'complete';
    $group_extensions = 'extension123';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/group/' . $group_id, array(
        'depth' => $group_depth,
        'extensions' => $group_extensions,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($group_id, $group_depth, $group_extensions));
  }

  /**
   * @test
   */
  public function shouldUpdateGroup() {
    $group_id = 7331;
    $group_data = array('displayName' => 'Foo bar');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('put')
      ->with('assets/email/group/' . $group_id, $group_data)
      ->will($this->returnValue($group_data));

    $this->assertEquals($group_data, $api->update($group_id, $group_data));
  }

  /**
   * @test
   */
  public function shouldDeleteGroup() {
    $group_id = 7331;
    $expected_response = null;

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('delete')
      ->with('assets/email/group/' . $group_id)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->remove($group_id));
  }

  /**
   * @test
   */
  public function shouldCreateGroup() {
    $group_data = array('displayName' => 'Foo bar');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('assets/email/group', $group_data)
      ->will($this->returnValue($group_data));

    $this->assertEquals($group_data, $api->create($group_data));
  }

  /**
   * @test
   */
  public function shouldGetGroupDependencies() {
    $group_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/group/' . $group_id . '/dependencies')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->dependencies($group_id));
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Assets\Email\Group';
  }

}
