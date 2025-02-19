<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_properties_edit_header; ?>
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
                placeholder="<?php echo $property_language[ 'placeholder' ]; ?>" 
                value="<?php echo $properties_description[ $property_language[ 'code' ] ][ 'name' ]; ?>"/>
            </label>
            <?php } ?>
          <?php } ?>
         
          <label class="input-text-field">
            <?php echo $workplace_properties_edit_status_label; ?>
            <select id="status"  class="input-send"
              title="<?php echo $workplace_properties_edit_status_hint; ?>" required>
              <?php if ( isset( $property[ 'status' ] ) === true) {?>
              <option value="<?php echo $property[ 'status' ]; ?>" selected="selected">
                <?php echo $property[ 'status' ]; ?>
              </option>
              <?php }  ?>
              <?php foreach ( $status_list as $status ) { ?>
              <?php if ( $status != $property[ 'status' ] ) { ?>
              <option value="<?php echo $status; ?>">
                <?php echo $status; ?>
              </option>
              <?php } ?>
              <?php } ?>
            </select>
          </label>

          <label class="input-text-field">
            <?php echo $workplace_properties_edit_unit_label; ?>
            <select id="unit_guid" class="input-send" title="<?php echo  $workplace_add_item_unit_hint;  ?>"
              required>
              <option value="placeholder">
                <?php echo $workplace_properties_edit_unit_placeholder; ?>
              </option>
              <?php if ( isset( $property[ 'units_guid' ] ) === true ) { ?>
              <option value="<?php echo $property[ 'units_guid' ]; ?>" selected>
                <?php echo $property[ 'unit' ][ 'data' ][ 'name' ]; ?>
              </option>
              <?php foreach ( $units as $unit ) { ?>
              <?php if ( $unit[ 'guid' ] !== $property[ 'units_guid' ] ) { ?>
              <option value="<?php echo $unit[ 'guid' ]; ?>">
                <?php echo $unit[ 'name' ]; ?>
              </option>
              <?php } ?>
              <?php } ?>
              <?php } else{ ?>
              <?php foreach ( $units as $unit ) { ?>
              <option value="<?php echo $unit[ 'guid' ]; ?>">
                <?php echo $unit[ 'name' ]; ?>
              </option>
              <?php } ?>
              <?php } ?>
            </select>
          </label>
          
          <div class="between">
            <a href="<?php echo $cancel_button_href; ?>">
              <button type="button">
                <?php echo $workplace_properties_edit_cancel_button_text; ?>
              </button>
            </a>
            <button
              onMouseDown="File_Form('<?php echo $edit_button_href; ?>')">
              <?php echo $workplace_properties_edit_edit_button_text; ?>
            </button>
          </div>
        </div>
        <span class="error-alert"></span>
      </div>


    </div>
  </div>

</div>
<?php echo $common_footer; ?>