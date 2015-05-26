<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\Email\Header.
 */

namespace Eloqua\Api\Assets\Email;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\CreatableInterface;
use Eloqua\Api\DestroyableInterface;
use Eloqua\Api\ReadableInterface;
use Eloqua\Api\SearchableInterface;
use Eloqua\Api\UpdateableInterface;

/**
 * Eloqua e-mail header.
 */
class Header extends AbstractApi implements CreatableInterface, ReadableInterface, UpdateableInterface, DestroyableInterface, SearchableInterface {

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('assets/email/headers', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * {@inheritdoc}
   */
  public function show($id, $depth = 'complete', $extensions = null) {
    return $this->get('assets/email/header/' . rawurlencode($id), array(
      'depth' => $depth,
      'extensions' => $extensions,
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function update($id, $header_data) {
    return $this->put('assets/email/header/' . rawurlencode($id), $header_data);
  }

  /**
   *{@inheritdoc}
   */
  public function remove($id) {
    return $this->delete('assets/email/header/' . rawurlencode($id));
  }

  /**
   * {@inheritdoc}
   */
  public function create($header_data) {
    return $this->post('assets/email/header', $header_data);
  }

  /**
   * Copies an e-mail header.
   *
   * @param int $id
   *   The ID of the e-mail header you want to copy.
   *
   * @return array
   *   An associative array representing the copied e-mail header.
   */
  public function copy($id) {
    return $this->post('assets/email/header/' . rawurlencode($id) . '/copy');
  }

  /**
   * Return a list of dependencies.
   *
   * @param int $id
   *   The ID associated with the given e-mail header.
   *
   * @return array
   *   An associative array of this e-mail header's dependencies.
   */
  public function dependencies($id) {
    return $this->get('assets/email/header/' . rawurlencode($id) . '/dependencies');
  }

  /**
   * Returns a list of security grants for the provided e-mail header.
   *
   * @param int $id
   *   The ID associated with the given e-mail header.
   *
   * @param array $options
   *   An associative array of options.
   *
   * @return array
   *   An associative array of this e-mail header's security grants.
   */
  public function showGrants($id, $options = array()) {
    return $this->get('assets/email/header/' . rawurlencode($id) . '/security/grants', $options);
  }

  /**
   * Updates this e-mail header's security grants.
   *
   * @param int $id
   *   The ID associated with the given e-mail header.
   *
   * @param array $grant_data
   *   An associative array of security grant data.
   *
   * @return array
   *   An associative array of the updated e-mail header security grants.
   */
  public function updateGrants($id, $grant_data) {
    return $this->patch('assets/email/header/' . rawurlencode($id) . '/security/grants', $grant_data);
  }

}
