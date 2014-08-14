<?php

namespace Eloqua\BulkApi\Data;

use Eloqua\Api\AbstractApi;

class CustomObject extends AbstractApi {
  /**
   * {@inheritdoc}
   */
  public function create($customObject, $dataDef, $async = false) {
    // Upload field mappings
    $obj = $this->post("customObjects/19/imports", $dataDef);
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

  public function search($searchTerm, $dataDef, $async = false) {
    if (isset($searchTerm)) {
      $dataDef->filter = "'{$dataDef->fields->contactId}'='11067'";
    }

    $obj = $this->post("customObjects/19/exports", $dataDef);
    $uri = trim($obj['uri'], '/');

    $startSync = $this->post('syncs', array (
      "syncedInstanceUri" => "/$uri"
    ));
    $statusUri = trim($startSync['uri'], '/');

    do {
      $sync = $this->get($statusUri);
    } while ($async or ($sync['status'] === 'pending' && sleep(1) === 0));

    $syncUri = trim($sync['syncedInstanceUri'], '/');

    $sync = $this->get($syncUri . '/data');
    return $sync;
  }
} 