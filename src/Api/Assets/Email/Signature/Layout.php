<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\Email\Signature\Layout.
 */

namespace Eloqua\Api\Assets\Email\Signature;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\CreatableInterface;
use Eloqua\Api\DestroyableInterface;
use Eloqua\Api\ReadableInterface;
use Eloqua\Api\SearchableInterface;
use Eloqua\Api\UpdateableInterface;

/**
 * Eloqua e-mail signature rule.
 */
class Layout extends AbstractApi implements CreatableInterface, ReadableInterface, UpdateableInterface, DestroyableInterface, SearchableInterface {

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('assets/email/signature/layouts', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * {@inheritdoc}
   */
  public function create($data) {
    return $this->post('assets/email/signature/layout', $data);
  }

  /**
   * {@inheritdoc}
   */
  public function show($id, $depth = 'complete', $extensions = null) {
    return $this->get('assets/email/signature/layout/' . rawurlencode($id), array(
      'depth' => $depth,
      'extensions' => $extensions,
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function update($id, $data) {
    return $this->put('assets/email/signature/layout/' . rawurlencode($id), $data);
  }

  /**
   * {@inheritdoc}
   */
  public function remove($id) {
    return $this->delete('assets/email/signature/layout/' . rawurlencode($id));
  }

}
