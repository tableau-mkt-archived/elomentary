<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\Email.
 */

namespace Eloqua\Api\Assets;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\Assets\Email\Folder;
use Eloqua\Api\Assets\Email\Footer;
use Eloqua\Api\Assets\Email\Group;
use Eloqua\Api\Assets\Email\Deployment;
use Eloqua\Api\Assets\Email\Header;
use Eloqua\Api\CreatableInterface;
use Eloqua\Api\DestroyableInterface;
use Eloqua\Api\ReadableInterface;
use Eloqua\Api\SearchableInterface;
use Eloqua\Api\UpdateableInterface;
use Eloqua\Exception\InvalidArgumentException;

/**
 * Eloqua Email.
 */
class Email extends AbstractApi implements SearchableInterface, CreatableInterface, ReadableInterface, DestroyableInterface, UpdateableInterface {

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('assets/emails', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * Returns an e-mail group client.
   *
   * @return \Eloqua\Api\Assets\Email\Group
   *   An e-mail group client.
   */
  public function groups() {
    return new Group($this->client);
  }

  /**
   * Returns an e-mail deployment client.
   *
   * @return \Eloqua\Api\Assets\Email\Deployment
   *   An e-mail deployment client.
   */
  public function deployments() {
    return new Deployment($this->client);
  }

  /**
   * Returns an e-mail folder client.
   *
   * @return \Eloqua\Api\Assets\Email\Folder
   */
  public function folders() {
    return new Folder($this->client);
  }

  /**
   * Returns an e-mail footer client.
   *
   * @return \Eloqua\Api\Assets\Email\Footer
   */
  public function footers() {
    return new Footer($this->client);
  }

  /**
   * Returns an e-mail header client.
   *
   * @return \Eloqua\Api\Assets\Email\Header
   */
  public function headers() {
    return new Header($this->client);
  }

  /**
   * Return extended information about an email by its ID.
   *
   * @param int $id
   *   The ID associated with the desired email.
   *
   * @return array
   *   The desired email record represented as an associative array.
   */
  public function show($id, $depth = 'complete', $extensions = null) {
    return $this->get('assets/email/' . rawurlencode($id), array(
      'depth' => $depth,
      'extensions' => $extensions,
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function update($id, $email_data) {
    return $this->put('assets/email/' . rawurlencode($id), $email_data);
  }

  /**
   * Create an email.
   *
   * @param string $name
   *   The desired name of the email.
   *
   * @param array $options
   *   An optional array of additional query parameters to be passed.
   *
   * @return array
   *   The created email record represented as an associative array.
   *
   * @throws InvalidArgumentException
   */
  public function create($name, array $options = array()) {
    $params = array_merge(array('name' => $name), $options);

    // Validate the request before sending it.
    $required = array('name', 'subject', 'folderId', 'emailGroupId');

    foreach ($required as $key) {
      $this->validateExists($params, $key);
    }

    return $this->post('assets/email', $params);
  }

  /**
   * Remove an email by its ID.
   *
   * @param int $id
   *   The ID associated with the desired email.
   *
   * @throws InvalidArgumentException
   */
  public function remove($id) {
    if (empty($id) || !is_numeric($id)) {
      throw new InvalidArgumentException('ID must be numeric');
    }
    return $this->delete('assets/email/' . rawurlencode($id));
  }

  /**
   * Returns e-mail configurations for this Eloqua instance.
   *
   * @return array
   *   An associative array representing e-mail configuration.
   */
  public function showConfig() {
    return $this->get('assets/email/config');
  }

  /**
   * Updates e-mail configurations for this Eloqua instance.
   *
   * @param array $config_data
   *   Updated e-mail configuration data.
   *
   * @return array
   *   An associative array representing the updated e-mail configurations.
   */
  public function updateConfig($config_data) {
    return $this->put('assets/email/config', $config_data);
  }

}
