<?php

/**
 * @file
 * Contains \Eloqua\Tests\Mock\TestResponse.
 */

namespace Eloqua\Tests\Mock;

use Guzzle\Http\Message\Response;

class TestResponse extends Response {

  protected $loopCount;

  protected $loopCountInit;

  protected $content;

  public function __construct($loopCount, array $content = array()) {
    $this->loopCount = $loopCount;
    $this->loopCountInit = 1;
    $this->content = $content;
  }

  /**
   * {@inheritDoc}
   */
  public function getBody($asString = false) {
    // Set false pager details.
    $this->content['page'] = $this->loopCountInit;
    $this->content['pageSize'] = count($this->content['elements']);
    $this->content['total'] = $this->loopCount * $this->content['pageSize'];

    $this->loopCountInit++;
    return json_encode($this->content);
  }

}
