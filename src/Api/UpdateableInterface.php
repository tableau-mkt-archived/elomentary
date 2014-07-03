<?php

/**
 * @file
 * Contains \Eloqua\Api\UpdateableInterface
 */

namespace Eloqua\Api;

interface UpdateableInterface {

  /**
   * Update a single record of this type.
   *
   * @param int $id
   *   The ID of the individual record to be updated.
   *
   * @param string $data
   *   An associative array representing the record with all updated data.
   *
   * @return array
   *   An associative array representing the updated record.
   */
  public function update($id, $data);

}
