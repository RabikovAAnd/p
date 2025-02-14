<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_documents_types_edit_header . " ". $type_descriptions[$current_language]['name']; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">

      <div class="info-content-block">
        <div class="list">
          <?php if(isset($type_languages)) {?>
            
            <?php foreach($type_languages as $type_language) {?>
            <label class="input-text-field">
              <?php echo $type_language['label']; ?>
              <input id="<?php echo $type_language['id']; ?>" type="text" class="input-send"
                title="<?php echo $type_language['hint']; ?>"
                placeholder="<?php echo $type_language['placeholder']; ?>" 
                value="<?php echo $type_descriptions[$type_language['code']]['name']; ?>"/>
            </label>
            <?php } ?>
          <?php } ?>
         
          <label class="input-text-field">
            <?php echo $workplace_documents_types_edit_status_label; ?>
            <select id="status"  class="input-send"
              title="<?php echo $workplace_documents_types_edit_status_hint; ?>" required>
              <?php if (isset($type_info[ 'status' ]) === true) {?>
              <option value="<?php echo $type_info[ 'status' ]; ?>" selected="selected">
                <?php echo $type_info[ 'status' ]; ?>
              </option>
              <?php }  ?>
              <?php foreach ($status_list as $status) { ?>
              <?php if ($status != $type_info[ 'status' ]) { ?>
              <option value="<?php echo $status; ?>">
                <?php echo $status; ?>
              </option>
              <?php } ?>
              <?php } ?>
            </select>
          </label>

          <div class="between">
            <a href="<?php echo $cancel_button_href; ?>">
              <button type="button">
                <?php echo $workplace_documents_types_edit_cancel_button_text; ?>
              </button>
            </a>
            <button
              onMouseDown="File_Form('<?php echo $edit_button_href; ?>')">
              <?php echo $workplace_documents_types_edit_edit_button_text; ?>
            </button>
          </div>
        </div>
        <span class="error-alert"></span>
      </div>


    </div>
  </div>

</div>
<?php echo $common_footer; ?>