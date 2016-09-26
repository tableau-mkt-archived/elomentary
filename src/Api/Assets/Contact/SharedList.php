<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\Contact\SharedList.
 */

namespace Eloqua\Api\Assets\Contact;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\CreatableInterface;
use Eloqua\Api\DestroyableInterface;
use Eloqua\Api\ReadableInterface;
use Eloqua\Api\SearchableInterface;
use Eloqua\Api\UpdateableInterface;

/**
 * Eloqua shared list.
 */
class SharedList extends AbstractApi implements CreatableInterface, ReadableInterface, UpdateableInterface, DestroyableInterface, SearchableInterface {

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('assets/contact/lists', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * {@inheritdoc}
   */
  public function show($id, $depth = 'complete', $extensions = null) {
    return $this->get('assets/contact/list/' . rawurlencode($id), array(
      'depth' => $depth,
      'extensions' => $extensions,
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function update($id, $shared_list_data) {
    return $this->put('assets/contact/list/' . rawurlencode($id), $shared_list_data);
  }

  /**
   *{@inheritdoc}
   */
  public function remove($id) {
    return $this->delete('assets/contact/list/' . rawurlencode($id));
  }

  /**
   * {@inheritdoc}
   *
   * @see http://secure.p01.eloqua.com/api/docs/Static/Rest/2.0/doc.htm#ContactList
   */
  public function create($shared_list_data) {
    return $this->post('assets/contact/list', $shared_list_data);
  }

  /**
   * Return a list of dependencies.
   *
   * @param int $id
   *   The ID associated with the given contact list.
   *
   * @return array
   *   An array of dependencies.
   */
  public function dependencies($id) {
    return $this->get('assets/contact/list/' . rawurlencode($id) . '/dependencies');
  }

}
