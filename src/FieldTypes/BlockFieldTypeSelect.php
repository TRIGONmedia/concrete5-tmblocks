<?php

namespace Concrete\Package\Tmblocks\Src\FieldTypes;

class BlockFieldTypeSelect extends BlockFieldTypeString {

  protected $choices = array(
  );

  public function getFormMarkup($form,$view,$k,$value){
    return $this->getFormMarkupSelect($form,$view,$k,$value);
  }
}

