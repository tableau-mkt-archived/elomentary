<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Assets\Email\Footer\FolderTest.
 */

namespace Eloqua\Tests\Api\Assets\Email\Footer;

use Eloqua\Tests\Api\TestCase;

class FolderTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchFolders() {
    $folder_name = 'Foo Bar';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/footer/folders')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($folder_name));
  }

  /**
   * @test
   */
  public function shouldSearchFoldersWithOptions() {
    $folder_name = 'Foo Bar';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/footer/folders', array_merge(array('search' => $folder_name), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($folder_name, $options));
  }

  /**
   * @test
   */
  public function shouldShowFolderJustId() {
    $folder_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/footer/folder/' . $folder_id, array(
        'depth' => 'complete',
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($folder_id));
  }

  /**
   * @test
   */
  public function shouldShowFolderWithDepth() {
    $folder_id = 7331;
    $folder_depth = 'minimal';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/footer/folder/' . $folder_id, array(
        'depth' => $folder_depth,
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($folder_id, $folder_depth));
  }

  /**
   * @test
   */
  public function shouldShowFolderWithExtensions() {
    $folder_id = 7331;
    $folder_depth = 'complete';
    $folder_extensions = 'extension123';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/footer/folder/' . $folder_id, array(
        'depth' => $folder_depth,
        'extensions' => $folder_extensions,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($folder_id, $folder_depth, $folder_extensions));
  }

  /**
   * @test
   */
  public function shouldUpdateFolder() {
    $folder_id = 7331;
    $folder_data = array('displayName' => 'Foo bar');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('put')
      ->with('assets/email/footer/folder/' . $folder_id, $folder_data)
      ->will($this->returnValue($folder_data));

    $this->assertEquals($folder_data, $api->update($folder_id, $folder_data));
  }

  /**
   * @test
   */
  public function shouldDeleteFolder() {
    $folder_id = 7331;
    $expected_response = null;

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('delete')
      ->with('assets/email/footer/folder/' . $folder_id)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->remove($folder_id));
  }

  /**
   * @test
   */
  public function shouldCreateFolder() {
    $folder_data = array('name' => 'Foo bar');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('assets/email/footer/folder', $folder_data)
      ->will($this->returnValue($folder_data));

    $this->assertEquals($folder_data, $api->create($folder_data));
  }

  /**
   * @test
   */
  public function shouldGetFolderContents() {
    $folder_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/footer/folder/' . $folder_id . '/contents')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->contents($folder_id));
  }

  /**
   * @test
   */
  public function shouldGetFolderDependencies() {
    $folder_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/footer/folder/' . $folder_id . '/dependencies')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->dependencies($folder_id));
  }

  /**
   * @test
   */
  public function shouldGetFolderRoot() {
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/footer/folder/root', array(
        'depth' => 'complete',
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->root());
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Assets\Email\Footer\Folder';
  }

}
