<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_add_group_header; ?>
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
                placeholder="<?php echo $groups_language['placeholder']; ?>" />
            </label>
            <?php } ?>
          <?php } ?>
          <label class="checkbox-field">
            <input id="status" type="checkbox" class="input-send"
              title="<?php echo $workplace_add_group_status_hint; ?>" />
            <?php echo $workplace_add_group_status_label; ?>
          </label>
         
          <div class="between">
            <a href="<?php echo $cancel_button_href; ?>">
              <button type="button">
                <?php echo $workplace_add_group_cancel_button_text; ?>
              </button>
            </a>
            <button
              onMouseDown="File_Form('<?php echo $add_button_href; ?>')">
              <?php echo $workplace_add_group_add_group_button_text; ?>
            </button>
          </div>
        </div>
        <span class="error-alert"></span>
      </div>


    </div>
  </div>

</div>
<?php echo $common_footer; ?>