<?php

/**
 * @file
 * Contains \Eloqua\Api\Data\CustomObject\Bulk.
 */

namespace Eloqua\Api\Data\CustomObject;

use Eloqua\Api\AbstractBulkApi;
use Eloqua\Client;

class Bulk extends AbstractBulkApi {
  private $_id;

    /**
     * {@inheritdoc}
     */
    public function __construct(Client $client, $customObjectId) {
        $this->_id = $customObjectId;
        parent::__construct($client);
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
