<?php

namespace Eloqua\Api;
use Eloqua\Exception\InvalidArgumentException;


/**
 * Abstract class for Bulk API classes.
 *
 * Bulk API documentation available at:
 * http://topliners.eloqua.com/docs/DOC-6918
 *
 */
abstract class AbstractBulkApi extends AbstractApi {
  /**
   * @var string
   * The bulk API URI
   */
  protected $_mapUri;

  /**
   * @var array
   * Stores the API responses for the different bulk API calls.
   */
  private $_responses = array ();

  /**
   * Set accessor for _responses array
   *
   * @param string $key
   *   _responses array key
   *
   * @param \Eloqua\HttpClient\Message\ResponseMediator $value
   *   response array from Eloqua
   *
   * @return array
   *   Returns value of $value
   */
  public function setResponse($key, $value) {
    return $this->_responses[$key] = $value;
  }

  /**
   * Get accessor for _responses array
   *
   * @param string $key
   *   _responses key
   *
   * @param \Eloqua\HttpClient\Message\ResponseMediator $expectedResponse
   *   Set if you want to force $expectedResponse to be returned
   *
   * @return array
   *   Value of requested Eloqua bulk API response
   *
   * @throws \Eloqua\Exception\InvalidArgumentException
   */
  public function getResponse($key, $expectedResponse = null) {
    if (isset($expectedResponse)) {
      return $expectedResponse;
    }

    if (!isset($this->_responses[$key])) {
      throw new InvalidArgumentException("Response value for $key is not available");
    }

    return $this->_responses[$key];
  }

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
    return $this->setResponse('map', $this->post($this->_mapUri, $dataDefinition));
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
    $mapResponse = $this->getResponse('map', $mapResponse);
    $uri = trim($mapResponse['uri'], '/');

    return $this->setResponse('load', $this->post("$uri/data", $contactObject));
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
    $mapResponse = $this->getResponse('map', $mapResponse);

    return $this->setResponse('sync', $this->post('syncs', array (
      'syncedInstanceUri' => $mapResponse['uri']
    )));
  }

  /**
   * Checks the status of the last sync.
   *
   * @param bool $wait
   *   If true, the function will block until the sync either
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
  public function status($wait = false, $syncResponse = null) {
    $syncResponse = $this->getResponse('sync', $syncResponse);
    $uri = trim($syncResponse['uri'], '/');

    do {
      $status = $this->get($uri);
    } while ($wait and $this->isWaitingStatus($status) and sleep(1) === 0);

    return $this->setResponse('status', $status);
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
   * Retrieves data from the staging area.
   *
   * @param array $statusResponse
   *   Response from $this->status call.  Defaults to last $this->status()
   *   response.
   *
   * @param integer $limit
   *   A URL parameter that specifies the maximum number of records to return. 
   *   This can be any positive integer between 1 and 50000 inclusive.
   *   If not specified, eloqua will automatically default to 1000.
   *
   * @param integer $offset
   *   Specifies an offset that allows you to retrieve the next batch of records.
   *   For example, if your limit is 1000, specifying an offset of 1000 will return
   *   records 1000 through 2000. If not specified, eloqua will automatically default to 0.
   *   (Any positive integer).
   * 
   * @return array
   *   Download response, including records matched from mapping() call.
   */
  public function download($statusResponse = null, $limit = null, $offset = null) {
    $statusResponse = $this->getResponse('status', $statusResponse);
    $uri = trim($statusResponse['syncedInstanceUri'], '/');

    if (isset($limit) && isset($offset) && $limit > 0 && $offset >= 0){
      return $this->get("$uri/data?limit=$limit?offset=$offset");
    } elseif (isset($limit) && !isset($offset) && $limit > 0) {
      return $this->get("$uri/data?limit=$limit");
    } elseif (!isset($limit) && isset($offset) && $offset >= 0) {
      return $this->get("$uri/data?offset=$offset");      
    } else {
      return $this->get("$uri/data");
    }  
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
    $statusResponse = $this->getResponse('status', $statusResponse);
    $uri = trim($statusResponse['uri'], '/');

    return $this->get("$uri/logs");
  }
}
