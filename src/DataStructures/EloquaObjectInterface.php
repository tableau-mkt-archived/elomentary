<?php
namespace Eloqua\DataStructures;

interface EloquaObjectInterface {

  /**
   * Creates a new object from an Eloqua REST API response
   *
   * @param array|object $eloquaObject
   * @return mixed
   */
  public static function load($eloquaObject);
}