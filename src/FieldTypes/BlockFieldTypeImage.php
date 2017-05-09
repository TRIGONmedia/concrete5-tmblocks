<?php

namespace Concrete\Package\Tmblocks\Src\FieldTypes;

use Page;
use File;
use Core;

class BlockFieldTypeImage extends BlockFieldTypeBase {

  public function validate($e,$value){

    parent::validate($e,$value);

    if( ($this->isRequired() == true) && (trim($value) == "" || $value == "0" || !is_object(File::getByID($value)))) {
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


  public function getFormMarkupForRepeatable($form,$view,$k,$value, $field,$i){

    if (isset($value) && $value > 0) {
      $value_o = File::getByID($value);
      if (!isset($value_o) || $value_o == null || $value_o->isError()) {
        unset($value_o);
      }
    }

    return $this->getLabel($form,$k).Core::make("helper/concrete/asset_library")->file($field.'_'.$i.'_'.$k, $field.'['.$i.']['.$k.']', t("Choose File"), $value_o);
  }
}




