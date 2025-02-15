<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_properties_add_header; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">

      <div class="info-content-block">
        <div class="list">
          <?php if( isset( $property_languages ) ) {?>
            
            <?php foreach( $property_languages as $property_language ) {?>
            <label class="input-text-field">
              <?php echo $property_language[ 'label' ]; ?>
              <input id="<?php echo $property_language[ 'id' ]; ?>" type="text" class="input-send"
                title="<?php echo $property_language[ 'hint' ]; ?>"
                placeholder="<?php echo $property_language[ 'placeholder' ]; ?>" />
            </label>
            <?php } ?>
          <?php } ?>
         
          <label class="input-text-field">
            <span><?php echo $workplace_properties_add_unit_label; ?></span>
            <select id="unit_guid" autocomplete="off" class="input-send"
              title="<?php echo $workplace_properties_add_unit_hint; ?>" />
            <option value=""><?php echo $workplace_properties_add_unit_placeholder; ?></option>
            <?php foreach ( $units as $unit ) { ?>
            <option value="<?php echo $unit[ 'guid' ]; ?>"><?php echo $unit[ 'name' ]; ?></option>
            <?php } ?>
            </select>
          </label>
          <label class="checkbox-field">
            <input id="status" type="checkbox" class="input-send"
              title="<?php echo $workplace_properties_add_status_hint; ?>" />
            <?php echo $workplace_properties_add_status_label; ?>
          </label>
          <div class="between">
            <a href="<?php echo $cancel_button_href; ?>">
              <button type="button"><?php echo $workplace_properties_add_cancel_button_text; ?></button>
            </a>
            <button
              onMouseDown="File_Form('<?php echo $add_button_href; ?>')">
              <?php echo $workplace_properties_add_add_property_button_text; ?>
            </button>
          </div>
        </div>
        <span class="error-alert"></span>
      </div>

    </div>
  </div>

</div>
<?php echo $common_footer; ?>