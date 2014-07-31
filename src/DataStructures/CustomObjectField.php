<?php

namespace Eloqua\DataStructures;


class CustomObjectField implements EloquaObjectInterface {

  public $name;
  public $dataType;
  public $defaultValue;
  public $displayType;
  public $depth;
  public $internalName;

  public function __construct($name, $dataType = 'text', $defaultValue = null, $displayType = null, $depth = null) {
    $this->name = $name;
    $this->dataType = $dataType;
    $this->defaultValue = $defaultValue;
    $this->displayType = $displayType;
    $this->depth = $depth;
  }

  /**
   * {@inheritdoc}
   */
  public static function load($customObjectField) {
    $obj = new self($customObjectField['name']);

    foreach ($customObjectField as $key => $value) {
      $obj->$key = $value;
    }

    return $obj;
  }
} 