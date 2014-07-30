<?php

namespace Eloqua\DataStructures;

use Eloqua\Exception\InvalidArgumentException;

class FieldValue {
  public $id;
  public $value;

  public function __construct($id, $value) {
    if (!isset($id, $value)) {
      throw new InvalidArgumentException("An id and value parameter are required for a FieldValue object");
    }

    $this->id = $id;
    $this->value = $value;
  }

  public static function load($fieldValue) {
    $obj = new self($fieldValue['id'], $fieldValue['value']);
    return $obj;
  }
} 