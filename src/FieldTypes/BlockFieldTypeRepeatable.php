<?php

namespace Concrete\Package\Tmblocks\Src\FieldTypes;

class BlockFieldTypeRepeatable extends BlockFieldTypeBase {

  protected $childTypes = array();
  protected $addButtonName = "Add Item";

  public function setChildTypes($childTypes){
    $this->childTypes = $childTypes;
  }

  public function getChildTypes()
  {
    return $this->childTypes;
  }

  public function setAddButtonName($addButtonName){
    $this->addButtonName = $addButtonName;
  }

  public function getAddButtonName(){
    return $this->addButtonName;
  }

  public function getAssets(){
    return array('tm/repeatable');
  }
}

