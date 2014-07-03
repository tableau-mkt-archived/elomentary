<?php

/**
 * @file
 * Contains \Eloqua\Api\Contact.
 */

namespace Eloqua\Api\Data;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\Data\Contact\ContactList;
use Eloqua\Api\Data\Contact\Filter;
use Eloqua\Api\Data\Contact\Subscription;
use Eloqua\Api\Data\Contact\View;
use Eloqua\Api\SearchableInterface;
use Eloqua\Exception\InvalidArgumentException;

/**
 * Eloqua Contact.
 */
class Contact extends AbstractApi implements SearchableInterface {

  /**
   * {@inheritdoc}
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
   * Update a contact.
   *
   * @param int $id
   *   The ID associated with the given contact.
   *
   * @param array $data
   *   Full contact details to be updated.
   *
   * @return array
   *   The updated contact data.
   */
  public function update($id, $data) {
    return $this->put('data/contact/' . rawurlencode($id), $data);
  }

  /**
   * Delete a contact.
   *
   * @param string $id
   *   The ID associated with the given contact.
   *
   * @return null
   */
  public function remove($id) {
    return $this->delete('data/contact/' . rawurlencode($id));
  }

  /**
   * @param array $data
   *   An associative array representing a contact, keyed by property name. At a
   *   minimum, this must include the emailAddress key. For further details,
   *   @see http://secure.eloqua.com/api/docs/Static/Rest/2.0/doc.htm#Contact
   *
   * @return array
   *   The contact, with populated accountId, etc.
   *
   * @throws InvalidArgumentException
   */
  public function create($data) {
    if (!isset($data['emailAddress'])) {
      throw new InvalidArgumentException('At a minimum, you must provide an emailAddress.');
    }

    return $this->post('data/contact', $data);
  }

  /**
   * Returns a Subscription client for a contact by its ID.
   *
   * @param int $id
   *   The ID associated with the given contact.
   *
   * @return \Eloqua\Api\Data\Contact\Subscription
   *   A subscription object for the given contact.
   */
  public function subscriptions($id) {
    return new Subscription($this->client, $id);
  }

  /**
   * Returns a Contact List client given a Contact List ID. Useful for searching
   * contacts associated with a contact list.
   *
   * @param int $id
   *   The ID associated with the given contact list.
   *
   * @return \Eloqua\Api\Data\Contact\ContactList
   *   A Contact List client for the given contact list.
   */
  public function lists($id) {
    return new ContactList($this->client, $id);
  }

  /**
   * Returns a Contact Filter client given a Contact Filter ID. Useful for
   * searching contacts associated with a contact filter.
   *
   * @param int $id
   *   The ID associated with the given contact filter.
   *
   * @return \Eloqua\Api\Data\Contact\Filter
   */
  public function filters($id) {
    return new Filter($this->client, $id);
  }

  /**
   * Returns a Contact View client given a Contact View ID. Useful for searching
   * contacts associated with a contact view.
   *
   * @param int $id
   * @return \Guzzle\Http\EntityBodyInterface|mixed|string
   */
  public function views($id) {
    return new View($this->client, $id);
  }

}
