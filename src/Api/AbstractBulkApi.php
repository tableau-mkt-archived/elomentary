<?php

namespace Eloqua\Api;


/**
 * Abstract class for Bulk API classes.
 *
 * Bulk API documentation available at:
 * http://topliners.eloqua.com/docs/DOC-6918
 *
 */
abstract class AbstractBulkApi extends AbstractApi {
  protected $_mapUri;
  protected $_mapResponse;
  protected $_loadResponse;
  protected $_syncResponse;
  protected $_statusResponse;

  /**
   * Sets client up for bulk importing data into Eloqua
   *
   * @return string
   *   URI used for bulk API client
   */
  abstract public function imports();

  /**
   * Sets client up for bulk exporting data from Eloqua
   *
   * @return string
   *   URI used for bulk API client
   */
  abstract public function exports();

  /**
   * Sends bulk API mapping file, required for all bulk transfers
   *
   * @param array $dataDefinition
   *   Definition mappings
   *
   * @return array
   *   Eloqua response, includes URIs for next steps.
   */
  public function map($dataDefinition) {
    return $this->_mapResponse = $this->post($this->_mapUri, $dataDefinition);
  }

  /**
   * Upload imports file to Eloqua bulk staging area.
   *
   * @param array $contactObject
   *   Data to be uploaded
   *
   * @param array $mapResponse
   *   Response from $this->map().  Defaults to whatever is returned from the
   *   last $this->map() call.
   *
   * @return array
   *   Eloqua response, required for sync() step.
   */
  public function upload($contactObject, $mapResponse = null) {
    if (empty($mapResponse)) {
      $mapResponse = $this->_mapResponse;
    }

    $uri = trim($mapResponse['uri'], '/');
    return $this->_loadResponse = $this->post("$uri/data", $contactObject);
  }

  /**
   * Syncs an import file to your Eloqua database, or syncs and export to a
   * downloadable file
   *
   * @param array $mapResponse
   *   Response from $this->map().  Defaults to whatever is returned from the
   *   last $this->map() call.
   *
   * @return array
   *   Eloqua response, including URI for status() step.
   */
  public function sync($mapResponse = null) {
    if (empty($mapResponse)) {
      $mapResponse = $this->_mapResponse;
    }

    return $this->_syncResponse = $this->post('syncs', array (
      'syncedInstanceUri' => $mapResponse['uri']
    ));
  }

  /**
   * Checks the status of the last sync.
   *
   * @param bool $wait
   *   If true (default), the function will block until the sync either
   *   completes or fails.  It will wait one second between the last response
   *   and the next check.
   *
   *   This should be set to false for asynchronous operations.
   *
   * @param array $syncResponse
   *   Response from $this->sync().  Defaults to whatever is returned from the
   *   last $this->sync() call.
   *
   * @return array
   *   Eloqua response, including URI for next steps.
   */
  public function status($wait = true, $syncResponse = null) {
    if (empty($syncResponse)) {
      $syncResponse = $this->_syncResponse;
    }

    $uri = trim($syncResponse['uri'], '/');

    do {
      $status = $this->get($uri);
    } while ($wait and $this->isWaitingStatus($status) and sleep(1) === 0);

    return $this->_statusResponse = $status;
  }

  /**
   * Returns true if status is in 'active' or 'pending' state.
   *
   * @param array $status
   *   Response from status() call
   *
   * @return bool
   *   Whether or not sync is still in progress
   */
  public function isWaitingStatus($status) {
    $waitingStatus = array ('active', 'pending');

    return in_array($status['status'], $waitingStatus);
  }

  /**
   * Downloads a file from the staging area.
   *
   * @param array $statusResponse
   *   Response from $this->status call.  Defaults to last $this->status()
   *   response.
   *
   * @return array
   *   Download response, including records matched from mapping() call.
   */
  public function download($statusResponse = null) {
    if (empty($statusResponse)) {
      $statusResponse = $this->_statusResponse;
    }

    $uri = trim($statusResponse['syncedInstanceUri'], '/');

    return $this->get($uri . '/data');
  }

  /**
   * Returns log from last bulk API transfer.
   *
   * @param array $statusResponse
   *   Response from $this->status call.  Defaults to last $this->status()
   *   response.
   *
   * @return array
   *   Bulk API log from last transfer.
   */
  public function log($statusResponse = null) {
    if (empty($statusResponse)) {
      $statusResponse = $this->_statusResponse;
    }

    $uri = trim($statusResponse['uri'], '/');

    return $this->get($uri . '/logs');
  }
}
