<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\Email.
 */

namespace Eloqua\Api\Assets;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\Assets\Email\Group;
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

  /**
   * Returns an e-mail group client.
   *
   * @return \Eloqua\Api\Assets\Email\Group
   *   An e-mail group client.
   */
  public function groups() {
    return new Group($this->client);
  }

}
