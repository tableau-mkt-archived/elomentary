<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\Email\Group.
 */

namespace Eloqua\Api\Assets\Email;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\SearchableInterface;

/**
 * Eloqua e-mail group.
 */
class Group extends AbstractApi implements SearchableInterface {

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('assets/email/groups', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * Return extended information about an e-mail group by its ID.
   *
   * @param int $id
   *   The ID associated with the desired e-mail group.
   *
   * @return array
   *   The desired e-mail group record represented as an associative array.
   */
  public function show($id) {
    return $this->get('assets/email/group/' . rawurlencode($id));
  }

  /**
   * Update or replace an e-mail group.
   *
   * @param int $id
   *   The ID associated with the given e-mail group.
   *
   * @param array $data
   *   Full e-mail group details to be updated.
   *
   * @return array
   *   Updated e-mail group data.
   */
  public function update($id, $data) {
    return $this->put('assets/email/group/' . rawurlencode($id), $data);
  }

  /**
   * Delete an e-mail group.
   *
   * @param string $id
   *   The ID associated with the given e-mail group.
   *
   * @return null
   */
  public function remove($id) {
    return $this->delete('assets/email/group/' . rawurlencode($id));
  }

  /**
   * Create an e-mail group.
   *
   * @param array $data
   *   Associative array representing an e-mail group, keyed by property names.
   *   @see http://secure.eloqua.com/api/docs/Static/Rest/2.0/doc.htm#EmailGroup
   *
   * @return array
   *   The e-mail group.
   */
  public function create($data) {
    return $this->post('assets/email/group', $data);
  }

  /**
   * Return a list of dependencies.
   *
   * @param int $id
   *   The ID associated with the given e-mail group.
   *
   * @return array
   *   An array of dependencies.
   */
  public function dependencies($id) {
    return $this->get('assets/email/group/' . rawurlencode($id) . '/dependencies');
  }

}
