<?php
namespace Eloqua\DataStructures;
use Eloqua\Exception\InvalidArgumentException;

class CustomObject implements EloquaObjectInterface {
  public $id;
  public $name;
  public $description;
  public $depth;
  public $fields;
  public $displayNameFieldId;
  public $uniqueCodeFieldId;

  public function __construct($name, $description = null, $depth = null, array $fields = array()) {
    $this->name = $name;
    $this->description = $description;
    $this->depth = $depth;

    foreach ($fields as $f) {
      if ($f instanceof CustomObjectField) {
        $this->fields[] = $f;
      } else {
        throw new InvalidArgumentException();
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function load($customObject) {
    $obj = new self($customObject['name']);

    foreach ($customObject as $key => $value) {
      switch ($key) {
        case 'fields' :
          foreach ($value as $customObjectField) {
            $obj->fields[] = CustomObjectField::load($customObjectField);
          }
          break;

        default:
          $obj->$key = $value;

      }
    }

    return $obj;
  }
}