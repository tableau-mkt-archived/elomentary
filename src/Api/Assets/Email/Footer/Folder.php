<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\Email\Footer\Folder.
 */

namespace Eloqua\Api\Assets\Email\Footer;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\CreatableInterface;
use Eloqua\Api\DestroyableInterface;
use Eloqua\Api\ReadableInterface;
use Eloqua\Api\SearchableInterface;
use Eloqua\Api\UpdateableInterface;

/**
 * Eloqua e-mail footer folder.
 */
class Folder extends AbstractApi implements CreatableInterface, ReadableInterface, UpdateableInterface, DestroyableInterface, SearchableInterface {

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('assets/email/footer/folders', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * {@inheritdoc}
   */
  public function show($id, $depth = 'complete', $extensions = null) {
    return $this->get('assets/email/footer/folder/' . rawurlencode($id), array(
      'depth' => $depth,
      'extensions' => $extensions,
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function update($id, $folder_data) {
    return $this->put('assets/email/footer/folder/' . rawurlencode($id), $folder_data);
  }

  /**
   *{@inheritdoc}
   */
  public function remove($id) {
    return $this->delete('assets/email/footer/folder/' . rawurlencode($id));
  }

  /**
   * {@inheritdoc}
   */
  public function create($folder_data) {
    return $this->post('assets/email/footer/folder', $folder_data);
  }

  /**
   * Returns the contents of an e-mail footer folder.
   *
   * @param int $id
   *   The ID of the e-mail footer folder whose contents you want to load.
   *
   * @return array
   *   An associative array representing the e-mail footer folder contents.
   */
  public function contents($id) {
    return $this->get('assets/email/footer/folder/' . rawurlencode($id) . '/contents');
  }

  /**
   * Return a list of dependencies.
   *
   * @param int $id
   *   The ID associated with the given e-mail footer folder.
   *
   * @return array
   *   An associative array of this e-mail footer folder's dependencies.
   */
  public function dependencies($id) {
    return $this->get('assets/email/footer/folder/' . rawurlencode($id) . '/dependencies');
  }

  /**
   * Syntactic sugar on top of the show() method to get the root folder.
   *
   * @param string $depth
   *   The optional depth at which to return the root folder object.
   *
   * @param string $extensions
   *
   * @return array
   *   An associative array representing the root e-mail footer folder.
   */
  public function root($depth = 'complete', $extensions = null) {
    return $this->show('root', $depth, $extensions);
  }

}
