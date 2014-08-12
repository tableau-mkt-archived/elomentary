<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\Program.
 */

namespace Eloqua\Api\Assets;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\ReadableInterface;
use Eloqua\Api\SearchableInterface;

/**
 * Eloqua program.
 */
class Program extends AbstractApi implements SearchableInterface, ReadableInterface {

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('assets/programs', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * {@inheritdoc}
   */
  public function show($id, $depth = 'complete', $extensions = null) {
    return $this->get('assets/program/' . rawurlencode($id), array(
      'depth' => $depth,
      'extensions' => $extensions,
    ));
  }

  /**
   * Returns a program step record for a given program step ID.
   *
   * @param int $stepId
   *   The ID of the desired program step.
   *
   * @param string $depth
   *   (Optional) The transform depth to use when retrieving the record. One of:
   *   - reference
   *   - minimal
   *   - partial
   *   - complete
   *
   * @return array
   *   An associative array representing the program step.
   */
  public function step($stepId, $depth = 'complete') {
    return $this->get('assets/program/step/' . rawurlencode($stepId), array(
      'depth' => $depth,
    ));
  }

}
