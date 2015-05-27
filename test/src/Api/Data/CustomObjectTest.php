<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Data\CustomObjectTest.
 */

namespace Eloqua\Tests\Api\Data;
use Eloqua\Tests\Api\TestCase;

class CustomObjectTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchCustomObjectData() {
    $expected = 'test';
    $customObjectId = 1;

    $api = $this->getApiMock(array ($customObjectId));
    $api->expects($this->once())
      ->method('get')
      ->with("data/customObject/$customObjectId", array('search' => 'id=1'))
      ->will($this->returnValue($expected));

    $result = $api->search('id=1');

    $this->assertEquals($expected, $result);
  }

  /**
   * @test
   */
  public function shouldCreateCustomObjectData() {
    $data = array ('contactId' => null, 'fields' => array());
    $customObjectId = 1;

    $api = $this->getApiMock(array ($customObjectId));
    $api->expects($this->once())
      ->method('post')
      ->with("data/customObject/$customObjectId", $data);

    $api->create($data);
  }

  /**
   * @test
   */
  public function shouldShowCustomObjectData() {
    $expected = 'test';
    $customObjectId = 1;
    $expectedShowId = 123;

    $api = $this->getApiMock(array($customObjectId));
    $api->expects($this->once())
      ->method('get')
      ->with("data/customObject/$customObjectId", array(
        'search' => 'id=' . $expectedShowId,
        'depth' => 'complete',
      ))
      ->will($this->returnValue($expected));

    $result = $api->show($expectedShowId);

    $this->assertEquals($expected, $result);
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Data\CustomObject';
  }
}
