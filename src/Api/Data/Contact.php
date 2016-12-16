<?php

/**
 * @file
 * Contains \Eloqua\Api\Contact.
 */

namespace Eloqua\Api\Data;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\Assets\Contact\Field;
use Eloqua\Api\Assets\Contact\SharedList;
use Eloqua\Api\CreatableInterface;
use Eloqua\Api\Data\Contact\ContactList;
use Eloqua\Api\Data\Contact\Filter;
use Eloqua\Api\Data\Contact\Segment;
use Eloqua\Api\Data\Contact\Subscription;
use Eloqua\Api\Data\Contact\View;
use Eloqua\Api\Data\Contact\Bulk;
use Eloqua\Api\DestroyableInterface;
use Eloqua\Api\ReadableInterface;
use Eloqua\Api\SearchableInterface;
use Eloqua\Api\UpdateableInterface;
use Eloqua\Exception\InvalidArgumentException;

/**
 * Eloqua Contact.
 */
class Contact extends AbstractApi implements CreatableInterface, ReadableInterface, UpdateableInterface, DestroyableInterface, SearchableInterface {

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('data/contacts', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * {@inheritdoc}
   */
  public function show($id, $depth = 'complete', $extensions = null) {
    return $this->get('data/contact/' . rawurlencode($id), array(
      'depth' => $depth,
      'extensions' => $extensions,
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function update($id, $contact_data) {
    return $this->put('data/contact/' . rawurlencode($id), $contact_data);
  }

  /**
   * {@inheritdoc}
   */
  public function remove($id) {
    return $this->delete('data/contact/' . rawurlencode($id));
  }

  /**
   * {@inheritdoc}
   *
   * @throws InvalidArgumentException
   * @see http://secure.p01.eloqua.com/api/docs/Static/Rest/2.0/doc.htm#Contact
   */
  public function create($contact_data) {
    if (!isset($contact_data['emailAddress'])) {
      throw new InvalidArgumentException('At a minimum, you must provide an emailAddress.');
    }

    return $this->post('data/contact', $contact_data);
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
   * Returns a Contact Segment client given a Segment ID. Useful for searching
   * contacts associated with a given segment.
   *
   * @param int $id
   *   The ID associated with the given segment.
   *
   * @return \Eloqua\Api\Data\Contact\Segment
   *   A contact segment client for the given segment.
   */
  public function segments($id) {
    return new Segment($this->client, $id);
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

  /**
   * Returns a contact field client.
   *
   * @return \Eloqua\Api\Assets\Contact\Field
   *   A contact field client.
   */
  public function fields() {
    return new Field($this->client);
  }

  /**
   * Returns a shared list client.
   *
   * @return \Eloqua\Api\Assets\Contact\SharedList
   *   A shared list client.
   */
  public function sharedLists() {
    return new SharedList($this->client);
  }

  /**
   * Returns a bulk contact client.
   *
   * @return \Eloqua\Api\Data\Contact\Bulk
   *   A bulk contact client.
   */
  public function bulk() {
    return new Bulk($this->client);
  }
}
