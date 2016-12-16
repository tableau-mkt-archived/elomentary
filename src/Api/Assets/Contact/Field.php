<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\Contact\Field.
 */

namespace Eloqua\Api\Assets\Contact;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\CreatableInterface;
use Eloqua\Api\DestroyableInterface;
use Eloqua\Api\ReadableInterface;
use Eloqua\Api\SearchableInterface;
use Eloqua\Api\UpdateableInterface;

/**
 * Eloqua contact field.
 */
class Field extends AbstractApi implements CreatableInterface, ReadableInterface, UpdateableInterface, DestroyableInterface, SearchableInterface {

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('assets/contact/fields', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * {@inheritdoc}
   */
  public function show($id, $depth = 'complete', $extensions = null) {
    return $this->get('assets/contact/field/' . rawurlencode($id), array(
      'depth' => $depth,
      'extensions' => $extensions,
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function update($id, $field_data) {
    return $this->put('assets/contact/field/' . rawurlencode($id), $field_data);
  }

  /**
   *{@inheritdoc}
   */
  public function remove($id) {
    return $this->delete('assets/contact/field/' . rawurlencode($id));
  }

  /**
   * {@inheritdoc}
   *
   * @see http://secure.p01.eloqua.com/api/docs/Static/Rest/2.0/doc.htm#ContactField
   */
  public function create($field_data) {
    return $this->post('assets/contact/field', $field_data);
  }

  /**
   * Return a list of dependencies.
   *
   * @param int $id
   *   The ID associated with the given contact field.
   *
   * @return array
   *   An array of dependencies.
   */
  public function dependencies($id) {
    return $this->get('assets/contact/field/' . rawurlencode($id) . '/dependencies');
  }

}
