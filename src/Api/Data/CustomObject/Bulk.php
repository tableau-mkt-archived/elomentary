<?php

namespace Eloqua\Api\Data\CustomObject;

use Eloqua\Api\AbstractBulkApi;


class Bulk extends AbstractBulkApi {
  private $_id;

  public function identify($id) {
    $this->_id = $id;
  }

  public function imports() {
    return $this->_mapUri = "customObjects/$this->_id/imports";
  }

  public function exports() {
    return $this->_mapUri = "customObjects/$this->_id/exports";
  }
} 