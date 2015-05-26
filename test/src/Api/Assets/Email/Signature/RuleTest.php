<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Assets\Email\Signature\RuleTest.
 */

namespace Eloqua\Tests\Api\Assets\Email\Signature;

use Eloqua\Tests\Api\TestCase;

class RuleTest extends TestCase {

  /**
   * @test
   */
  public function shouldSearchSignatureRules() {
    $rule_name = 'Foo Bar';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/signature/rules')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($rule_name));
  }

  /**
   * @test
   */
  public function shouldSearchSignatureRulesWithOptions() {
    $rule_name = 'Foo Bar';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/signature/rules', array_merge(array('search' => $rule_name), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($rule_name, $options));
  }

  /**
   * @test
   */
  public function shouldShowSignatureRuleJustId() {
    $rule_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/signature/rule/' . $rule_id, array(
        'depth' => 'complete',
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($rule_id));
  }

  /**
   * @test
   */
  public function shouldShowSignatureRuleWithDepth() {
    $rule_id = 7331;
    $rule_depth = 'minimal';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/signature/rule/' . $rule_id, array(
        'depth' => $rule_depth,
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($rule_id, $rule_depth));
  }

  /**
   * @test
   */
  public function shouldShowSignatureRuleWithExtensions() {
    $rule_id = 7331;
    $rule_depth = 'complete';
    $rule_extensions = 'extension123';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/signature/rule/' . $rule_id, array(
        'depth' => $rule_depth,
        'extensions' => $rule_extensions,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($rule_id, $rule_depth, $rule_extensions));
  }

  /**
   * @test
   */
  public function shouldUpdateSignatureRule() {
    $rule_id = 7331;
    $rule_data = array('name' => 'Foo bar');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('put')
      ->with('assets/email/signature/rule/' . $rule_id, $rule_data)
      ->will($this->returnValue($rule_data));

    $this->assertEquals($rule_data, $api->update($rule_id, $rule_data));
  }

  /**
   * @test
   */
  public function shouldDeleteSignatureRule() {
    $rule_id = 7331;
    $expected_response = null;

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('delete')
      ->with('assets/email/signature/rule/' . $rule_id)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->remove($rule_id));
  }

  /**
   * @test
   */
  public function shouldCreateSignatureRule() {
    $rule_data = array('name' => 'Foo bar');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('assets/email/signature/rule', $rule_data)
      ->will($this->returnValue($rule_data));

    $this->assertEquals($rule_data, $api->create($rule_data));
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Assets\Email\Signature\Rule';
  }

}
