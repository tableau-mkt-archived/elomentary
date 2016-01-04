<?php

/**
 * @file
 * Contains \Eloqua\Api\Contact\Segment.
 */

namespace Eloqua\Api\Data\Contact;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\SearchableInterface;
use Eloqua\Client;

/**
 * Eloqua Contact Segment.
 */
class Segment extends AbstractApi implements SearchableInterface {

  /**
   * The contact segment ID
   *
   * @var int
   */
  protected $segmentId;

  /**
   * Create a Contact List object.
   *
   * @param Client $client
   *   The API client.
   *
   * @param int $segmentId
   *   The ID of the contact segment from which we want contacts.
   */
  public function __construct(Client $client, $segmentId) {
    $this->segmentId = $segmentId;
    parent::__construct($client);
  }

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('data/contacts/segment/' . rawurlencode($this->segmentId), array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * Search for contacts that are included in this segment.
   * @param string $search
   * @param array $options
   * @return \Guzzle\Http\EntityBodyInterface|mixed|string
   */
  public function searchIncluded($search, array $options = array()) {
    return $this->get('data/contacts/segment/' . rawurlencode($this->segmentId) . '/included', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * Search contacts that are excluded in this segment.
   * @param string $search
   * @param array $options
   * @return \Guzzle\Http\EntityBodyInterface|mixed|string
   */
  public function searchExcluded($search, array $options = array()) {
    return $this->get('data/contacts/segment/' . rawurlencode($this->segmentId) . '/excluded', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * @todo Document this method.
   */
  public function export($data) {
    return $this->post('data/contacts/segment/' . rawurlencode($this->segmentId) . '/export', $data);
  }

}
