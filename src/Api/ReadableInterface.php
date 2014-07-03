<?php

/**
 * @file
 * Contains \Eloqua\Api\ReadableInterface
 */

namespace Eloqua\Api;

interface ReadableInterface {

  /**
   * Get extended information for a single record of this type.
   *
   * @param int $id
   *   The ID of the individual record to be returned.
   *
   * @param string $depth
   *   Transform depth to use when retrieving the record. One of:
   *   - reference
   *   - minimal
   *   - partial
   *   - complete
   *
   * @param string $extensions
   *   @todo Document this parameter.
   *
   * @return array
   *   An array of records.
   */
  public function show($id, $depth, $extensions);

}
