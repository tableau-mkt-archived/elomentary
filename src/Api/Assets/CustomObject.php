<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\Email.
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
   * {@inheritdoc}
   *
   * CustomObject search searches by a custom object's name parameter.  The
   * method name is pluralized, unlike other customObject calls.
   */
  public function search($search, array $options = array()) {
    $obj = $this->get('assets/customObjects', array_merge(array(
      'search' => $search,
      'depth' => 'complete',
    ), $options));

    return array_map(array ($this, 'parse'), $obj['elements']);
  }

  /**
   * {@inheritdoc}
   */
  public function show($id, $depth = 'complete', $extensions = NULL) {
    $obj = $this->get('assets/customObject/' . rawurlencode($id), array(
      'depth' => $depth,
    ));

    return $this->parse($obj);
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
    $obj = $this->put('assets/customObject/' . rawurldecode($id), $customObject_meta);
    return $this->parse($obj);
  }

  /**
   * {@inheritdoc}
   *
   * @throws InvalidArgumentException
   * @see http://topliners.eloqua.com/docs/DOC-3097
   */
  public function create($customObject_meta) {
    if (!isset($customObject_meta->name)) {
      throw new InvalidArgumentException('At a minimum, you must provide an object name.');
    }

    if (isset($customObject_meta->fields)) {
      foreach ($customObject_meta->fields as $field) {
        if (!isset($field->dataType, $field->name)) {
          throw new InvalidArgumentException('If defining fields, each must contained a dataType and name definition.');
        }
      }
    }

    $obj = $this->post('assets/customObject', $customObject_meta);
    return $this->parse($obj);
  }

  /**
   * {@inheritdoc}
   */
  public function remove($id) {
    return $this->delete('assets/customObject/' . rawurlencode($id));
  }

  /**
   * {@inheritdoc}
   */
  public function parse($responseObject, $type = null) {
    if (empty($type)) {
      $type = '\Eloqua\DataStructures\CustomObject';
    }

    return parent::parse($responseObject, $type);
  }
}
