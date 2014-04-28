<?php

/**
 * @file
 * Contains \Eloqua\Api\ApiInterface.
 */

namespace Eloqua\Api;

use Eloqua\Client;

/**
 * API interface.
 */
interface ApiInterface {

  public function __construct(Client $client);

  public function getCount();

  public function setCount($count);

}
