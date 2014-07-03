<?php

/**
 * @file
 * Contains \Eloqua\Api\Contact\Filter.
 */

namespace Eloqua\Api\Data\Contact;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\SearchableInterface;
use Eloqua\Client;

/**
 * Eloqua Contact Filter.
 */
class Filter extends AbstractApi implements SearchableInterface {

  /**
   * The contact filter ID.
   *
   * @var int
   */
  protected $contactFilterId;

  /**
   * Create a Filter object.
   *
   * @param Client $client
   *   The API client.
   *
   * @param int $contactFilterId
   *   The ID of the contact filter from which we want contacts.
   */
  public function __construct(Client $client, $contactFilterId) {
    $this->contactFilterId = $contactFilterId;
    parent::__construct($client);
  }

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('data/contacts/filter/' . rawurlencode($this->contactFilterId), array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * @todo Document this method.
   */
  public function export($data) {
    return $this->post('data/contacts/filter/' . rawurlencode($this->contactFilterId) . '/export', $data);
  }

}
