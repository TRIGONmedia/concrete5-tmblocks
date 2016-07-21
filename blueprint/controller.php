<?php
namespace Concrete\Package\MyOwnPackage\Block\MyOwnBlock;

defined("C5_EXECUTE") or die("Access Denied.");

use Core;
use Loader;
use \File;
use Page;
use URL;
use Concrete\Package\Tmblocks\Src\TmBlockController;

class Controller extends TmBlockController
{

    public $helpers = array(
      0 => 'form',
    );

    protected $btTable = 'myOwnBlock';
    protected $btInterfaceHeight = 400;

    public function getBlockTypeDescription()
    {
        return t("");
    }

    public function getBlockTypeName()
    {
        return t("My Own block");
    }

    function __construct($obj = null){

        parent::__construct($obj);

        //Configuration here => see README.md
    }

}