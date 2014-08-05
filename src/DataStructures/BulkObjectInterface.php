<?php
namespace Eloqua\DataStructures;

interface BulkObjectInterface {

  /**
   * Creates a new mapping object containing Eloqua Markup Language (EML)
   *
   * @param string $id
   *   Bulk API calls require a field specified to be used as a unique-ish
   *   identifier field
   *
   * @param object $sourceObject
   *   Used if an object other than $this should be used to populate
   *   the mapping object
   *
   * @returns object
   */
  public function getImportDefinition($id = null, $sourceObject = null);
}