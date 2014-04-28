<?php

/**
 * @file
 * Contains \Eloqua\Api\Email.
 */

namespace Eloqua\Api\Assets;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\SearchableInterface;

/**
 * Eloqua Email.
 */
class Email extends AbstractApi implements SearchableInterface {

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('assets/emails', array_merge(array(
      'search' => $search,
    ), $options));
  }

}
