<?php

/**
 * @file
 * Contains \Eloqua\Api\Data\Visitor.
 */

namespace Eloqua\Api\Data;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\SearchableInterface;

/**
 * Eloqua Visitor.
 */
class Visitor extends AbstractApi implements SearchableInterface {

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('data/visitors', array_merge(array(
      'search' => $search,
    ), $options));
  }

}
