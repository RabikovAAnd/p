<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_properties_groups_clone_header; ?>
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
              value="<?php echo $groups_language['name']['name']; ?>" />

          </label>
          <?php } ?>
          <?php } ?>
          <label class="checkbox-field">
            <input id="status" type="checkbox" class="input-send"
              title="<?php echo $workplace_properties_groups_clone_status_hint; ?>" />
            <?php echo $workplace_properties_groups_clone_status_label; ?>
          </label>

          <?php if(isset($groups_properties)) {?>
          <label class="input-text-field">
            <?php echo $workplace_properties_groups_clone_groups_properties_label; ?>
            <div id="groups_properties" class="checkbox-select input-send">
              <?php foreach($groups_properties as $groups_property) {?>
              <label class="checkbox-field">
                <input id="status" value="<?php echo $groups_property['guid']; ?>" type="checkbox"
                  title="<?php echo $workplace_properties_groups_clone_status_hint; ?>" />
                <?php echo $groups_property['name']; ?>
              </label>
              <?php } ?>
            </div>
          </label>

          <?php } ?>

          <div class="between">
            <a href="<?php echo $cancel_button_href; ?>">
              <button type="button">
                <?php echo $workplace_properties_groups_clone_cancel_button_text; ?>
              </button>
            </a>
            <button type="button" onMouseDown="File_Form('<?php echo $clone_button_href; ?>')">
              <?php echo $workplace_properties_groups_clone_clone_button_text; ?>
            </button>
          </div>
        </div>
        <span class="error-alert"></span>
      </div>


    </div>
  </div>

</div>
<?php echo $common_footer; ?>