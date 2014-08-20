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

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('data/customObject/1', array('search' => 'id=1'))
      ->will($this->returnValue($expected));

    $result = $api->identify(1)->search('id=1');

    $this->assertEquals($expected, $result);
  }

  /**
   * @test
   */
  public function shouldCreateCustomObjectData() {
    $data = array ('contactId' => null, 'fields' => array());

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('data/customObject/1', $data);

    $api->identify(1)->create($data);
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Data\CustomObject';
  }
}
