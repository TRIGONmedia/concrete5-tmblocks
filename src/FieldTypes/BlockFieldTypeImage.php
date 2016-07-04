<?php

namespace Concrete\Package\Tmblocks\Src\FieldTypes;

use Page;
use File;

class BlockFieldTypeImage extends BlockFieldTypeBase {

  public function validate($e,$value){

    parent::validate($e,$value);

    if(trim($value) == "" || $value == "0" || !is_object(File::getByID($value))) {
      $e->add(t("%s is an invalid image file.", $this->getName()));
    }

  }

  public function getFormMarkup($form,$view,$k,$value){
    return $this->getFormMarkupImage($form,$view,$k,$value);
  }

  public function getValueForView($value)
  {
    if ($value && ($f = File::getByID($value)) && is_object($f)) {
      return $f;
    } else {
      return null;
    }
  }
}




