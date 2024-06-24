<?php

/**
 * @file
 * Contains \Eloqua\HttpClient\Listener\ErrorListener.
 */

namespace Eloqua\HttpClient\Listener;

use Eloqua\HttpClient\Message\ResponseMediator;
use Guzzle\Common\Event;
use Guzzle\Http\Message\Response;

use Eloqua\Exception\ErrorException;
use Eloqua\Exception\RuntimeException;

class ErrorListener {
  /**
   * @var array
   */
  private $options;

  /**
   * @param array $options
   */
  public function __construct(array $options) {
    $this->options = $options;
  }

  /**
   * {@inheritDoc}
   */
  public function onRequestError(Event $event) {
    /** @var $request \Guzzle\Http\Message\Request */
    $request = $event['request'];
    $response = $request->getResponse();

    if ($response->isClientError() || $response->isServerError()) {
      $content = ResponseMediator::getContent($response);

      if (empty($content)) {
        throw new RuntimeException($response->getReasonPhrase(), $response->getStatusCode());
      }
      elseif (is_array($content)) {
        $error = $content[0];
        if (400 == $response->getStatusCode()) {
          if (isset($error['property']) && isset($error['requirement'])) {
            throw new ErrorException(sprintf('%s - %s (%s)', $error['type'], $error['property'], $error['requirement']['type']), 400);
          }
          else {
            throw new ErrorException(sprintf('%s - %s', $error['type'], $error['message'] ? $error['message'] : json_encode($content)), 400);
          }
        }
      }
      else {
        throw new RuntimeException(json_encode($content), $response->getStatusCode());
      }
    }
  }
}
