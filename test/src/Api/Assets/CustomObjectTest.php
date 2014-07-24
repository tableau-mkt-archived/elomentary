<?php

/**
 * @file
 * Contains \Eloqua\Tests\Api\Data\CustomObjectTest.
 */

namespace Eloqua\Tests\Api\Assets;

use Eloqua\Exception\InvalidArgumentException;
use Eloqua\Tests\Api\TestCase;

class CustomObjectTest extends TestCase {

    /**
     * @test
     */
    public function shouldSearchCustomObjects() {
        $custom_object_name = 'Test';
        $expected_response = array('response');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('assets/customObject', array('search' => $custom_object_name))
            ->will($this->returnValue($expected_response));

        $this->assertEquals($expected_response, $api->search($custom_object_name));
    }

    /**
     * @test
     */
    public function shouldSearchCustomObjectsWithOptions() {
        $custom_object_name = 'Test';
        $options = array('count' => 5);
        $expected_response = array('response');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('assets/customObject', array_merge(array('search' => $custom_object_name), $options))
            ->will($this->returnValue($expected_response));

        $this->assertEquals($expected_response, $api->search($custom_object_name, $options));
    }

    /**
     * @test
     */
    public function shouldShowCustomObjectsJustId() {
        $custom_object_id = 1337;
        $expected_response = array('response');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('assets/customObject/' . $custom_object_id, array(
                'depth' => 'complete',
            ))
            ->will($this->returnValue($expected_response));

        $this->assertEquals($expected_response, $api->show($custom_object_id));
    }

    public function shouldShowCustomObjectsWithDepth() {
        $custom_object_id = 1337;
        $depth = 'minimal';
        $expected_response = array('response');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('assets/customObject/' . $custom_object_id, array(
                'depth' => $depth,
            ))
            ->will($this->returnValue($expected_response));

        $this->assertEquals($expected_response, $api->show($custom_object_id, $depth));
    }

    /**
     * @test
     */
    public function shouldRemoveCustomObjects() {
        $custom_object_id = 1337;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('assets/customObject/' . $custom_object_id);

        $this->assertNull($api->remove($custom_object_id));
    }

    /**
     * @test
     * @dataProvider getValidCustomObjectCreateMeta
     */
    public function shouldCreateCustomObject($customObject_meta) {
        $expected_response = array('response');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('assets/customObject', $customObject_meta)
            ->will($this->returnValue($expected_response));

        $this->assertEquals($expected_response, $api->create($customObject_meta));
    }

    public function getValidCustomObjectCreateMeta() {
        return array (
            array (
                array (
                    'name' => 'Test object with defined fields',
                    'fields' => array (
                        (object) array (
                            'name' => 'Field one',
                            'dataType' => 'text',
                        ),
                    ),
                ),
            ),
            array (
                array (
                    'name' => 'Test object without defined fields',
                ),
            ),
        );
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @dataProvider getInvalidCustomObjectCreateMeta
     */
    public function shouldThrowExceptionCreateCustomObject($customObject_meta) {
        $api = $this->getApiMock();
        $api->create($customObject_meta);
    }

    public function getInvalidCustomObjectCreateMeta() {
        return array (
            array (
                'description' => 'Test object missing name definition',
            ),
            array (
                'name' => 'Invalid fields definition ',
                'fields' => array (
                    (object) array (
                        'name' => 'Correctly defined field',
                        'dataType' => 'text',
                    ),
                    (object) array (
                        'name' => 'Missing dataType field',
                    ),
                ),
            ),
        );
    }

    protected function getApiClass() {
        return 'Eloqua\Api\Assets\CustomObject';
    }
}