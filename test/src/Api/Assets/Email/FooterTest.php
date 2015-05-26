<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Assets\Email\FooterTest.
 */

namespace Eloqua\Tests\Api\Assets\Email;

use Eloqua\Tests\Api\TestCase;

class FooterTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchFooters() {
    $folder_name = 'Foo Bar';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/footers')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($folder_name));
  }

  /**
   * @test
   */
  public function shouldSearchFootersWithOptions() {
    $footer_name = 'Foo Bar';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/footers', array_merge(array('search' => $footer_name), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($footer_name, $options));
  }

  /**
   * @test
   */
  public function shouldShowFooterJustId() {
    $footer_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/footer/' . $footer_id, array(
        'depth' => 'complete',
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($footer_id));
  }

  /**
   * @test
   */
  public function shouldShowFootersWithDepth() {
    $footer_id = 7331;
    $footer_depth = 'minimal';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/footer/' . $footer_id, array(
        'depth' => $footer_depth,
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($footer_id, $footer_depth));
  }

  /**
   * @test
   */
  public function shouldShowFooterWithExtensions() {
    $footer_id = 7331;
    $footer_depth = 'complete';
    $footer_extensions = 'extension123';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/footer/' . $footer_id, array(
        'depth' => $footer_depth,
        'extensions' => $footer_extensions,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($footer_id, $footer_depth, $footer_extensions));
  }

  /**
   * @test
   */
  public function shouldUpdateFooter() {
    $footer_id = 7331;
    $footer_data = array('displayName' => 'Foo bar');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('put')
      ->with('assets/email/footer/' . $footer_id, $footer_data)
      ->will($this->returnValue($footer_data));

    $this->assertEquals($footer_data, $api->update($footer_id, $footer_data));
  }

  /**
   * @test
   */
  public function shouldDeleteFooter() {
    $footer_id = 7331;
    $expected_response = null;

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('delete')
      ->with('assets/email/footer/' . $footer_id)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->remove($footer_id));
  }

  /**
   * @test
   */
  public function shouldCreateFooter() {
    $footer_data = array('name' => 'Foo bar');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('assets/email/footer', $footer_data)
      ->will($this->returnValue($footer_data));

    $this->assertEquals($footer_data, $api->create($footer_data));
  }

  /**
   * @test
   */
  public function shouldCopyFooter() {
    $footer_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('assets/email/footer/' . $footer_id . '/copy')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->copy($footer_id));
  }

  /**
   * @test
   */
  public function shouldGetFooterDependencies() {
    $footer_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/footer/' . $footer_id . '/dependencies')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->dependencies($footer_id));
  }

  /**
   * @test
   */
  public function shouldShowFooterGrants() {
    $footer_id = 7331;
    $expected_options = array('foo' => 'bar');
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/footer/' . $footer_id . '/security/grants', $expected_options)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->showGrants($footer_id, $expected_options));
  }

  /**
   * @test
   */
  public function shouldUpdateFooterGrants() {
    $footer_id = 7331;
    $updated_grants = array('foo' => 'bar');
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('patch')
      ->with('assets/email/footer/' . $footer_id . '/security/grants', $updated_grants)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->updateGrants($footer_id, $updated_grants));
  }

  /**
   * @test
   */
  public function shouldGetFolders() {
    $api = $this->getApiMock();
    $this->assertInstanceOf('Eloqua\Api\Assets\Email\Footer\Folder', $api->folders());
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Assets\Email\Footer';
  }

}
