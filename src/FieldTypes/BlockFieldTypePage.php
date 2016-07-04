<?php

namespace Concrete\Package\Tmblocks\Src\FieldTypes;

use Page;

class BlockFieldTypePage extends BlockFieldTypeBase {


  public function validate($e,$value)
  {

    parent::validate($e, $value);

    if (trim($value) == "" || $value == "0"){
      if($this->isRequired()) {
        $e->add(t("%s is required.", $this->getName()));
      }
      return;
    }


    $page = Page::getByID($value);

    if($page->error !== false) {
      $e->add(t("%s is an invalid page.", $this->getName()));
    }

  }

  public function getFormMarkup($form,$view,$k,$value){
    return $this->getFormMarkupPage($form,$view,$k,$value);
  }

  public function getFormMarkupForTemplate($form,$view,$k,$value){
    $markup = $this->getFormMarkup($form,$view,$k,$value);

    preg_match('/data-page-selector="([a-zA-Z0-9]*)"/',$markup,$matches);
    $key = $matches[1];

    $markup = preg_replace("/" . $key . "/","<%= key %>",$markup);

    return preg_replace("/'inputName': '".$k."'/","'inputName': '<%= name %>[".$k."]'",$markup);
  }

  public function getFormMarkupForRepeatable($form,$view,$k,$value, $field,$i){
    $markup = $this->getFormMarkup($form,$view,$k,$value);

    return preg_replace("/'inputName': '".$k."'/","'inputName': '".$field."[".$i."][".$k."]'",$markup);

  }

}




