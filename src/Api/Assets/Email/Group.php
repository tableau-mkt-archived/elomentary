<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\Email\Group.
 */

namespace Eloqua\Api\Assets\Email;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\CreatableInterface;
use Eloqua\Api\DestroyableInterface;
use Eloqua\Api\ReadableInterface;
use Eloqua\Api\SearchableInterface;
use Eloqua\Api\UpdateableInterface;

/**
 * Eloqua e-mail group.
 */
class Group extends AbstractApi implements CreatableInterface, ReadableInterface, UpdateableInterface, DestroyableInterface, SearchableInterface {

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('assets/email/groups', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * {@inheritdoc}
   */
  public function show($id, $depth = 'complete', $extensions = null) {
    return $this->get('assets/email/group/' . rawurlencode($id), array(
      'depth' => $depth,
      'extensions' => $extensions,
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function update($id, $group_data) {
    return $this->put('assets/email/group/' . rawurlencode($id), $group_data);
  }

  /**
   *{@inheritdoc}
   */
  public function remove($id) {
    return $this->delete('assets/email/group/' . rawurlencode($id));
  }

  /**
   * {@inheritdoc}
   *
   * @see http://secure.eloqua.com/api/docs/Static/Rest/2.0/doc.htm#EmailGroup
   */
  public function create($group_data) {
    return $this->post('assets/email/group', $group_data);
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
