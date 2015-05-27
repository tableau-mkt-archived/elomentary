<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Data\Contact\BulkTest.
 */

namespace Eloqua\Tests\Api\Data\Contact;

class BulkTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function shouldSetBulkImportUri() {
    $expected_uri = 'contacts/imports';
    $api = $this->getMockForAbstractClass('Eloqua\Api\Data\Contact\Bulk', array(), '', false);
    $this->assertEquals($expected_uri, $api->imports());
    $this->assertEquals($expected_uri, \PHPUnit_Framework_Assert::readAttribute($api, '_mapUri'));
  }

  /**
   * @test
   */
  public function shouldSetBulkExportUri() {
    $expected_uri = 'contacts/exports';
    $api = $this->getMockForAbstractClass('Eloqua\Api\Data\Contact\Bulk', array(), '', false);
    $this->assertEquals($expected_uri, $api->exports());
    $this->assertEquals($expected_uri, \PHPUnit_Framework_Assert::readAttribute($api, '_mapUri'));
  }

}
