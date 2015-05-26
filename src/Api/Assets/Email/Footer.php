<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\Email\Footer.
 */

namespace Eloqua\Api\Assets\Email;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\Assets\Email\Footer\Folder as FooterFolder;
use Eloqua\Api\CreatableInterface;
use Eloqua\Api\DestroyableInterface;
use Eloqua\Api\ReadableInterface;
use Eloqua\Api\SearchableInterface;
use Eloqua\Api\UpdateableInterface;

/**
 * Eloqua e-mail footer.
 */
class Footer extends AbstractApi implements CreatableInterface, ReadableInterface, UpdateableInterface, DestroyableInterface, SearchableInterface {

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('assets/email/footers', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * {@inheritdoc}
   */
  public function show($id, $depth = 'complete', $extensions = null) {
    return $this->get('assets/email/footer/' . rawurlencode($id), array(
      'depth' => $depth,
      'extensions' => $extensions,
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function update($id, $footer_data) {
    return $this->put('assets/email/footer/' . rawurlencode($id), $footer_data);
  }

  /**
   *{@inheritdoc}
   */
  public function remove($id) {
    return $this->delete('assets/email/footer/' . rawurlencode($id));
  }

  /**
   * {@inheritdoc}
   */
  public function create($footer_data) {
    return $this->post('assets/email/footer', $footer_data);
  }

  /**
   * Copies an e-mail footer.
   *
   * @param int $id
   *   The ID of the e-mail footer you want to copy.
   *
   * @return array
   *   An associative array representing the copied e-mail footer.
   */
  public function copy($id) {
    return $this->post('assets/email/footer/' . rawurlencode($id) . '/copy');
  }

  /**
   * Return a list of dependencies.
   *
   * @param int $id
   *   The ID associated with the given e-mail footer.
   *
   * @return array
   *   An associative array of this e-mail footer's dependencies.
   */
  public function dependencies($id) {
    return $this->get('assets/email/footer/' . rawurlencode($id) . '/dependencies');
  }

  /**
   * Returns a list of security grants for the provided e-mail footer.
   *
   * @param int $id
   *   The ID associated with the given e-mail footer.
   *
   * @param array $options
   *   An associative array of options.
   *
   * @return array
   *   An associative array of this e-mail footer's security grants.
   */
  public function showGrants($id, $options = array()) {
    return $this->get('assets/email/footer/' . rawurlencode($id) . '/security/grants', $options);
  }

  /**
   * Updates this e-mail footer's security grants.
   *
   * @param int $id
   *   The ID associated with the given e-mail footer.
   *
   * @param array $grant_data
   *   An associative array of security grant data.
   *
   * @return array
   *   An associative array of the updated e-mail footer security grants.
   */
  public function updateGrants($id, $grant_data) {
    return $this->patch('assets/email/footer/' . rawurlencode($id) . '/security/grants', $grant_data);
  }

  /**
   * Returns an e-mail footer folder client.
   *
   * @return \Eloqua\Api\Assets\Email\Footer\Folder
   */
  public function folders() {
    return new FooterFolder($this->client);
  }

}
