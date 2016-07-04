<?php defined("C5_EXECUTE") or die("Access Denied.");

if (empty($tmTabs)): ?>

  <?php foreach ($tmFields AS $field => $ft):
    require(dirname(__FILE__) . "/field.php");
  endforeach; ?>

<?php else:

  $tabs = array();
  $init = true;
  foreach ($tmTabs AS $tabid => $tab):
    $tabs[] = array($tabid, $tab["title"], $init);
    $init = false;
  endforeach;

  echo Core::make('helper/concrete/ui')->tabs($tabs);

  foreach ($tmTabs AS $tabid => $tab): ?>
    <div id="ccm-tab-content-<?php echo $tabid; ?>" class="ccm-tab-content">
      <?php foreach ($tab['fields'] AS $field):
          require(dirname(__FILE__) . "/field.php");
      endforeach; ?>
    </div>
  <?php endforeach; ?>

<?php endif; ?>
<div id="tm-form-dialog"></div>