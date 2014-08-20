<?php

/**
 * @file
 * Contains \Eloqua\Api\Data\CustomObject\Bulk.
 */

namespace Eloqua\Api\Data\CustomObject;

use Eloqua\Api\AbstractBulkApi;

class Bulk extends AbstractBulkApi {
  private $_id;

  /**
   * Sets custom object id
   *
   * @param number $id
   *   Custom Object ID
   */
  public function identify($id) {
    $this->_id = $id;
  }

  /**
   * {@inheritdoc}
   */
  public function imports() {
    return $this->_mapUri = "customObjects/$this->_id/imports";
  }

  /**
   * {@inheritdoc}
   */
  public function exports() {
    return $this->_mapUri = "customObjects/$this->_id/exports";
  }
}
