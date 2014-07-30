<?php
namespace Eloqua\DataStructures;

use Eloqua\DataStructures\FieldValue;
use Eloqua\Exception\InvalidArgumentException;


class CustomObjectData {
  public $id;
  public $contactId;
  public $fieldValues;

  /**
   * @param number $contactId
   *  Contact Id associated with Custom Object
   *
   * @param array $fieldValues
   *  Array of FieldValues - the content to put in the Custom Object fields
   *
   * @throws InvalidArgumentException
   */
  public function __construct($contactId = null, array $fieldValues = array()) {
    $this->contactId = $contactId;

    foreach ($fieldValues as $f) {
      if ($f instanceof FieldValue) {
        $this->fieldValues[] = $f;
      } else {
        throw new InvalidArgumentException();
      }
    }
  }

  public static function load($customObjectData) {
    $obj = new self();

    foreach ($customObjectData as $key => $value) {
      switch ($key) {
        case 'fieldValues' :
          foreach ($value as $fieldValue) {
            $obj->fieldValues[] = FieldValue::load($fieldValue);
          }
          break;

        default:
          $obj->$key = $value;

      }
    }

    return $obj;
  }
} 