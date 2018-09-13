<?php

namespace Concrete\Package\Tmblocks\Src\FieldTypes;

class BlockFieldTypeColor extends BlockFieldTypeBase {


    public function getFormMarkup($form,$view,$k,$value){
        return $this->getFormMarkupColor($form,$view,$k,$value);
    }
}

