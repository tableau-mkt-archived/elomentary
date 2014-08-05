<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\Email.
 */

namespace Eloqua\Api\Data;

use Eloqua\DataStructures\CustomObjectData;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\CreatableInterface;
use Eloqua\Api\SearchableInterface;
use Eloqua\Exception\InvalidArgumentException;

/**
 * Eloqua Custom Objects.
 *
 * Currently the API for custom object records only supports creating new
 * records, and parameter-less searching.
 *
 * This API is limited to using Eloqua REST v1.0
 */
class CustomObject extends AbstractApi implements CreatableInterface, SearchableInterface {

  /**
   * @var number Identifier representing the customObject to interact with
   */
  private $_id;

  /**
   * Gets metadata class for Custom Objects.  Used for the object's definition.
   * @return \Eloqua\Api\Assets\CustomObject
   */
  public function meta() {
    return new \Eloqua\Api\Assets\CustomObject($this->client);
  }

  /**
   * Eloqua accounts can have multiple defined custom objects, this identifies
   * which one to interface with
   *
   * @param number $id
   * @returns $this
   */
  public function identify($id) {
    $this->_id = rawurlencode($id);
    return $this;
  }

  /**
   * {@inheritdoc}
   *
   * When searching through records in a custom object, you must specify which
   * column you want to search through.  $search = 'id=10', for example
   */
  public function search($search, array $options = array()) {
    $customObjectData = $this->get("data/customObject/$this->_id", array_merge(array(
      'search' => $search,
    ), $options));

    return array_map(array($this, 'parse'), $customObjectData['elements']);
  }

  /**
   * {@inheritdoc}
   *
   * @see http://topliners.eloqua.com/docs/DOC-3097
   */
  public function create($customObject) {
    if (!$customObject instanceof CustomObjectData) {
      throw new InvalidArgumentException('An input of type Eloqua\DataStructures\CustomObjectData is expected.');
    }

    $obj = $this->post("data/customObject/$this->_id", $customObject);
    return $this->parse($obj);
  }

  /**
   * {@inheritdoc}
   */
  public function parse($responseObject, $type = null) {
    if (empty($type)) {
      $type = '\Eloqua\DataStructures\CustomObjectData';
    }

    return parent::parse($responseObject, $type);
  }
}
