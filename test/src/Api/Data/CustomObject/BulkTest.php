<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Data\CustomObject\BulkTest.
 */

namespace Eloqua\Tests\Api\Data\CustomObject;

class BulkTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function shouldSetBulkImportUri() {
    $expected_id = 123;
    $expected_uri = 'customObjects/' . $expected_id . '/imports';

    $api = $this->getApi($expected_id);
    $this->assertEquals($expected_uri, $api->imports());
    $this->assertEquals($expected_uri, \PHPUnit_Framework_Assert::readAttribute($api, '_mapUri'));
  }

  /**
   * @test
   */
  public function shouldSetBulkExportUri() {
    $expected_id = 123;
    $expected_uri = 'customObjects/' . $expected_id . '/exports';

    $api = $this->getApi($expected_id);
    $this->assertEquals($expected_uri, $api->exports());
    $this->assertEquals($expected_uri, \PHPUnit_Framework_Assert::readAttribute($api, '_mapUri'));
  }

  protected function getApi($id) {
    $mockClient = $this->getMock('Eloqua\Client');
    return $this->getMockForAbstractClass('Eloqua\Api\Data\CustomObject\Bulk', array($mockClient, $id));
  }

}
