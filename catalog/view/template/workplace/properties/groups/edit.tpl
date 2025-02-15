<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_edit_group_header; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">

      <div class="info-content-block">
        <div class="list">
          <?php if(isset($groups_languages)) {?>
            
            <?php foreach($groups_languages as $groups_language) {?>
            <label class="input-text-field">
              <?php echo $groups_language['label']; ?>
              <input id="<?php echo $groups_language['id']; ?>" type="text" class="input-send"
                title="<?php echo $groups_language['hint']; ?>"
                placeholder="<?php echo $groups_language['placeholder']; ?>" 
                value="<?php echo $groups_description[$groups_language['code']]['name']; ?>"/>
            </label>
            <?php } ?>
          <?php } ?>
          
          <label class="input-text-field">
            <?php echo $workplace_edit_group_status_label; ?>
           
            <select id="status"  class="input-send"
              title="<?php echo $workplace_edit_group_status_hint; ?>" required>
              <?php if (isset($group[ 'status' ]) === true) {?>
              <option value="<?php echo $group[ 'status' ]; ?>" selected="selected">
                <?php echo $group[ 'status' ]; ?>
              </option>
              <?php }  ?>
              <?php foreach ($status_list as $status) { ?>
              <?php if ($status != $group[ 'status' ]) { ?>
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
                <?php echo $workplace_edit_group_cancel_button_text; ?>
              </button>
            </a>
            <button
              onMouseDown="File_Form('<?php echo $edit_button_href; ?>')">
              <?php echo $workplace_edit_group_save_button_text; ?>
            </button>
          </div>
        </div>
        <span class="error-alert"></span>
      </div>


    </div>
  </div>

</div>
<?php echo $common_footer; ?>