<?php

/**
 * @file
 * Contains \Eloqua\Api\SearchableInterface
 */

namespace Eloqua\Api;

interface SearchableInterface {

  /**
   * Search for records of this type given a search string and options.
   *
   * @param string $search
   *   The string by which records should be searched.
   *
   * @param array $options
   *   An optional array of additional query parameters to be passed.
   *
   * @return array
   *   An array of records.
   */
  public function search($search, array $options);

}
