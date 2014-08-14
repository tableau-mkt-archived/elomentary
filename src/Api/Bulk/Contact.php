<?php

namespace Eloqua\BulkApi\Data;

use Eloqua\Api\AbstractBulkApi;


class Contact extends AbstractBulkApi {

  public function imports() {
    return $this->_mapUri = 'contacts/imports';
  }

  public function exports() {
    return $this->_mapUri = 'contacts/exports';
  }

  /**
   * {@inheritdoc}
   */
  public function create($customObject, $dataDef, $async = false) {
    // Upload field mappings
    $obj = $this->post("contacts/imports", $dataDef);
    $uri = trim($obj['uri'], '/');

    // Queue up data upload
    $load = $this->post($uri . '/data', $customObject);

    // Start data upload
    $sync = $this->post('syncs', array (
      "syncedInstanceUri" => "/$uri"
    ));
    $syncUri = trim($sync['uri'], '/');

    // Wait for 'success' status - check every one second
    do {
      $sync = $this->get($syncUri);
    } while ($async or ($sync['status'] === 'active' and sleep(1) === 0));

    return $sync;
  }
}
