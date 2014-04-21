<?php

/**
 * @file
 * Contains \Eloqua\Api\Contact.
 */

namespace Eloqua\Api\Data;

use Eloqua\Api\AbstractApi;

/**
 * Eloqua Contact.
 */
class Contact extends AbstractApi {

  /**
   * Search contact records by a given e-mail.
   *
   * @param string $search
   *   The string by which email records should be searched.
   *
   * @param array $options
   *   An optional array of additional query parameters to be passed.
   *
   * @return array
   *   An array of contacts.
   */
  public function search($search, array $options = array()) {
    return $this->get('data/contacts', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * Return extended information about a contact by its ID.
   *
   * @param int $id
   *   The ID associated with the desired contact.
   *
   * @return array
   *   The desired contact record represented as an associative array.
   */
  public function show($id) {
    return $this->get('data/contact/' . rawurlencode($id));
  }

  /**
   * Return subscriptions for a contact by its ID.
   *
   * @param int $id
   *   The ID associated with the given contact.
   *
   * @return array
   *   An array of contact subscriptions.
   */
  public function subscriptions($id) {
    return $this->get('data/contact/' . rawurlencode($id) . '/email/groups/subscription');
  }

}
