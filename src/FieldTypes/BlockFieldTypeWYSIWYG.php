<?php

namespace Concrete\Package\Tmblocks\Src\FieldTypes;

use \Concrete\Core\Editor\LinkAbstractor;

class BlockFieldTypeWYSIWYG extends BlockFieldTypeString {

  protected $edittype = "editor";
  protected $name = "Text";


  public function getValueForSet($value){
    return  LinkAbstractor::translateFromEditMode($value);
  }

  public function getValueForSave($value){
    return  LinkAbstractor::translateFromEditMode($value);
  }

  public function getAssets(){
    return array('redactor','core/file-manager');
  }

  public function getFormMarkup($form,$view,$k,$value){
    return $this->getFormMarkupEditor($form,$view,$k,$value);
  }

}

