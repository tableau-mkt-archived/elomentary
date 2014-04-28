<?php

/**
 * @file
 * Contains \Eloqua\ResultPagerInterface.
 */

namespace Eloqua;

use Eloqua\Api\ApiInterface;

/**
 * Pager interface
 */
interface ResultPagerInterface {

  /**
   *  @return null|array
   *   Pagination result of the last request.
   */
  public function getPagination();

  /**
   * Fetch a single result (page) from an api call.
   *
   * @param ApiInterface $api
   *   The API instance.
   *
   * @param string $method
   *   The method name to call on the API instance.
   *
   * @param array $parameters
   *   The method parameters as an array.
   *
   * @return array
   *   The result of the Api::$method() call.
   */
  public function fetch(ApiInterface $api, $method, array $parameters = array());

  /**
   * Fetch all results (pages) from an api call. Use with care; there is no
   * maximum!
   *
   * @param ApiInterface $api
   *   The API instance.
   *
   * @param string $method
   *   The method name to call on the API instance.
   *
   * @param array $parameters
   *   The method parameters as an array.
   *
   * @return array
   *   A merge of the results of the Api::$method() call.
   */
  public function fetchAll(ApiInterface $api, $method, array $parameters = array());

  /**
   * Method that performs the actual work to refresh the pagination property
   */
  public function postFetch();

  /**
   * Check to determine the availability of a next page
   * @return bool
   */
  public function hasNext();

  /**
   * Check to determine the availability of a previous page
   * @return bool
   */
  public function hasPrevious();

  /**
   * Fetch the next page
   * @return array
   */
  public function fetchNext();

  /**
   * Fetch the previous page
   * @return array
   */
  public function fetchPrevious();

  /**
   * Fetch the first page
   * @return array
   */
  public function fetchFirst();

  /**
   * Fetch the last page
   * @return array
   */
  public function fetchLast();

}
