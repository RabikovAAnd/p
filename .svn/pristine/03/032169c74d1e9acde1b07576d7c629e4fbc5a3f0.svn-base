<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_units_edit_header; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">

      <div class="info-content-block">
        <div class="list">

          <?php foreach( $unit_languages as $unit_language ) {?>
          <div class="info-content-block list">
            <h2>
              <?php echo $unit_language['language_label']; ?>
            </h2>
            <label class="input-text-field">
              <?php echo $unit_language['symbol_label']; ?>
              <input id="<?php echo $unit_language['symbol_id']; ?>" type="text" class="input-send"
                title="<?php echo $unit_language['symbol_hint']; ?>"
                placeholder="<?php echo $unit_language['symbol_placeholder']; ?>"
                value="<?php echo $unit_language[ 'symbol_value' ]; ?>" />
            </label>
            <label class="input-text-field">
              <?php echo $unit_language[ 'name_label' ]; ?>
              <input id="name_<?php echo $unit_language[ 'code' ]; ?>" type="text" class="input-send"
                title="<?php echo $unit_language[ 'name_hint' ]; ?>"
                placeholder="<?php echo $unit_language[ 'name_placeholder' ]; ?>"
                value="<?php echo $unit_language[ 'name_value' ]; ?>" />
            </label>
          </div>

          <?php } ?>

          <label class="input-text-field">
            <?php echo $workplace_units_edit_status_label; ?>
            <select id="status" class="input-send" title="<?php echo $workplace_units_groups_edit_status_hint; ?>"
              required>
              <?php foreach ( $status_list as $status ) { ?>
              <?php if ( $status != $unit_group[ 'status' ] ) { ?>
              <option value="<?php echo $status; ?>">
                <?php echo $status; ?>
              </option>
              <?php } else { ?>
              <option value="<?php echo $status; ?>" selected="selected">
                <?php echo $status; ?>
              </option>
              <?php } ?>
              <?php } ?>
            </select>
          </label>
          
          <div class="between">
            <a href="<?php echo $cancel_button_href; ?>">
              <button type="button">
                <?php echo $workplace_units_edit_cancel_button_text; ?>
              </button>
            </a>
            <button onMouseDown="File_Form( '<?php echo $edit_button_href; ?>' )">
              <?php echo $workplace_units_edit_edit_button_text; ?>
            </button>
          </div>
        </div>
        <span class="error-alert"></span>
      </div>

    </div>
  </div>

</div>
<?php echo $common_footer; ?>