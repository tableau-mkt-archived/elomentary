<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Data\CustomObjectTest.
 */

namespace Eloqua\Tests\Api\Assets;

use Eloqua\DataStructures\CustomObject;
use Eloqua\DataStructures\CustomObjectField;
use Eloqua\Exception\InvalidArgumentException;
use Eloqua\Tests\Api\TestCase;

class CustomObjectTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchCustomObjects() {
    $custom_object_name = 'Test';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/customObjects', array('search' => $custom_object_name, 'depth' => 'complete'))
      ->will($this->returnValue(array('elements' => $expected_response)));

    $api->expects($this->once())
      ->method('parse')
      ->with($expected_response[0])
      ->will($this->returnValue($expected_response));

    $this->assertEquals(array($expected_response), $api->search($custom_object_name));
  }

  /**
   * @test
   */
  public function shouldSearchCustomObjectsWithOptions() {
    $searchParam = 'Test';
    $options = array ('page' => 1, 'depth' => 'complete');
    $expected = 'response';

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/customObjects', array_merge(array('search' => $searchParam), $options))
      ->will($this->returnValue(array('elements' => array($expected))));

    $api->expects($this->once())
      ->method('parse')
      ->with($expected)
      ->will($this->returnValue($expected));

    $this->assertEquals(array($expected), $api->search($searchParam, $options));
  }

  /**
   * @test
   */
  public function shouldShowCustomObjectsJustId() {
    $custom_object_id = 1337;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/customObject/' . $custom_object_id, array(
        'depth' => 'complete',
      ))
      ->will($this->returnValue($expected_response));

    $api->expects($this->once())
      ->method('parse')
      ->with($expected_response)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($custom_object_id));
  }

  /**
   * @test
   */
  public function shouldShowCustomObjectsWithDepth() {
    $custom_object_id = 1337;
    $depth = 'minimal';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/customObject/' . $custom_object_id, array(
        'depth' => $depth,
      ))
      ->will($this->returnValue($expected_response));

    $api->expects($this->once())
      ->method('parse')
      ->with($expected_response)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($custom_object_id, $depth));
  }

  /**
   * @test
   */
  public function shouldRemoveCustomObjects() {
    $custom_object_id = 1337;

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('delete')
      ->with('assets/customObject/' . $custom_object_id);

    $this->assertNull($api->remove($custom_object_id));
  }

  /**
   * @test
   * @dataProvider getValidCustomObjectCreateMeta
   */
  public function shouldCreateCustomObject($customObject_meta) {
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('assets/customObject', $customObject_meta)
      ->will($this->returnValue($expected_response));

    $api->expects($this->once())
      ->method('parse')
      ->with($expected_response)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->create($customObject_meta));
  }

  public function getValidCustomObjectCreateMeta() {
    return array(
      array(
        new CustomObject('Test object with defined fields', null, null, array (
            new CustomObjectField('Field one', 'text')
        )),
      ),
      array(
          new CustomObject('Test object with defined fields'),
      ),
    );
  }

  /**
   * @test
   */
  public function shouldUpdateExistingMeta() {
    $api = $this->getApiMock();

    $api->expects($this->once())
      ->method('put')
      ->with('assets/customObject/1', array())
      ->will($this->returnValue('test'));

    $api->expects($this->once())
      ->method('parse')
      ->with('test');

    $api->update(1, array());
  }

  /**
   * @test
   * @expectedException InvalidArgumentException
   * @dataProvider getInvalidCustomObjectCreateMeta
   */
  public function shouldThrowExceptionCreateCustomObject($customObject_meta) {
    $api = $this->getApiMock();
    $api->create($customObject_meta);
  }

  public function getInvalidCustomObjectCreateMeta() {
    return array(
      array(
        array(
          'description' => 'Test object missing name definition',
        ),
      ),
      array(
        array(
          'name' => 'Invalid fields definition ',
          'fields' => array(
            (object) array(
              'name' => 'Correctly defined field',
              'dataType' => 'text',
            ),
            (object) array(
              'name' => 'Missing dataType field',
            ),
          ),
        ),
      ),
    );
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Assets\CustomObject';
  }
}
