<?php

namespace Concrete\Package\Tmblocks\Src\FieldTypes;

class BlockFieldTypeRepeatable extends BlockFieldTypeBase
{

  protected $childTypes = array();
  protected $addButtonName = "Add Item";

  public function setChildTypes($childTypes)
  {
    $this->childTypes = $childTypes;
  }

  public function getChildTypes()
  {
    return $this->childTypes;
  }

  public function setAddButtonName($addButtonName)
  {
    $this->addButtonName = $addButtonName;
  }

  public function getAddButtonName()
  {
    return $this->addButtonName;
  }

  public function getAssets()
  {
    return array('tm/repeatable');
  }

  public function getDataForView($rawdata)
  {
    $data = array();
    foreach ($this->getChildTypes() AS $ck => $ct) {
      foreach ($rawdata AS $rk => $rv) {
        if (isset($rv[$ck])) {
          if (!is_array($data[$rk])) {
            $data[$rk] = array();
          }
          $data[$rk][$ck] = $ct->getValueForView($rv[$ck]);
        }
      }
    }
    return $data;
  }
}

