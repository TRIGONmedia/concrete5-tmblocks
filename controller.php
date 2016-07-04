<?php

namespace Concrete\Package\Tmblocks;
use Package;
use BlockType;
use SinglePage;
use PageTheme;
use BlockTypeSet;
use CollectionAttributeKey;
use Concrete\Core\Attribute\Type as AttributeType;
use Config;
use Core;
use AssetList;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package
{

  protected $pkgHandle = 'tmblocks';
  protected $appVersionRequired = '5.7.5';
  protected $pkgVersion = '1.0.10';


  public function getPackageDescription()
  {
    return t("Package containing TRIGONmedia blocks.");
  }

  public function getPackageName()
  {
    return t("TRIGONmedia Blocks");
  }

  public function install()
  {
    $pkg = parent::install();


    BlockType::installBlockTypeFromPackage('tm_headline', $pkg);
    BlockType::installBlockTypeFromPackage('tm_header_image', $pkg);
    BlockType::installBlockTypeFromPackage('tm_image', $pkg);
    BlockType::installBlockTypeFromPackage('tm_text', $pkg);
    BlockType::installBlockTypeFromPackage('tm_link', $pkg);
    BlockType::installBlockTypeFromPackage('tm_linklist', $pkg);
    BlockType::installBlockTypeFromPackage('tm_cite', $pkg);
    BlockType::installBlockTypeFromPackage('tm_wideillu', $pkg);
    BlockType::installBlockTypeFromPackage('tm_next_previous', $pkg);

  }

  public function on_start()
  {

    $al = AssetList::getInstance();
    $al->register('javascript', 'repeatable', "../".$this->getRelativePath().'/js/backend/repeatable.js');
    $al->register('css', 'repeatable', "../".$this->getRelativePath().'/css/backend/repeatable.css');
    $al->registerGroup('tm/repeatable', array(
      array('javascript', 'repeatable'),
      array('css', 'repeatable'),
    ));

  }

  public function upgrade()
  {

    PageTheme::add('tmblocks', $pkg);

    parent::upgrade();

    if (!BlockTypeSet::getByHandle('tm2016')) {
      BlockTypeSet::add('tm2016', "TM 2016", $pkg);
    }

    $bt = BlockType::getByHandle('tm_headline');
    if (!is_object($bt)) {
      BlockType::installBlockTypeFromPackage('tm_headline', $this);
    }
    $bt = BlockType::getByHandle('tm_header_image');
    if (!is_object($bt)) {
      BlockType::installBlockTypeFromPackage('tm_header_image', $this);
    }
    $bt = BlockType::getByHandle('tm_image');
    if (!is_object($bt)) {
      BlockType::installBlockTypeFromPackage('tm_image', $this);
    }
    $bt = BlockType::getByHandle('tm_link');
    if (!is_object($bt)) {
      BlockType::installBlockTypeFromPackage('tm_link', $this);
    }
    $bt = BlockType::getByHandle('tm_linklist');
    if (!is_object($bt)) {
      BlockType::installBlockTypeFromPackage('tm_linklist', $this);
    }
    $bt = BlockType::getByHandle('tm_cite');
    if (!is_object($bt)) {
      BlockType::installBlockTypeFromPackage('tm_cite', $this);
    }
    $bt = BlockType::getByHandle('tm_wideillu');
    if (!is_object($bt)) {
      BlockType::installBlockTypeFromPackage('tm_wideillu', $this);
    }
    $bt = BlockType::getByHandle('tm_next_previous');
    if (!is_object($bt)) {
      BlockType::installBlockTypeFromPackage('tm_next_previous', $this);
    }
  }

}

?>
