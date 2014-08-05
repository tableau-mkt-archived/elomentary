<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\Email.
 */

namespace Eloqua\Api\Data;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\CreatableInterface;
use Eloqua\Api\ReadableInterface;
use Eloqua\Api\SearchableInterface;

/**
 * Eloqua Custom Objects.
 *
 * Currently the API for custom object records only supports creating new
 * records, and parameter-less searching.
 *
 * This API is limited to using Eloqua REST v1.0
 */
class CustomObject extends AbstractApi implements CreatableInterface, ReadableInterface, SearchableInterface {

  /**
   * @var number Identifier representing the customObject to interact with
   */
  private $_id;

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
    return $this->get("data/customObject/$this->_id", array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * {@inheritdoc}
   *
   * This method is provided for consistency and syntactic sugar - there is no
   * "show" API available for GET:data/customObject/{objId}/{recordId}
   *
   */
  public function show($id, $depth = 'complete', $extensions = NULL) {
    return $this->search("id=$id", array(
      'depth' => $depth,
    ));
  }

  /**
   * {@inheritdoc}
   *
   * @see http://topliners.eloqua.com/docs/DOC-3097
   */
  public function create($customObjectRecord) {
    return $this->post("data/customObject/$this->_id", $customObjectRecord);
  }
}
