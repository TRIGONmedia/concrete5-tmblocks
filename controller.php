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
  protected $pkgVersion = '0.9.11';


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
  }

  public function on_start()
  {

    $al = AssetList::getInstance();
    $al->register('javascript', 'repeatable', "../../".$this->getRelativePath().'/js/backend/repeatable.js');
    $al->register('css', 'repeatable', "../../".$this->getRelativePath().'/css/backend/repeatable.css');
    $al->registerGroup('tm/repeatable', array(
      array('javascript', 'repeatable'),
      array('css', 'repeatable'),
    ));

  }

  public function upgrade()
  {
    parent::upgrade();
  }

}

?>
