<?php
namespace Eloqua\DataStructures;
use Eloqua\Exception\InvalidArgumentException;

class CustomObject implements EloquaObjectInterface, BulkObjectInterface {
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

  public function getImportDefinition($identifierFieldName = null, $importObj = null) {
    if (empty($importObj)) {
      $importObj = $this;
    }

    $importEntity = new \stdClass();
    $importEntity->name                    = $importObj->name;
    $importEntity->identifierFieldName     = $identifierFieldName;
    $importEntity->fields                  = new \stdClass();
    $importEntity->fields->email           = "{{CustomObject[$importObj->id].Contact.Field(C_EmailAddress)}}";
//    $importEntity->fields->contactId       = "{{CustomObject[$importObj->id].ContactId}}";
    $importEntity->isSyncTriggeredOnImport = 'false';

    foreach ($importObj->fields as $f) {
      $importEntity->fields->{$f->internalName} = "{{CustomObject[$importObj->id].Field[$f->id]}}";
    }

    // Use the first field if no identifierFieldName is provided
    if (empty($identifierFieldName)) {
      $importEntity->identifierFieldName = $importObj->fields[0]->internalName;
//      $importEntity->identifierFieldName = 'contactId';
    }

    return $importEntity;
  }

  public function getExportDefinition($name, $importObj = null) {
    if (empty($importObj)) {
      $importObj = $this;
    }

    $exportEntity = new \stdClass();
    $exportEntity->name                    = $importObj->name;
    $exportEntity->fields                  = new \stdClass();

    foreach ($importObj->fields as $f) {
      $exportEntity->fields->{$f->internalName} = "{{CustomObject[$importObj->id].Field[$f->id]}}";
    }

    $exportEntity->fields->contactId = "{{CustomObject[$importObj->id].Contact.Id}}";

    return $exportEntity;
  }
}