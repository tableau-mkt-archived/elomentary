<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Assets\Email\HeaderTest.
 */

namespace Eloqua\Tests\Api\Assets\Email;

use Eloqua\Tests\Api\TestCase;

class HeaderTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchHeaders() {
    $header_name = 'Foo Bar';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/headers')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($header_name));
  }

  /**
   * @test
   */
  public function shouldSearchHeadersWithOptions() {
    $header_name = 'Foo Bar';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/headers', array_merge(array('search' => $header_name), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($header_name, $options));
  }

  /**
   * @test
   */
  public function shouldShowHeaderJustId() {
    $header_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/header/' . $header_id, array(
        'depth' => 'complete',
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($header_id));
  }

  /**
   * @test
   */
  public function shouldShowHeadersWithDepth() {
    $header_id = 7331;
    $header_depth = 'minimal';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/header/' . $header_id, array(
        'depth' => $header_depth,
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($header_id, $header_depth));
  }

  /**
   * @test
   */
  public function shouldShowHeaderWithExtensions() {
    $header_id = 7331;
    $header_depth = 'complete';
    $header_extensions = 'extension123';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/header/' . $header_id, array(
        'depth' => $header_depth,
        'extensions' => $header_extensions,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($header_id, $header_depth, $header_extensions));
  }

  /**
   * @test
   */
  public function shouldUpdateHeader() {
    $header_id = 7331;
    $header_data = array('displayName' => 'Foo bar');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('put')
      ->with('assets/email/header/' . $header_id, $header_data)
      ->will($this->returnValue($header_data));

    $this->assertEquals($header_data, $api->update($header_id, $header_data));
  }

  /**
   * @test
   */
  public function shouldDeleteHeader() {
    $header_id = 7331;
    $expected_response = null;

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('delete')
      ->with('assets/email/header/' . $header_id)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->remove($header_id));
  }

  /**
   * @test
   */
  public function shouldCreateHeader() {
    $header_data = array('name' => 'Foo bar');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('assets/email/header', $header_data)
      ->will($this->returnValue($header_data));

    $this->assertEquals($header_data, $api->create($header_data));
  }

  /**
   * @test
   */
  public function shouldCopyHeader() {
    $header_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('assets/email/header/' . $header_id . '/copy')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->copy($header_id));
  }

  /**
   * @test
   */
  public function shouldGetHeaderDependencies() {
    $header_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/header/' . $header_id . '/dependencies')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->dependencies($header_id));
  }

  /**
   * @test
   */
  public function shouldShowHeaderGrants() {
    $header_id = 7331;
    $expected_options = array('foo' => 'bar');
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/header/' . $header_id . '/security/grants', $expected_options)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->showGrants($header_id, $expected_options));
  }

  /**
   * @test
   */
  public function shouldUpdateHeaderGrants() {
    $header_id = 7331;
    $updated_grants = array('foo' => 'bar');
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('patch')
      ->with('assets/email/header/' . $header_id . '/security/grants', $updated_grants)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->updateGrants($header_id, $updated_grants));
  }

  /**
   * @test
   */
  public function shouldGetFolders() {
    $api = $this->getApiMock();
    $this->assertInstanceOf('Eloqua\Api\Assets\Email\Header\Folder', $api->folders());
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Assets\Email\Header';
  }

}
