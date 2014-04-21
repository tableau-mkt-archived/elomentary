<?php

/**
 * @file
 * Contains \Eloqua\HttpClient\Listener\AuthListener.
 */

namespace Eloqua\HttpClient\Listener;

use Eloqua\Exception\RuntimeException;
use Guzzle\Common\Event;

class AuthListener {

  private $site;
  private $login;
  private $password;

  public function __construct($site, $login, $password) {
    $this->site = $site;
    $this->login = $login;
    $this->password = $password;
  }

  public function onRequestBeforeSend(Event $event) {
    if (empty($this->site) || empty($this->login) || empty($this->password)) {
      throw new RuntimeException('You must specify authentication details.');
    }

    $credentials = $this->site . '\\' . $this->login . ':' . $this->password;
    $event['request']->setHeader(
      'Authorization',
      sprintf('Basic %s', base64_encode($credentials))
    );
  }

}
