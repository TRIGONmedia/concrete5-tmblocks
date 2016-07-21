<?php  defined("C5_EXECUTE") or die("Access Denied."); ?>

<?php  if (trim($layer) != ""): ?>

<?php  if (isset($headline) && trim($headline) != ""): ?>

      <?php
        $classes = array($cssClass,$align);
        ?>

    <<?php echo $layer; ?> class="<?php echo implode(" ",$classes); ?>"><?php  echo h($headline); ?></<?php echo $layer; ?>>

    <?php  endif; ?>
<?php  endif; ?>