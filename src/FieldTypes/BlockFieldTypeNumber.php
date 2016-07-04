<?php

namespace Concrete\Package\Tmblocks\Src\FieldTypes;

class BlockFieldTypeNumber extends BlockFieldTypeBase {

  protected $min = null;
  protected $max = null;

  public function getSearchableContent($value)
  {
    return $value;
  }

  public function getValueForSave($value)
  {
   return empty($value)?"NULL":str_replace(',', '.', $value);
  }

  public function validate($e,$value){

    //TODO nachkommastellen


    parent::validate($e,$value);

    if (trim($value) == ""){
      if($this->isRequired()) {
        $e->add(t("%s is required.", $this->getName()));
      }
      return;
    }


    if(!is_numeric($value)) {
      $e->add(t("%s is an invalid number.", $this->getName()));
    }

    if($this->min != null && $value < $this->min) {
      $e->add(t("%s must be bigger than %d", $this->getName(),$this->min));
    }

    if($this->max != null && $value > $this->max) {
      $e->add(t("%s must be less than %d", $this->getName(),$this->max));
    }
  }

  public function setMin($min){
    $this->min = $min;
  }

  public function setMax($max){
    $this->max = $max;
  }
}