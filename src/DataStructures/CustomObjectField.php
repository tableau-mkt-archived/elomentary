<?php

namespace Eloqua\DataStructures;


use Eloqua\Exception\InvalidArgumentException;

class CustomObjectField implements EloquaObjectInterface, BulkObjectInterface {

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

  public function getImportDefinition($parentId = null, $importObject = null) {
    if (!isset($parentId)) {
      throw new InvalidArgumentException('CustomObjectField EML needs a $parentId to be created');
    }

    if (empty($importObject)) {
      $importObject = $this;
    }

    $importEntity = new \stdClass();
    $importEntity->{$importObject->internalName} = "{{CustomObject[$parentId].Field[$importObject->id]}}";

    return $importEntity;
  }
} 