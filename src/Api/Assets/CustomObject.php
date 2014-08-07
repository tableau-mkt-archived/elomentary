<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\CustomObject.
 */

namespace Eloqua\Api\Assets;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\CreatableInterface;
use Eloqua\Api\ReadableInterface;
use Eloqua\Api\UpdateableInterface;
use Eloqua\Api\DestroyableInterface;
use Eloqua\Api\SearchableInterface;
use Eloqua\Exception\InvalidArgumentException;

/**
 * Eloqua Custom Objects.  This class interfaces with a custom object's
 * metadata.  To interface with the contents of a custom object, use
 * the Eloqua\Api\Data\CustomObject object
 */
class CustomObject extends AbstractApi implements CreatableInterface, ReadableInterface, UpdateableInterface, DestroyableInterface, SearchableInterface {

  /**
   * Gets custom object data api
   *
   * @param number $customObjectId
   *   The custom object ID from which you're trying to interface with
   *
   * @throws \Exception
   *   Accessing custom object data is currently only possible with the 1.0 API.
   *   See http://topliners.eloqua.com/thread/13397 for more information.
   *
   * @return \Eloqua\Api\Data\CustomObject
   */
  public function data($customObjectId) {
    if ($this->client->getOption('version') != '1.0') {
      throw new \Exception("Accessing customObject data is currently only supported with the Rest API v1.0");
    }

    $data = new \Eloqua\Api\Data\CustomObject($this->client);
    $data->identify($customObjectId);

    return $data;
  }

  /**
   * {@inheritdoc}
   *
   * CustomObject search searches by a custom object's name parameter.  The
   * method name is pluralized, unlike other customObject calls.
   */
  public function search($search, array $options = array()) {
    return $this->get('assets/customObjects', array_merge(array(
      'search' => $search,
      'depth' => 'complete',
    ), $options));
  }

  /**
   * {@inheritdoc}
   */
  public function show($id, $depth = 'complete', $extensions = NULL) {
    return $this->get('assets/customObject/' . rawurlencode($id), array(
      'depth' => $depth,
    ));
  }

  /**
   * {@inheritdoc}
   *
   * Eloqua will return an object validation error if nothing is changed
   * in the update.
   *
   * Eloqua will return an error if the object->id does not match the $id
   * value in the signature.
   *
   */
  public function update($id, $customObject_meta) {
    return $this->put('assets/customObject/' . rawurldecode($id), $customObject_meta);
  }

  /**
   * {@inheritdoc}
   *
   * @throws InvalidArgumentException
   * @see http://topliners.eloqua.com/docs/DOC-3097
   */
  public function create($customObject_meta) {
    if (!isset($customObject_meta['name'])) {
      throw new InvalidArgumentException('At a minimum, you must provide an object name.');
    }

    if (isset($customObject_meta['fields'])) {
      foreach ($customObject_meta['fields'] as $field) {
        if (!isset($field['dataType'], $field['name'])) {
          throw new InvalidArgumentException('If defining fields, each must contain a dataType and name definition.');
        }
      }
    }

    return $this->post('assets/customObject', $customObject_meta);
  }

  /**
   * {@inheritdoc}
   */
  public function remove($id) {
    return $this->delete('assets/customObject/' . rawurlencode($id));
  }
}
