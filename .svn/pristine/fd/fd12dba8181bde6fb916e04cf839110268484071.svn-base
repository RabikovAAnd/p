<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_processes_groups_edit_header; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">

      <div class="info-content-block">
        <div class="list">
            
          <?php foreach( $group_languages as $group_language ) {?>
          <label class="input-text-field">
            <?php echo $group_language[ 'label' ]; ?>
            <input id="group_name_<?php echo $group_language[ 'code' ]; ?>" type="text" class="input-send"
              title="<?php echo $group_language[ 'hint' ]; ?>"
              placeholder="<?php echo $group_language[ 'placeholder' ]; ?>" 
              value="<?php echo $group_language[ 'name' ]; ?>"/>
          </label>
          <?php } ?>
         
          <label class="input-text-field">
            <?php echo $workplace_processes_groups_edit_status_label; ?>
            <select id="status"  class="input-send"
              title="<?php echo $workplace_processes_groups_edit_status_hint; ?>" required>              
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
                <?php echo $workplace_processes_groups_edit_cancel_button_text; ?>
              </button>
            </a>
            <button
              onMouseDown="File_Form( '<?php echo $edit_button_href; ?>' )">
              <?php echo $workplace_processes_groups_edit_save_button_text; ?>
            </button>
          </div>
        </div>
        <span class="error-alert"></span>
      </div>

    </div>
  </div>

</div>
<?php echo $common_footer; ?>