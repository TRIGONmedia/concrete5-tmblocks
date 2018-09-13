<?php

namespace Concrete\Package\Tmblocks\Src\FieldTypes;

class BlockFieldTypeLabel extends BlockFieldTypeBase {

    public function getFormMarkup($form,$view,$k,$value){
        return $this->getFormMarkupLabel($form,$view,$k,$value);
    }

}