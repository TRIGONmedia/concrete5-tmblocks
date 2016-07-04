<?php

namespace Concrete\Package\Tmblocks\Src\FieldTypes;

use Core;
use File;

abstract class BlockFieldTypeBase {

  protected $choices = null;
  protected $required = false;
  protected $name = "Unknown";
  protected $edittype = "input";

  public function setChoices($choices){
    $this->choices = $choices;
  }

  public function getChoices(){
    return $this->choices;
  }

  public function setName($name){
    $this->name = $name;
  }

  public function getName(){
    return t($this->name);
  }

  public function getSearchableContent($value)
  {
    return "";
  }

  public function setRequired($required){
    $this->required = $required;
  }

  public function getAssets(){
    return array();
  }

  public function getValueForSet($value){
    return $value;
  }

  public function getValueForView($value){
    return $this->getValueForSet($value);
  }

  public function isRequired(){
    return $this->required;
  }

  public function getEditType(){
    return $this->edittype;
  }

  public function getValueForSave($value){
    return $value;
  }

  public function validate($e,$value){

    if($this->required && (!isset($value) || trim($value) === "")){
      $e->add(t("%s is required."), $this->getName());
    }

    $choices = $this->getChoices();
    if($choices !== null && (!isset($value) || array_search($value,array_keys($choices)) === false )){
      $e->add(t("%s is invalid. Possible choises are %s.", $this->getName(), join(", ",array_keys($choices))));
    }

  }

  protected function getLabel($form,$childField)
  {

    $label = $form->label($childField, $this->getName());
    if ($this->isRequired()) {
      $label .= ' <small class="required">' . t('Required') . '</small>';
    }

    return $label;
  }

  protected function getFormMarkupCheckbox($form,$view,$k,$value){

    return "<label>".$form->checkbox($k, 1, (!is_null($value) && $value != 0))."&nbsp;".t($this->getName())."</label>";
  }

  protected function getFormMarkupEditor($form,$view,$k,$value){
    return $this->getLabel($form,$k).Core::make('editor')->outputBlockEditModeEditor($view->field($k), $value);
  }

  protected function getFormMarkupSelect($form,$view,$k,$value){
    return $this->getLabel($form,$k).$form->select($view->field($k), $this->getChoices(), $value, array());
  }

  protected function getFormMarkupPage($form,$view,$k,$value){
    return $this->getLabel($form,$k).Core::make("helper/form/page_selector")->selectPage($view->field($k), $value);
  }

  protected function getFormMarkupInput($form,$view,$k,$value){
    return $this->getLabel($form,$k).$form->text($view->field($k), $value, array());
  }

  protected function getFormMarkupImage($form,$view,$k,$value){

    if (isset($value) && $value > 0) {
      $value_o = File::getByID($value);
      if (!isset($value_o) || $value_o == null || $value_o->isError()) {
        unset($value_o);
      }
    }

    return $this->getLabel($form,$k).Core::make("helper/concrete/asset_library")->file($view->field('ccm-b-file-image'), "image", t("Choose File"), $value_o);
  }


  public function getFormMarkup($form,$view,$k,$value){
    return $this->getFormMarkupInput($form,$view,$k,$value);
  }

  public function getFormMarkupForTemplate($form,$view,$k,$value){
    $markup = $this->getFormMarkup($form,$view,$k,$value);

    return preg_replace(array(
      '/id="'.$k.'"/',
      '/name="'.$k.'"/'
    ),array(
      'id="<%= id %>_'.$k.'"',
      'name="<%= name %>['.$k.']"'
    ),$markup);
  }

  public function getFormMarkupForRepeatable($form,$view,$k,$value, $field,$i){
    $markup = $this->getFormMarkup($form,$view,$k,$value);

    return preg_replace(array(
      '/id="'.$k.'"/',
      '/name="'.$k.'"/'
    ),array(
      'id="'.$field.'_'.$i.'_'.$k.'"',
      'name="'.$field.'['.$i.']['.$k.']"'
    ),$markup);
  }
}
