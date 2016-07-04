<?php

namespace Concrete\Package\Tmblocks\Src;

use Concrete\Package\Tmblocks\Src\FieldTypes\BlockFieldTypeRepeatable;
use Core;
use Loader;
use \File;
use Database;
use Page;
use URL;
use Config;
use Concrete\Core\Legacy\BlockRecord;
use Concrete\Core\Block\BlockController;
use Concrete\Package\Tmblocks\Src\FieldTypes\BlockFieldTypeSelect;
use Concrete\Package\Tmblocks\Src\FieldTypes\BlockFieldTypeBoolean;


abstract class TmBlockController extends BlockController
{

  protected $tmFields = array();
  protected $tmTabs = array();


  protected $btInterfaceWidth = 600;
  protected $btInterfaceHeight = 500;
  protected $btCacheBlockRecord = true;
  protected $btCacheBlockOutput = true;
  protected $btCacheBlockOutputOnPost = true;
  protected $btCacheBlockOutputForRegisteredUsers = true;
  protected $btCacheBlockOutputLifetime = 0;
  protected $pkg = false;
  protected $btDefaultSet = 'Basic';

  function __construct($obj = null)
  {

    parent::__construct($obj);

    $cssClass = new BlockFieldTypeSelect();
    $cssClass->setRequired(true);
    $cssClass->setName("CSS-Class");
    $cssClass->setChoices(array('none' => 'none'));
    $this->tmFields["cssClass"] = $cssClass;

    $ignoreGrid = new BlockFieldTypeBoolean();
    $ignoreGrid->setName("Ignore Grid");
    $this->tmFields["ignoreGrid"] = $ignoreGrid;


  }

  public function getSearchableContent()
  {
    $searchableContent = "";
    foreach ($this->tmFields AS $k => $ft) {
      $searchableContent .= " " . $ft->getSearchableContent($this->$k);
    }
    return $searchableContent;
  }

  protected function setFieldTypes()
  {
    $this->set("tmTabs", $this->tmTabs);
    $this->set("tmFields", $this->tmFields);
  }

  protected function setFieldValues()
  {
    foreach ($this->tmFields AS $k => $ft) {
      $this->set($k, $ft->getValueForSet($this->$k));
    }
  }

  protected function requireAssets()
  {
    foreach ($this->tmFields AS $k => $ft) {
      foreach ($ft->getAssets() AS $asset) {
        $this->requireAsset($asset);
      }
    }
  }

  protected function setFieldTypesForView()
  {
    foreach ($this->tmFields AS $k => $ft) {
      $this->set($k, $ft->getValueForView($this->$k));
    }
  }

  protected function setRepeatablesData(){
    foreach($this->getRepeatablesData() AS $k => $data){
      $this->set($k,$data);
    }
  }

  public function view()
  {
    $this->setFieldTypes();
    $this->setFieldTypesForView();
    $this->setRepeatablesData();
  }

  public function add()
  {
    $this->requireAssets();
    $this->setFieldTypes();
    $this->setFieldValues();

  }

  public function edit()
  {
    $db = \Database::get();
    $this->requireAssets();
    $this->setFieldTypes();
    $this->setFieldValues();
    $this->setRepeatablesData();

  }

  public function duplicate($newBID)
  {
    parent::duplicate($newBID);
    $db = \Database::get();
    $allRepeatableData = $this->getRepeatablesData();
    foreach($allRepeatableData AS $k => $thisRepeatableData)
    {
      foreach ($thisRepeatableData as $rowData) {
        unset($rowData['iID']);
        $db->insert($this->btTable . ucfirst($k), $rowData);
      }
    }
  }


  public function validate($args)
  {
    $e = Core::make("helper/validation/error");

    foreach ($this->tmFields AS $k => $ft) {
      $ft->validate($e, $args[$k]);
    }

    return $e;
  }

  private function getRepeatablesData(){

    $data = array();

    foreach ($this->tmFields AS $k => $ft) {
      if ($ft instanceof BlockFieldTypeRepeatable) {
        $db = \Database::get();
        $data[$k] = $db->GetAll('SELECT * from '.$this->btTable . ucfirst($k).' WHERE bID = ? ORDER BY sort', array($this->bID));
      }
    }

    return $data;
  }

  public function save($args)
  {
    $db = Database::get();

    $repeatables = array();

    foreach ($this->tmFields AS $k => $ft) {
      $args[$k] = $ft->getValueForSave($args[$k]);
      if ($ft instanceof BlockFieldTypeRepeatable) {
        $repeatables[$k] = $ft;
      }
    }

    if ($this->btTable) {
      $db = Database::connection();
      $columns = $db->MetaColumnNames($this->btTable);
      $this->record = new BlockRecord($this->btTable);
      $this->record->bID = $this->bID;
      foreach ($columns as $key) {
        if (isset($args[$key])) {
          if ($args[$key] === "NULL") {
            $this->record->{$key} = null;
          } else {
            $this->record->{$key} = $args[$key];
          }
        }
      }
      $this->record->Replace();
      if ($this->cacheBlockRecord() && Config::get('concrete.cache.blocks')) {
        $record = base64_encode(serialize($this->record));
        $db = Database::connection();
        $db->Execute('update Blocks set btCachedBlockRecord = ? where bID = ?', array($record, $this->bID));
      }
    }

    //repeatable
    $allRepeatablesData = $this->getRepeatablesData();

    foreach ($repeatables AS $k => $repeatable) {

      $thisRepeatableData = array();

      if(isset($allRepeatablesData[$k])){
        foreach($allRepeatablesData[$k] AS $rowData) {
          $thisRepeatableData[$rowData["iID"]] = $rowData;
        }
      }

      $db = Database::get();

      $i = 0;
      foreach ($args[$k] AS $data) {

        $i++;
        $data['sort'] = $i;
        $data['bID'] = $this->record->bID;

        if(isset($thisRepeatableData[$data["iID"]])){
          $db->update($this->btTable . ucfirst($k), $data, array('iID' => $data["iID"]));
          unset($thisRepeatableData[$data["iID"]]);
        }else{
          $db->insert($this->btTable . ucfirst($k), $data);
        }
      }

      foreach($thisRepeatableData AS $deleteRow){
        $db->delete($this->btTable . ucfirst($k), array('iID' => $deleteRow["iID"]));
      }
    }

  }


  public function composer()
  {
    //TODO
  }


  public function ignorePageThemeGridFrameworkContainer(){
    return isset($this->ignoreGrid)?$this->ignoreGrid:false;
  }

}