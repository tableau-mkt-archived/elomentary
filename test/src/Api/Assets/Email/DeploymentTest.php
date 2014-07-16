<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Assets\Email\DeploymentTest.
 */

namespace Eloqua\Tests\Api\Assets\Email;

use Eloqua\Tests\Api\TestCase;

class DeploymentTest extends TestCase {

  protected static $deployment_options = array();

  public function setUp() {
    self::$deployment_options['EmailInlineDeployment'] = array(
      'type' => 'EmailInlineDeployment',
      'name' => 'Inline Deployment',
      'contacts' => array(
        array(
          'emailAddress' => 'test@example.com',
          'id' => 123,
        ),
      ),
      'email' => array(
        'id' => 111,
      ),
    );

    self::$deployment_options['EmailTestDeployment'] = array(
      'type' => 'EmailTestDeployment',
      'name' => 'Test Deployment',
      'contactId' => 123456,
      'email' => array(
        'id' => 222,
      ),
    );
  }

  /**
   * @test
   */
  public function shouldSearchDeployments() {
    $deployment_name = 'Foo Bar';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/deployments')
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($deployment_name));
  }

  /**
   * @test
   */
  public function shouldSearchDeploymentsWithOptions() {
    $deployment_name = 'Foo Bar';
    $options = array('count' => 5);
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/deployments', array_merge(array('search' => $deployment_name), $options))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->search($deployment_name, $options));
  }

  /**
   * @test
   */
  public function shouldShowDeploymentJustId() {
    $deployment_id = 7331;
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/deployment/' . $deployment_id, array(
        'depth' => 'complete',
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($deployment_id));
  }

  /**
   * @test
   */
  public function shouldShowDeploymentWithDepth() {
    $deployment_id = 7331;
    $deployment_depth = 'minimal';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/deployment/' . $deployment_id, array(
        'depth' => $deployment_depth,
        'extensions' => null,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($deployment_id, $deployment_depth));
  }


  /**
   * @test
   */
  public function shouldShowDeploymentWithExtensions() {
    $deployment_id = 7331;
    $deployment_path = 'complete';
    $deployment_extensions = 'extension123';
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('get')
      ->with('assets/email/deployment/' . $deployment_id, array(
        'depth' => $deployment_path,
        'extensions' => $deployment_extensions,
      ))
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->show($deployment_id, $deployment_path, $deployment_extensions));
  }

  /**
   * @test
   */
  public function shouldCreateDeployment() {
    $options = array(
      'type' => 'EmailInlineDeployment',
      'name' => 'Test Deployment',
      'contacts' => array(
        array(
          'emailAddress' => 'someone@example.com',
          'id' => 123,
        ),
      ),
      'email' => array(
        'folderId' => 42,
        'emailGroupId' => 420,
        'subject' => 'Test Subject',
      ),
    );
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->once())
      ->method('post')
      ->with('assets/email/deployment', $options)
      ->will($this->returnValue($expected_response));

    $this->assertEquals($expected_response, $api->create($options));
  }

  /**
   * @test
   * @expectedException InvalidArgumentException
   */
  public function shouldThrowExceptionWhenCreatingInlineDeploymentWithMissingParams() {
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->any())
      ->method('post');

    // Remove a required value
    unset(self::$deployment_options['EmailInlineDeployment']['contacts']);

    $api->create(self::$deployment_options['EmailInlineDeployment']);
  }

  /**
   * @test
   * @expectedException InvalidArgumentException
   */
  public function shouldThrowExceptionWhenCreatingTestDeploymentWithMissingParams() {
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->any())
      ->method('post');

    // Remove a required value
    unset(self::$deployment_options['EmailTestDeployment']['contactId']);

    $api->create(self::$deployment_options['EmailTestDeployment']);
  }

  /**
   * @test
   * @expectedException InvalidArgumentException
   */
  public function shouldThrowExceptionWhenCreatingDeploymentWithMissingParams() {
    $expected_response = array('response');

    $api = $this->getApiMock();
    $api->expects($this->any())
      ->method('post');

    $api->create(array('some', 'random', 'array'));
  }

  protected function getApiClass() {
    return 'Eloqua\Api\Assets\Email\Deployment';
  }

}
