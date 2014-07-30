<?php

/**
 * @file
 * Contains \Eloqua\Tests\DataStructures\FieldValueTest.
 */

namespace Eloqua\Tests\DataStructures;

use Eloqua\DataStructures\FieldValue;
use Eloqua\Exception\InvalidArgumentException;

class FieldValueTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function shouldCreateNewObject() {
    $obj = new FieldValue(123, '456');

    $this->assertEquals($obj->id, 123);
    $this->assertEquals($obj->value, 456);
  }

  /**
   * @test
   * @expectedException InvalidArgumentException
   */
  public function shouldNotCreateEmptyObject() {
    new FieldValue(null, null);
  }

  /**
   * @test
   * @dataProvider customObjectDataArray
   */
  public function shouldLoadEloquaResponseArray($input, $expected) {
    $obj = FieldValue::load($input);
    $this->assertEQuals($obj, $expected);
  }

  public function customObjectDataArray() {
    return array (
      array (
        array (
          'id' => 1,
          'value' => 2,
        ),
        new FieldValue(1, 2)
      ),
    );
  }
}