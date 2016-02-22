<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Assets\CampaignTest.
 */

namespace Eloqua\Tests\Api\Assets;

use Eloqua\Tests\Api\TestCase;

class CampaignTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchCampaigns() {
    $search = 'Never Gonna Give*';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/campaigns', array('search' => $search))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($search));
  }

  /**
   * @test
   */
  public function shouldSearchCampaignsWithOptions() {
    $search = 'Never Gonna Give*';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/campaigns', array_merge(array('search' => $search), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($search, $options));
  }

  /**
   * @test
   */
  public function shouldCreateCampaign() {
    $data = array(
      'folderId' => 42,
      'runAsUserId' => 420,
      'name' => 'Elomentary Test Campaign',
    );
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('assets/campaign', $data)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->create($data));
  }

  /**
   * @test
   */
  public function shouldShowCampaignJustId() {
    $pid = 1337;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/campaign/' . $pid)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($pid));
  }

  /**
   * @test
   */
  public function shouldShowCampaignWithDepth() {
    $pid = 1337;
    $depth = 'minimal';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/campaign/' . $pid, array(
        'depth' => $depth,
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($pid, $depth));
  }

  /**
   * @test
   */
  public function shouldUpdateCampaign() {
    $cid = 123;
    $campaign_data = array(
      'folderId' => 42,
      'runAsUserId' => 420,
      'name' => 'Elomentary Test Campaign',
    );
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('put')
      ->with('assets/campaign/' . $cid, $campaign_data)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->update($cid, $campaign_data));
  }

  /**
   * @test
   */
  public function shouldRemoveCampaign() {
    $campaign_id = 1337;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('delete')
      ->with('assets/campaign/' . $campaign_id)
      ->will($this->returnValue($expected_response));
    $this->assertEquals($expected_response, $api->remove($campaign_id));
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Assets\Campaign';
  }

}
