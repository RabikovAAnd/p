<?php echo $common_header; ?>

<div id="content">
  <h1><?php echo $workplace_edit_property_header; ?></h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="info-content-block list">


        <label class="input-text-field">
          <?php echo $workplace_edit_property_property_value_label; ?>
          <input type="property_value" id="property_value" name="property_value" class="input-send"
            title="<?php echo  $workplace_edit_property_property_value_hint; ?>"
            placeholder="<?php echo  $workplace_edit_property_property_value_placeholder; ?>"
            value="<?php echo  $property_value; ?>" required />
        </label>
        <label class="input-text-field">
          <?php echo $workplace_properties_edit_unit_label; ?>
          <select id="unit_guid" class="input-send" title="<?php echo  $workplace_add_item_unit_hint;  ?>"
            required>
            <option value="placeholder">
              <?php echo $workplace_properties_edit_unit_placeholder; ?>
            </option>
            <?php if ( isset( $property_unit['guid'] ) === true ) { ?>
            <option value="<?php echo $property_unit['guid']; ?>" selected>
              <?php echo $property_unit[ 'symbol' ]; ?> - <?php echo $property_unit[ 'name' ]; ?>
            </option>
            <?php foreach ( $units as $unit ) { ?>
            <?php if ( $unit[ 'guid' ] !== $property_unit['guid'] ) { ?>
            <option value="<?php echo $unit[ 'guid' ]; ?>">
              <?php echo $unit[ 'symbol' ]; ?> - <?php echo $unit[ 'name' ]; ?>
            </option>
            <?php } ?>
            <?php } ?>
            <?php } else{ ?>
            <?php foreach ( $units as $unit ) { ?>
            <option value="<?php echo $unit[ 'guid' ]; ?>">
              <?php echo $unit[ 'symbol' ]; ?> - <?php echo $unit[ 'name' ]; ?>
            </option>
            <?php } ?>
            <?php } ?>
          </select>
        </label>
        <div class="between">
          <a href="<?php echo $cancel_button_href; ?>"><button type="button">
              <?php echo $workplace_edit_property_cancel_button_text; ?>
            </button></a>

          <button title="<?php echo  $workplace_add_customer_register_button_hint; ?>"
            onMouseDown="File_Form('<?php echo $workplace_edit_property_button_href; ?>')">
            <?php echo $workplace_edit_property_edit_property_button_text; ?>
          </button>
        </div>

        <span class="error-alert"></span>
      </div>
    </div>
  </div>

</div>
<?php echo $common_footer; ?>