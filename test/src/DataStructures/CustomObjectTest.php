<?php

/**
 * @file
 * Contains \Eloqua\Tests\DataStructures\CustomObjectTest.
 */

namespace Eloqua\Tests\DataStructures;

use Eloqua\DataStructures\CustomObject;
use Eloqua\DataStructures\CustomObjectField;

use Eloqua\Exception\InvalidArgumentException;

class CustomObjectTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function shouldCreateBasicObject() {
    $obj = new CustomObject('name');

    $this->assertNull($obj->id);
    $this->assertEquals('name', $obj->name);
    $this->assertNull($obj->description);
    $this->assertNull($obj->depth);
    $this->assertEmpty($obj->fields);
    $this->assertNull($obj->displayNameFieldId);
    $this->assertNull($obj->uniqueCodeFieldId);
  }

  /**
   * @test
   */
  public function shouldAssignOptionalParameters() {
    $obj = new CustomObject(
      'name',
      'description',
      'depth',
      array(
        new CustomObjectField('name')
      )
    );

    $this->assertNull($obj->id);
    $this->assertEquals('name', $obj->name);
    $this->assertEquals('description', $obj->description);
    $this->assertEquals('depth', $obj->depth);
    $this->assertCount(1, $obj->fields);
    $this->assertInstanceOf('Eloqua\DataStructures\CustomObjectField', $obj->fields[0]);
  }

  /**
   * @test
   * @expectedException InvalidArgumentException
   */
  public function  shouldThrowExceptionOnInvalidFieldValue() {
    new CustomObject('name', null, null, array('invalid CustomObjectField object'));
  }

  /**
   * @test
   * @dataProvider customObjectDataArray
   */
  public function shouldLoadEloquaResponseArray($input, $expected) {
    $obj = CustomObject::load($input);
    $expected->id = 1;

    $this->assertEquals($expected, $obj);
  }

  public function customObjectDataArray() {
    return array (
      array (
        array (
          'id' => 1,
          'depth' => 'complete',
          'description' => 'desc',
          'name' => 'test name',
          'fields' => array (
            array ('name' => 'test name', 'dataType' => 'text'),
          )
        ),
        new CustomObject('test name', 'desc', 'complete', array (new CustomObjectField ('test name'))),
      ),
      array (
        array (
          'id' => 1,
          'name' => 'test name'
        ),
        new CustomObject('test name'),
      ),
    );
  }
}