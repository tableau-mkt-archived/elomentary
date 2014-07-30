<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Data\CustomObjectTest.
 */

namespace Eloqua\Tests\Api\Data;

use Eloqua\DataStructures\CustomObjectData;
use Eloqua\Exception\InvalidArgumentException;
use Eloqua\Tests\Api\TestCase;

class CustomObjectTest extends TestCase {

  /**
   * @test
   */
  public function shouldGetMetaObject() {
    $api = $this->getApiMock();
    $this->assertInstanceOf('\Eloqua\Api\Assets\CustomObject', $api->meta());
  }

  /**
   * @test
   *
   * Makes sure rawurlencode() is called (' ' = '%20')
   */
  public function shouldSetCustomObjectId() {
    $api = $this->getApiMock();
    $this->assertEquals($api->identify(' '), '%20');
  }

  /**
   * @test
   * @dataProvider returnedCustomObjectData
   */
  public function shouldSearchCustomObjectData($returnValue) {
    $api = $this->getApiMock();

    $api->expects($this->once())
      ->method('get')
      ->with('data/customObject/1', array('search' => ''))
      ->will($this->returnValue($returnValue));

    $api->identify(1);
    $result = $api->search();

    $this->assertInstanceOf('Eloqua\DataStructures\CustomObjectData', $result[0]);
  }

  public function returnedCustomObjectData() {
    return array (
      array (
        array (
          'elements' => array (
            array('id' => 1)
          )
        )
      )
    );
  }

  /**
   * @test
   * @expectedException InvalidArgumentException
   */
  public function shouldThrowExceptionWithSearchValue() {
    $api = $this->getApiMock();
    $api->search('test');
  }

  /**
   * @test
   */
  public function shouldCreateCustomObjectData() {
    $data = new CustomObjectData();

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('data/customObject/1', $data);

    $api->identify(1);
    $api->create($data);
  }

  /**
   * @test
   * @expectedException InvalidArgumentException
   */
  public function shouldThrowExceptionOnInvalidInput() {
    $api = $this->getApiMock();
    $api->create('Invalid input');
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Data\CustomObject';
  }
}