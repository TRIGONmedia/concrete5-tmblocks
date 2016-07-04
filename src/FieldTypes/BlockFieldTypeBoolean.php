<?php

namespace Concrete\Package\Tmblocks\Src\FieldTypes;

class BlockFieldTypeBoolean extends BlockFieldTypeBase {


  public function getSearchableContent($value)
  {
    return "";
  }

  public function getValueForSave($value)
  {
    return $value ? 1 : 0;
  }


  public function getFormMarkup($form,$view,$k,$value){
    return $this->getFormMarkupCheckbox($form,$view,$k,$value);
  }

  public function validate($e,$value){

    parent::validate($e,$value);

  }

}