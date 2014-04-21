<?php

/**
 * @file
 * Contains \Eloqua\HttpClient\Message\ResponseMediator.
 */

namespace Eloqua\HttpClient\Message;

use Guzzle\Http\Message\Response;

class ResponseMediator {

  public static function getContent(Response $response) {
    $body = $response->getBody(true);
    $content = json_decode($body, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      return $body;
    }

    return $content;
  }

  public static function getPagination(Response $response) {
    $content = static::getContent($response);

    if (!isset($content['page']) || !isset($content['pageSize']) || !isset($content['total'])) {
      return null;
    }
    $url = $response->getInfo('url');
    $last_page = ceil($content['total'] / $content['pageSize']);

    // Always set first/last pages.
    $pagination = array(
      'first' => array($url => array('page' => 1, 'count' => $content['pageSize'])),
      'last' => array($url => array('page' => $last_page, 'count' => $content['pageSize'])),
    );

    // Conditionally add next/prev pages.
    if ($content['page'] < $last_page) {
      $pagination['next'] = array($url => array('page' => $content['page'] + 1, 'count' => $content['pageSize']));
    }
    if ($content['page'] > 1) {
      $pagination['prev'] = array($url => array('page' => $content['page'] - 1, 'count' => $content['pageSize']));
    }

    return $pagination;
  }

}
