<?php

/**
 * @file
 * Contains \Eloqua\Api\DestroyableInterface
 */

namespace Eloqua\Api;

interface DestroyableInterface {

  /**
   * Delete a record of this type.
   *
   * @param array $id
   *   The ID of the individual record to be destroyed.
   *
   * @return null
   */
  public function remove($id);

}
