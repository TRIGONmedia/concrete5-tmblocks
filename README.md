# concrete5-tmblocks

This package helps you creating custom blocks with little code and maintainability.

## Installation

1. Go to your concrete5 root directory (using a cli interface)
2. If you not yet have installed composer do it now: `curl -sS https://getcomposer.org/installer | php`
3. Add the following to your composer.json

  ```javascript
  {
    "require": {
        "farion/concrete5-tmblocks": "@dev"
    }
  }
  ```
4. run `composer install` (or `php composer.phar install`)

## How to use tmblocks?

### Copy the blueprint

Copy the content of `blueprint` to the folder of your new block e.g. `packages/MyOwnPackage/blocks/MyOwnBlock`

### Change form.php

Change the path in `form.php` to include the `form.php` from tmblocks. e.g.
`$this->inc("../../../TmBlocks/inc/form.php");`

### Use a nice icon

Replace `icon.png` with something matching to your new block.

### Configure controller.php

At first fill in the names of your new block: namespace, description and type name.
  
#### Configure fields

In `construct()` add a new field type object to the tmFields array like this:

```
$this->tmFields["myText"] = new BlockFieldTypeString();
```

Don't forget to include the type with `use` at the top of the file.

```
use Concrete\Package\Tmblocks\Src\FieldTypes\BlockFieldTypeString;
```

Types can be configured. A type has at least to configuration options:

```
$this->tmFields["myString"]->setName("My Text"); // must be set
$this->tmFields["myString"]->setRequired(true); // defaults to false
```

#### Field types

##### BlockFieldTypeBoolean

Lets the user define a boolean which can be chosen by a checkbox. Possible values are 0 or 1.

##### BlockFieldTypeImage

Lets the user chose an image from the file manager.

##### BlockFieldTypeNumber

Lets the user define a number.

Possible options:

```
$this->tmFields["myNumber"]->setMin(0); // defaults to unlimited
$this->tmFields["myNumber"]->setMax(1000); // defaults to unlimited
```

##### BlockFieldTypePage

Lets the user chose a page.

##### BlockFieldTypeSelect

Lets the user chose an option.

Options can be set as array:

```
$this->tmFields["mySelect"]->setChoices(array(
      'key' => 'value',
       ...
));
```

##### BlockFieldTypeString

Lets the user define a string.

##### BlockFieldTypeWYSIWYG

Lets the user define a text with the wysiwyg editor.

##### BlockFieldTypeRepeatable

Allows the user to repeat a bundle of other field types.
Use cases are link lists or image galleries.

Basically you must set an array of other types. Those types will be one block that can be repeated.
So assume the case of a link list where each link contains of a page, a text and an anchor.

```
$link = new BlockFieldTypePage();
$link->setName("My Linked Page");

$linktext = new BlockFieldTypeString();
$linktext->setName("My Link Text");

$anchor = new BlockFieldTypeString();
$anchor->setName("My Anchor");

$this->tmFields['myLinks'] = new BlockFieldTypeRepeatable();
$this->tmFields['myLinks']->setAddButtonName("Add Link");
$this->tmFields['myLinks']->setChildTypes(array(
  "link" => $link,
  "linktext" => $linktext,
  "anchor" => $anchor
));
```

#### Configure Tabs

If you have a lot of fields it make sense to spread them over tabs.
Therefore you can use the tmTabs array.

```
$this->tmTabs = array(
  'keyOfTheFirstTab' => array(
    'title' => t('Name of the first ab'),
    'fields' => array('keyOfTheFirstFieldInTheFirstTab','keyOfTheSecondFieldInTheFirstTab',...)
  ),
  'keyOfTheSecondTab' => array(
    'title' => t('Name of the second tab'),
    'fields' => array('keyOfTheFirstFieldInTheSecondTab','keyOfTheSecondFieldInTheSecondTab',...)
  )
);
```

### db.xml

Matching to the fields defined in the controller you must change your db.xml

For each field type a matching field must exist in the database of course.
The name must match to the array key of `tmFields`.

Also do not forget to change the name of the table to match your block name e.g. `myOwnBlock`

##### BlockFieldTypeBoolean

```
<field name="myBoolean" type="I">
  <default value="0"/>
  <unsigned/>
</field>
```

##### BlockFieldTypeImage

```
<field name="myImage" type="I">
  <default value="0"/>
  <unsigned/>
</field>
```

##### BlockFieldTypeNumber

Depends on the number format. For int it is.

```
<field name="myNumber" type="I"></field>

```

##### BlockFieldTypePage

```
<field name="myPage" type="I">
  <default value="0"/>
  <unsigned/>
</field>
```

##### BlockFieldTypeSelect

Depends on the choices, but usually this is a good idea:

```
<field name="mySelect" type="C" size="255"></field>
```

##### BlockFieldTypeString

```
<field name="myString" type="C" size="255"></field>
```

##### BlockFieldTypeWYSIWYG

```
<field name="myWYSIWYG" type="X2"></field>
```

##### BlockFieldTypeRepeatable

For repeatables you need a new table and no new field in the main table.

```
<table name="myOwnBlockMyLinks">
  <field name="iID" type="I">
    <key/>
    <unsigned/>
    <autoincrement/>
  </field>
  <!-- Fill in the child fields as you would do for the main table -->
</table>
```

The name of the relational table is the name of the main table + the array key of the repeatable field with the first character uppercase.

