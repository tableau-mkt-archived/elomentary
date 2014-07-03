<?php

/**
 * @file
 * Contains \Eloqua\Api\Contact\Subscription.
 */

namespace Eloqua\Api\Data\Contact;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\SearchableInterface;
use Eloqua\Client;

/**
 * Eloqua Subscription.
 */
class Subscription extends AbstractApi implements SearchableInterface {

  /**
   * The contact ID
   *
   * @var int
   */
  protected $contactId;

  /**
   * Create a Subscription object.
   *
   * @param Client $client
   *   The API client.
   *
   * @param int $contactId
   *   The ID of the contact for whom we want subscriptions.
   */
  public function __construct(Client $client, $contactId) {
    $this->contactId = $contactId;
    parent::__construct($client);
  }

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('data/contact/' . rawurlencode($this->contactId) . '/email/groups/subscription', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * Return extended information about a subscription by its e-mail group ID.
   *
   * @param int $id
   *   The ID associated with the desired e-mail group.
   *
   * @return array
   *   The desired subscription record represented as an associative array.
   */
  public function show($id) {
    return $this->get('/data/contact/' . rawurlencode($this->contactId) . '/email/group/' . rawurlencode($id) . '/subscription');
  }

  /**
   * Update a subscription.
   *
   * @param int $id
   *   The ID associated with the given e-mail group.
   *
   * @param array $data
   *   Full subscription details to be updated.
   *
   * @return array
   *   The updated subscription data.
   */
  public function update($id, $data) {
    return $this->put('/data/contact/' . rawurlencode($this->contactId) . '/email/group/' . rawurlencode($id) . '/subscription', $data);
  }

}
