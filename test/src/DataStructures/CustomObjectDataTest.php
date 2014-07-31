<?php

/**
 * @file
 * Contains \Eloqua\Tests\DataStructures\CustomObjectDataTest.
 */

namespace Eloqua\Tests\DataStructures;

use Eloqua\DataStructures\CustomObjectData;
use Eloqua\DataStructures\FieldValue;

use Eloqua\Exception\InvalidArgumentException;

class CustomObjectDataTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function shouldCreateEmptyObject() {
    $obj = new CustomObjectData();

    $this->assertNull($obj->id);
    $this->assertNull($obj->contactId);
    $this->assertNull($obj->fieldValues);
  }

  /**
   * @test
   */
  public function shouldCreateNewObject() {
    $obj = new CustomObjectData(123, array(
        new FieldValue('id', 'val')
      )
    );

    $this->assertNull($obj->id);
    $this->assertEquals($obj->contactId, 123);
    $this->assertCount(1, $obj->fieldValues);
    $this->assertInstanceOf('Eloqua\DataStructures\FieldValue', $obj->fieldValues[0]);
  }

  /**
   * @test
   * @expectedException InvalidArgumentException
   */
  public function  shouldThrowExceptionOnInvalidFieldValue() {
    new CustomObjectData(1, array('invalid FieldValue object'));
  }

  /**
   * @test
   * @dataProvider customObjectDataArray
   */
  public function shouldLoadEloquaResponseArray($input, $expected) {
    $obj = CustomObjectData::load($input);
    $expected->id = 1;

    $this->assertEQuals($obj, $expected);
  }

  public function customObjectDataArray() {
    return array (
      array (
        array (
          'id' => 1,
          'contactId' => 2,
          'fieldValues' => array (
            array ('id' => 3, 'value' => 4),
          )
        ),
        new CustomObjectData(2, array(new FieldValue(3, '4'))),
      ),
      array (
        array (
          'id' => 1,
          'contactId' => 2,
        ),
        new CustomObjectData(2),
      ),
      array (
        array (
          'id' => 1,
        ),
        new CustomObjectData(),
      ),
    );
  }
}