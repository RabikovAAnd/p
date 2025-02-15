<?php echo $common_header; ?>

<div id="content">

  <h1><?php echo $workplace_items_subitems_edit_header . ' ' . $subitem['item_info']['mpn']; ?></h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">

      <div class="info-content-block">
        <div class="list">
          <label class="input-text-field">
            <?php echo $workplace_items_subitems_edit_designator_label; ?>
            <input id="designator" type="text" class="input-send"
              title="<?php echo $workplace_items_subitems_edit_designator_hint;  ?>"
              placeholder="<?php echo $workplace_items_subitems_edit_designator_placeholder; ?>"
              value="<?php echo $subitem['subitem_info']['designator']; ?>">
          </label>
          <label class="input-text-field">
            <?php echo $workplace_items_subitems_edit_quantity_label; ?>
            <input id="quantity" type="text" class="input-send"
              title="<?php echo $workplace_items_subitems_edit_quantity_hint;  ?>"
              placeholder="<?php echo $workplace_items_subitems_edit_quantity_placeholder; ?>"
              value="<?php echo $subitem['subitem_info']['quantity']; ?>">
          </label>
          <div class="between">
            <a href="<?php echo $cancel_button_href; ?>"><button type="button">
                <?php echo $workplace_items_subitems_edit_cancel_button_text; ?>
              </button></a>
            <button
              onMouseDown="File_Form('<?php echo $save_button_href; ?>',[['subitem_index_guid','<?php echo $subitem_index_guid; ?>']])">
              <?php echo $workplace_items_subitems_edit_edit_button_text; ?>
            </button>
          </div>
        </div>
        <span class="error-alert"></span>
      </div>

    </div>
  </div>
</div>

<?php echo $common_footer; ?>

