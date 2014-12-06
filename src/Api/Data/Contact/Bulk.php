<?php

/**
 * @file
 * Contains \Eloqua\Api\Data\Contact\Bulk.
 */

namespace Eloqua\Api\Data\Contact;

use Eloqua\Api\AbstractBulkApi;

class Bulk extends AbstractBulkApi {

  /**
   * {@inheritdoc}
   */
  public function imports() {
    return $this->_mapUri = 'contacts/imports';
  }

  /**
   * {@inheritdoc}
   */
  public function exports() {
    return $this->_mapUri = 'contacts/exports';
  }

  /**
   * {@inheritdoc}
   */
  public function get($path, array $parameters = array(), $requestHeaders = array()) {
	return parent::get($path, $parameters, $requestHeaders);
  }
}
