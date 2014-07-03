<?php

/**
 * @file
 * Contains \Eloqua\Api\Contact\Subscription.
 */

namespace Eloqua\Api\Data\Contact;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\ReadableInterface;
use Eloqua\Api\SearchableInterface;
use Eloqua\Api\UpdateableInterface;
use Eloqua\Client;

/**
 * Eloqua Subscription.
 */
class Subscription extends AbstractApi implements ReadableInterface, UpdateableInterface, SearchableInterface {

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
   * {@inheritdoc}
   */
  public function show($id, $depth = 'complete', $extensions = null) {
    return $this->get('data/contact/' . rawurlencode($this->contactId) . '/email/group/' . rawurlencode($id) . '/subscription', array(
      'depth' => $depth,
      'extensions' => $extensions,
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function update($id, $subscription_data) {
    return $this->put('data/contact/' . rawurlencode($this->contactId) . '/email/group/' . rawurlencode($id) . '/subscription', $subscription_data);
  }

}
