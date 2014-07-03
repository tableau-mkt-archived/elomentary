<?php

/**
 * @file
 * Contains \Eloqua\Api\Contact\View.
 */

namespace Eloqua\Api\Data\Contact;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\SearchableInterface;
use Eloqua\Client;

/**
 * Eloqua Contact List.
 */
class View extends AbstractApi implements SearchableInterface {

  /**
   * The contact view ID
   *
   * @var int
   */
  protected $contactViewId;

  /**
   * Create a Contact View object.
   *
   * @param Client $client
   *   The API client.
   *
   * @param int $contactViewId
   *   The ID of the contact list from which we want contacts.
   */
  public function __construct(Client $client, $contactViewId) {
    $this->contactViewId = $contactViewId;
    parent::__construct($client);
  }

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('data/contact/view/' . rawurlencode($this->contactViewId) . '/contacts', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * Returns Contact View Data for a given Contact and Contact View.
   *
   * @param int $id
   *   The id of the Contact for whom you want Contact View Data.
   *
   * @return array
   *   An associative array representing Contact View Data for this Contact and
   *   Contact View.
   */
  public function show($id) {
    return $this->get('data/contact/view/' . rawurlencode($this->contactViewId) . '/contact/' . $id);
  }

}
