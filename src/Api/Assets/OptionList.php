<?php

/**
 * @file
 * Contains \Eloqua\Api\Assets\OptionList.
 */

namespace Eloqua\Api\Assets;

use Eloqua\Api\AbstractApi;
use Eloqua\Api\CreatableInterface;
use Eloqua\Api\DestroyableInterface;
use Eloqua\Api\ReadableInterface;
use Eloqua\Api\SearchableInterface;
use Eloqua\Api\UpdateableInterface;
use Eloqua\Exception\InvalidArgumentException;

/**
 * Eloqua Email.
 */
class OptionList extends AbstractApi implements SearchableInterface, CreatableInterface, ReadableInterface, DestroyableInterface, UpdateableInterface {

  /**
   * {@inheritdoc}
   */
  public function search($search, array $options = array()) {
    return $this->get('assets/optionLists', array_merge(array(
      'search' => $search,
    ), $options));
  }

  /**
   * {@inheritdoc}
   */
  public function show($id, $depth = 'complete', $extensions = null) {
    return $this->get('assets/optionList/' . rawurlencode($id), array(
      'depth' => $depth,
      'extensions' => $extensions,
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function update($id, $optionList) {
    if (!isset($optionList['id']) or $optionList['id'] != $id) {
      throw new InvalidArgumentException('The id parameter in the optionList definition must match the $id parameter in function signature');
    }
    return $this->put('assets/optionList/' . rawurlencode($id), $optionList);
  }

  /**
   * {@inheritdoc}
   */
  public function create($optionsList) {
    if (!isset($optionsList['name'])) {
      throw new InvalidArgumentException('New OptionLists are required to have a name parameter');
    }

    if (isset($optionsList['elements'])) {
      foreach ($optionsList['elements'] as $o) {
        if (!isset($o['displayName'], $o['value'])) {
          throw new InvalidArgumentException('Option fields are required to have a displayName and value parameter');
        }
      } // @codeCoverageIgnoreStart
    } // @codeCoverageIgnoreEnd

    return $this->post('assets/optionList', $optionsList);
  }

  /**
   * {@inheritdoc}
   */
  public function remove($id) {
    return $this->delete('assets/optionList/' . rawurlencode($id));
  }
}
