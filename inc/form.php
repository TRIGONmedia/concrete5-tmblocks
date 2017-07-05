<?php defined("C5_EXECUTE") or die("Access Denied.");

if (empty($tmTabs)): ?>

  <?php foreach ($tmFields AS $field => $ft): ?>
    <?php $ft = $tmFields[$field];
    if ($tmFields[$field] instanceof \Concrete\Package\Tmblocks\Src\FieldTypes\BlockFieldTypeRepeatable):?>
        <div id="ccm-repeatable-<?php echo $field; ?>">
            <button type="button"
                    class="btn btn-success ccm-add-<?php echo $field; ?>-entry"><?php echo t($ft->getAddButtonName()); ?></button>
            <div class="ccm-<?php echo $field; ?>-entries"
                 data-init-max-sort="<?php echo sizeOf(${$field}); ?>">
              <?php $i = 0; ?>
              <?php if (isset(${$field})): ?>
                <?php foreach (${$field} AS $childFieldValue): ?>
                      <div class="repeatable-block">
                        <?php $i++; ?>
                          <button type="button" class="btn btn-danger repeatable-remove"
                                  id="ccm-remove-<?php echo $field; ?>-<?php echo $i; ?>"><?php echo t('Remove'); ?></button>
                          <i class="fa fa-arrows repeatable-drag"></i>
                        <?php foreach ($ft->getChildTypes() AS $childField => $childFt): ?>
                          <?php echo $childFt->getFormMarkupForRepeatable($form, $view, $childField, $childFieldValue[$childField], $field, $i); ?>
                        <?php endforeach; ?>
                      </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
        </div>
        <template type="text/template" id="template-<?php echo $field; ?>">
            <div class="repeatable-block">
                <button type="button" class="btn btn-danger repeatable-remove"
                        id="ccm-remove-<?php echo $field; ?>-<%= i %>"><?php echo t('Remove'); ?></button>
                <i class="fa fa-arrows repeatable-drag"></i>
              <?php foreach ($ft->getChildTypes() AS $childField => $childFt): ?>
                <?php echo $childFt->getFormMarkupForTemplate($form, $view, $childField, null); ?>
              <?php endforeach; ?>
            </div>
        </template>
        <script type="text/javascript">
          $("#ccm-repeatable-<?php echo $field; ?>").tm_repeatable({
            'field': "<?php echo $field; ?>"
          });

        </script>
    <?php else: ?>
        <div class="form-group">
          <?php echo $ft->getFormMarkup($form, $view, $field, ${$field}); ?>
        </div>
    <?php endif; ?>
  <?php endforeach; ?>

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
        <?php foreach ($tab['fields'] AS $field): ?>
          <?php $ft = $tmFields[$field];
          if ($tmFields[$field] instanceof \Concrete\Package\Tmblocks\Src\FieldTypes\BlockFieldTypeRepeatable):?>
              <div id="ccm-repeatable-<?php echo $field; ?>">
                  <button type="button"
                          class="btn btn-success ccm-add-<?php echo $field; ?>-entry"><?php echo t($ft->getAddButtonName()); ?></button>
                  <div class="ccm-<?php echo $field; ?>-entries"
                       data-init-max-sort="<?php echo sizeOf(${$field}); ?>">
                    <?php $i = 0; ?>
                    <?php if (isset(${$field})): ?>
                      <?php foreach (${$field} AS $childFieldValue): ?>
                            <div class="repeatable-block">
                              <?php $i++; ?>
                                <button type="button" class="btn btn-danger repeatable-remove"
                                        id="ccm-remove-<?php echo $field; ?>-<?php echo $i; ?>"><?php echo t('Remove'); ?></button>
                                <i class="fa fa-arrows repeatable-drag"></i>
                              <?php foreach ($ft->getChildTypes() AS $childField => $childFt): ?>
                                <?php echo $childFt->getFormMarkupForRepeatable($form, $view, $childField, $childFieldValue[$childField], $field, $i); ?>
                              <?php endforeach; ?>
                            </div>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
              </div>
              <template type="text/template" id="template-<?php echo $field; ?>">
                  <div class="repeatable-block">
                      <button type="button" class="btn btn-danger repeatable-remove"
                              id="ccm-remove-<?php echo $field; ?>-<%= i %>"><?php echo t('Remove'); ?></button>
                      <i class="fa fa-arrows repeatable-drag"></i>
                    <?php foreach ($ft->getChildTypes() AS $childField => $childFt): ?>
                      <?php echo $childFt->getFormMarkupForTemplate($form, $view, $childField, null); ?>
                    <?php endforeach; ?>
                  </div>
              </template>
              <script type="text/javascript">
                $("#ccm-repeatable-<?php echo $field; ?>").tm_repeatable({
                  'field': "<?php echo $field; ?>"
                });

              </script>
          <?php else: ?>
              <div class="form-group">
                <?php echo $ft->getFormMarkup($form, $view, $field, ${$field}); ?>
              </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
  <?php endforeach; ?>

<?php endif; ?>
<div id="tm-form-dialog"></div>
