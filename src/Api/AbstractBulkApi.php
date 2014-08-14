<?php

namespace Eloqua\Api;


/**
 * Abstract class for API classes.
 */
abstract class AbstractBulkApi extends AbstractApi {
  protected $_mapUri;
  protected $_mapResponse;
  protected $_loadResponse;
  protected $_syncResponse;
  protected $_statusResponse;

  abstract public function imports();

  abstract public function exports();

  public function map($dataDefinition) {
    return $this->_mapResponse = $this->post($this->_mapUri, $dataDefinition);
  }

  public function upload($contactObject, $mapResponse = null) {
    if (empty($mapResponse)) {
      $mapResponse = $this->_mapResponse;
    }

    $uri = trim($mapResponse['uri'], '/');
    return $this->_loadResponse = $this->post("$uri/data", $contactObject);
  }

  public function sync($mapResponse = null) {
    if (empty($mapResponse)) {
      $mapResponse = $this->_mapResponse;
    }

    return $this->_syncResponse = $this->post('syncs', array (
      'syncedInstanceUri' => $mapResponse['uri']
    ));
  }

  public function status($wait = true, $syncResponse = null) {
    if (empty($syncResponse)) {
      $syncResponse = $this->_syncResponse;
    }

    $uri = trim($syncResponse['uri'], '/');

    do {
      $status = $this->get($uri);
    } while ($wait and $status['status'] === 'active' and sleep(1) === 0);

    return $this->_statusResponse = $status;
  }

  public function download($statusResponse = null) {
    if (empty($statusResponse)) {
      $statusResponse = $this->_statusResponse;
    }

    $uri = trim($statusResponse['syncedInstanceUri'], '/');

    return $this->get($uri . '/data');
  }

  public function log($statusResponse) {
    if (empty($statusResponse)) {
      $statusResponse = $this->_statusResponse;
    }

    $uri = trim($statusResponse['uri'], '/');

    return $this->get($uri . '/logs');
  }
}
