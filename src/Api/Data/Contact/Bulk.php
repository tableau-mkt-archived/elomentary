<?php

namespace Eloqua\Api\Data\Contact;

use Eloqua\Api\AbstractBulkApi;


class Bulk extends AbstractBulkApi {

  public function imports() {
    return $this->_mapUri = 'contacts/imports';
  }

  public function exports() {
    return $this->_mapUri = 'contacts/exports';
  }
} 