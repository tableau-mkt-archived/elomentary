<?php

/**
 * @file
 * Contains \Eloqua\Api\CreatableInterface
 */

namespace Eloqua\Api;

interface CreatableInterface {

  /**
   * Create a new record of this type.
   *
   * @param array $data
   *   An associative array representing a single record of this type.
   *
   * @return array
   *   An associative array representing the newly created record.
   */
  public function create($data);

}
