<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\Email.
 */

namespace Eloqua\Api\Assets;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\CreatableInterface;
use Eloqua\Api\ReadableInterface;
use Eloqua\Api\DestroyableInterface;
use Eloqua\Api\SearchableInterface;
use Eloqua\Exception\InvalidArgumentException;

/**
 * Eloqua Custom Objects.  This class interfaces with a custom object's
 * metadata.  To interface with the contents of a custom object, use
 * the Eloqua\Api\Data\CustomObject object
 */
class CustomObject extends AbstractApi implements CreatableInterface, ReadableInterface, DestroyableInterface, SearchableInterface {

  /**
   * {@inheritdoc}
   *
   * CustomObject search searches by a custom object's name parameter
   */
  public function search($search, array $options = array()) {
    return $this->get('assets/customObject', array_merge(array(
      'search' => $search,
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
   * @throws InvalidArgumentException
   * @see http://topliners.eloqua.com/docs/DOC-3097
   */
  public function create($customObject_meta) {
    if (!isset($customObject_meta['name'])) {
      throw new InvalidArgumentException('At a minimum, you must provide an object name.');
    }

    if (isset($customObject_meta['fields'])) {
      foreach ($customObject_meta['fields'] as $field) {
        if (!isset($field->dataType, $field->name)) {
          throw new InvalidArgumentException('If defining fields, each must contained a dataType and name definition.');
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
