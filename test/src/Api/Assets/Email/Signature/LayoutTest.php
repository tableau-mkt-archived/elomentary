<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Assets\Email\Signature\LayoutTest.
 */

namespace Eloqua\Tests\Api\Assets\Email\Signature;

use Eloqua\Tests\Api\TestCase;

class LayoutTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchSignatureLayouts() {
    $layout_name = 'Foo Bar';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/signature/layouts')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($layout_name));
  }

  /**
   * @test
   */
  public function shouldSearchSignatureLayoutsWithOptions() {
    $layout_name = 'Foo Bar';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/signature/layouts', array_merge(array('search' => $layout_name), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($layout_name, $options));
  }

  /**
   * @test
   */
  public function shouldShowSignatureLayoutJustId() {
    $layout_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/signature/layout/' . $layout_id, array(
        'depth' => 'complete',
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($layout_id));
  }

  /**
   * @test
   */
  public function shouldShowSignatureLayoutWithDepth() {
    $layout_id = 7331;
    $layout_depth = 'minimal';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/signature/layout/' . $layout_id, array(
        'depth' => $layout_depth,
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($layout_id, $layout_depth));
  }

  /**
   * @test
   */
  public function shouldShowSignatureLayoutWithExtensions() {
    $layout_id = 7331;
    $layout_depth = 'complete';
    $layout_extensions = 'extension123';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/signature/layout/' . $layout_id, array(
        'depth' => $layout_depth,
        'extensions' => $layout_extensions,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($layout_id, $layout_depth, $layout_extensions));
  }

  /**
   * @test
   */
  public function shouldUpdateSignatureLayout() {
    $layout_id = 7331;
    $layout_data = array('name' => 'Foo bar');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('put')
      ->with('assets/email/signature/layout/' . $layout_id, $layout_data)
      ->will($this->returnValue($layout_data));

    $this->assertEquals($layout_data, $api->update($layout_id, $layout_data));
  }

  /**
   * @test
   */
  public function shouldDeleteSignatureLayout() {
    $layout_id = 7331;
    $expected_response = null;

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('delete')
      ->with('assets/email/signature/layout/' . $layout_id)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->remove($layout_id));
  }

  /**
   * @test
   */
  public function shouldCreateSignatureLayout() {
    $layout_data = array('name' => 'Foo bar');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('assets/email/signature/layout', $layout_data)
      ->will($this->returnValue($layout_data));

    $this->assertEquals($layout_data, $api->create($layout_data));
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Assets\Email\Signature\Layout';
  }

}
