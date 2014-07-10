<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Assets\Contact\FieldTest.
 */

namespace Eloqua\Tests\Api\Assets\Contact;

use Eloqua\Tests\Api\TestCase;

class FieldTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchFields() {
    $group_name = 'Foo Bar';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/contact/fields')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($group_name));
  }

  /**
   * @test
   */
  public function shouldSearchFieldsWithOptions() {
    $group_name = 'Foo Bar';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/contact/fields', array_merge(array('search' => $group_name), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($group_name, $options));
  }

  /**
   * @test
   */
  public function shouldShowFieldJustId() {
    $field_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/contact/field/' . $field_id, array(
        'depth' => 'complete',
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($field_id));
  }

  /**
   * @test
   */
  public function shouldShowFieldWithDepth() {
    $field_id = 7331;
    $field_depth = 'minimal';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/contact/field/' . $field_id, array(
        'depth' => $field_depth,
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($field_id, $field_depth));
  }

  /**
   * @test
   */
  public function shouldShowFieldWithExtensions() {
    $field_id = 7331;
    $field_depth = 'complete';
    $field_extensions = 'extension123';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/contact/field/' . $field_id, array(
        'depth' => $field_depth,
        'extensions' => $field_extensions,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($field_id, $field_depth, $field_extensions));
  }

  /**
   * @test
   */
  public function shouldUpdateField() {
    $field_id = 7331;
    $field_data = array('name' => 'Foo bar');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('put')
      ->with('assets/contact/field/' . $field_id, $field_data)
      ->will($this->returnValue($field_data));

    $this->assertEquals($field_data, $api->update($field_id, $field_data));
  }

  /**
   * @test
   */
  public function shouldDeleteField() {
    $field_id = 7331;
    $expected_response = null;

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('delete')
      ->with('assets/contact/field/' . $field_id)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->remove($field_id));
  }

  /**
   * @test
   */
  public function shouldCreateField() {
    $field_data = array('name' => 'Foo bar');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('assets/contact/field', $field_data)
      ->will($this->returnValue($field_data));

    $this->assertEquals($field_data, $api->create($field_data));
  }

  /**
   * @test
   */
  public function shouldGetFieldDependencies() {
    $field_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/contact/field/' . $field_id . '/dependencies')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->dependencies($field_id));
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Assets\Contact\Field';
  }

}
