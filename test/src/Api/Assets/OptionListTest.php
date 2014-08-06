<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Assets\OptionListTest.
 */

namespace Eloqua\Tests\Api\Assets;

use Eloqua\Tests\Api\TestCase;

class OptionListTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchOptionLists() {
    $term = 'Never Gonna Give*';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/optionLists', array('search' => $term))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($term));
  }

  /**
   * @test
   */
  public function shouldSearchEmailsWithOptions() {
    $term = 'Never Gonna Give*';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/optionLists', array_merge(array('search' => $term), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($term, $options));
  }

  /**
   * @test
   */
  public function shouldShowOptionListJustId() {
    $id = 1337;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/optionList/' . $id)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($id));
  }

  /**
   * @test
   */
  public function shouldShowOptionListWithDepth() {
    $option_list_id = 1337;
    $depth = 'minimal';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/optionList/' . $option_list_id, array(
        'depth' => $depth,
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($option_list_id, $depth));
  }

  /**
   * @test
   */
  public function shouldCreateOptionList() {
    $optionList = array('name' => "I don't understand the Watson references ;) ");
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('assets/optionList', $optionList)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->create($optionList));
  }

  /**
   * @test
   * @dataProvider createInvalidOptionLists
   * @expectedException InvalidArgumentException
   */
  public function shouldThrowExceptionWithMissingCreateParameters($input) {
    $api = $this->getApiMock();
    $api->create($input);
  }

  public function createInvalidOptionLists() {
    return array (
      array (
        array (
          'elements' => array (
            array ('displayName' => 'valid displayName', 'value' => 'valid value')
          )
        )
      ),
      array (
        array (
          'name' => 'valid OptionList name',
          'elements' => array (
            array ('displayName' => 'missing value parameter')
          )
        )
      ),
      array (
        array (
          'name' => 'valid OptionList name',
          'elements' => array (
            array ('value' => 'missing displayName parameter')
          )
        )
      )
    );
  }

  /**
   * @test
   */
  public function shouldUpdateOptionList() {
    $optionList_id = 123;
    $optionList = array('id' => $optionList_id);
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('put')
      ->with('assets/optionList/' . $optionList_id, $optionList)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->update($optionList_id, $optionList));
  }

  /**
   * @test
   * @expectedException InvalidArgumentException
   */
  public function shouldThrowExceptionWhenUpdatingWithInvalidId() {
    $optionList_id = 'Elomentary, My Dear Watson';
    $optionList = array('id' => 42);

    $api = $this->getApiMock();
    $api->expects($this->any())
      ->method('put');

    $api->update($optionList_id, $optionList);
  }

  /**
   * @test
   */
  public function shouldRemoveOptionList() {
    $optionList_id = 1337;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('delete')
      ->with('assets/optionList/' . $optionList_id)
      ->will($this->returnValue($expected_response));
    $this->assertEquals($expected_response, $api->remove($optionList_id));
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Assets\OptionList';
  }
}
