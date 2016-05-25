<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Assets\Contact\SharedListTest.
 */

namespace Eloqua\Tests\Api\Assets\Contact;

use Eloqua\Tests\Api\TestCase;

class SharedListTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchSharedLists() {
    $list_name = 'Foo Bar';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/contact/lists')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($list_name));
  }

  /**
   * @test
   */
  public function shouldSearchSharedListsWithOptions() {
    $list_name = 'Foo Bar';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/contact/lists', array_merge(array('search' => $list_name), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($list_name, $options));
  }

  /**
   * @test
   */
  public function shouldShowSharedListJustId() {
    $list_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/contact/list/' . $list_id, array(
        'depth' => 'complete',
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($list_id));
  }

  /**
   * @test
   */
  public function shouldShowSharedListsWithDepth() {
    $list_id = 7331;
    $list_depth = 'minimal';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/contact/list/' . $list_id, array(
        'depth' => $list_depth,
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($list_id, $list_depth));
  }

  /**
   * @test
   */
  public function shouldShowSharedListsWithExtensions() {
    $list_id = 7331;
    $list_depth = 'complete';
    $list_extensions = 'extension123';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/contact/list/' . $list_id, array(
        'depth' => $list_depth,
        'extensions' => $list_extensions,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($list_id, $list_depth, $list_extensions));
  }

  /**
   * @test
   */
  public function shouldUpdateSharedList() {
    $list_id = 7331;
    $list_data = array('name' => 'Foo bar');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('put')
      ->with('assets/contact/list/' . $list_id, $list_data)
      ->will($this->returnValue($list_data));

    $this->assertEquals($list_data, $api->update($list_id, $list_data));
  }

  /**
   * @test
   */
  public function shouldDeleteSharedList() {
    $list_id = 7331;
    $expected_response = null;

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('delete')
      ->with('assets/contact/list/' . $list_id)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->remove($list_id));
  }

  /**
   * @test
   */
  public function shouldCreateSharedList() {
    $list_data = array('name' => 'Foo bar');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('assets/contact/list', $list_data)
      ->will($this->returnValue($list_data));

    $this->assertEquals($list_data, $api->create($list_data));
  }

  /**
   * @test
   */
  public function shouldGetSharedListDependencies() {
    $list_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/contact/list/' . $list_id . '/dependencies')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->dependencies($list_id));
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Assets\Contact\SharedList';
  }

}
