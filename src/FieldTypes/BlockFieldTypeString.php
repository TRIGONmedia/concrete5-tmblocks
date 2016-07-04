<?php

namespace Concrete\Package\Tmblocks\Src\FieldTypes;

class BlockFieldTypeString extends BlockFieldTypeBase {


  public function getSearchableContent($value)
  {
    return $value;
  }
}

