<?php

/**
 * @file
 * Contains \Eloqua\Api\Contact\ContactList.
 */

namespace Eloqua\Api\Data\Contact;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\SearchableInterface;
use Eloqua\Client;

/**
 * Eloqua Contact List.
 */
class ContactList extends AbstractApi implements SearchableInterface {

  /**
   * The contact list ID
   *
   * @var int
   */
  protected $contactListId;

  /**
   * Create a Contact List object.
   *
   * @param Client $client
   *   The API client.
   *
   * @param int $contactListId
   *   The ID of the contact list from which we want contacts.
   */
  public function __construct(Client $client, $contactListId) {
    $this->contactListId = $contactListId;
    parent::__construct($client);
  }

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('data/contacts/list/' . rawurlencode($this->contactListId), array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * @todo Document this method.
   */
  public function export($data) {
    return $this->post('data/contacts/list/' . rawurlencode($this->contactListId) . '/export', $data);
  }

}
