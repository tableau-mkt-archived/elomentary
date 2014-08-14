<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Assets\ProgramTest.
 */

namespace Eloqua\Tests\Api\Assets;

use Eloqua\Tests\Api\TestCase;

class ProgramTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchPrograms() {
    $search = 'Never Gonna Give*';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/programs', array('search' => $search))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($search));
  }

  /**
   * @test
   */
  public function shouldSearchProgramsWithOptions() {
    $search = 'Never Gonna Give*';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/programs', array_merge(array('search' => $search), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($search, $options));
  }

  /**
   * @test
   */
  public function shouldShowProgramJustId() {
    $pid = 1337;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/program/' . $pid)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($pid));
  }

  /**
   * @test
   */
  public function shouldShowProgramWithDepth() {
    $pid = 1337;
    $depth = 'minimal';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/program/' . $pid, array(
        'depth' => $depth,
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($pid, $depth));
  }

  /**
   * @test
   */
  public function shouldShowProgramStepJustId() {
    $sid = 1337;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/program/step/' . $sid)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->step($sid));
  }

  /**
   * @test
   */
  public function shouldShowProgramStepWithDepth() {
    $sid = 1337;
    $depth = 'minimal';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/program/step/' . $sid, array(
        'depth' => $depth,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->step($sid, $depth));
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Assets\Program';
  }

}
