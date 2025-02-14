<?php echo $common_header; ?>

<div id="content">

  <h1><?php echo $workplace_add_project_header; ?></h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class=" info-content-block">
        <div class="list">
    
            <?php if ( $project_clone === true ){ ?>
              <label class="checkbox-field" title="<?php echo $workplace_add_project_auto_number_checkbox_hint; ?>">
                <input id="auto_designator" type="checkbox" class="input-send"
                  title="<?php echo $workplace_add_project_auto_number_checkbox_hint; ?>" />
                <?php echo $workplace_add_project_auto_number_label; ?>
              </label>
              <label id="designator_label" class="input-text-field">
                <?php echo $workplace_add_project_number_label; ?>
                <input id="designator" type="text" class="input-send"
                  title="<?php echo $workplace_add_project_number_hint; ?>"
                  placeholder="<?php echo $workplace_add_project_number_placeholder; ?>"
                  value="<?php echo $project[ 'data' ][ 'designator' ]; ?>" />
              </label>
              <label class="input-text-field">
                <?php echo $workplace_add_project_name_label; ?>
                <input id="name" type="text" class="input-send" title="<?php echo $workplace_add_project_name_hint; ?>"
                  placeholder="<?php echo $workplace_add_project_name_placeholder; ?>"
                  value="<?php echo $project[ 'data' ][ 'name' ]; ?>"/>
              </label>
              <label class="input-text-field">
                <?php echo $workplace_add_project_description_label; ?>
                <textarea id="description" rows="4" type="text" class="input-send"
                  title="<?php echo $workplace_add_project_description_hint; ?>"
                  placeholder="<?php echo $workplace_add_project_description_placeholder; ?>"
                  ><?php echo $project[ 'data' ][ 'description' ]; ?></textarea>
              </label>
              <label class="checkbox-field" title="<?php echo $workplace_add_project_favorite_checkbox_hint; ?>">
                <input id="favorite" type="checkbox" class="input-send"
                  title="<?php echo $workplace_add_project_favorite_checkbox_hint; ?>" />
                <?php echo $workplace_add_project_favorite_label; ?>
              </label>
              <div class="between">
                <a href="<?php echo $cancel_button_href; ?>">
                <button title="<?php echo $workplace_add_project_cancel_button_hint; ?>">
                  <?php echo $workplace_add_project_cancel_button_text; ?>
                </button>
                </a>
                <button onMouseDown="File_Form('<?php echo $workplace_add_project_button_href; ?>')"
                  title="<?php echo $workplace_add_project_create_button_hint; ?>">
                  <?php echo $workplace_add_project_create_button_text; ?>
                </button>
              </div>
            <?php }else{ ?>
              <label class="checkbox-field" title="<?php echo $workplace_add_project_auto_number_checkbox_hint; ?>">
                <input id="auto_designator" type="checkbox" class="input-send"
                  title="<?php echo $workplace_add_project_auto_number_checkbox_hint; ?>" checked />
                <?php echo $workplace_add_project_auto_number_label; ?>
              </label>
              <label id="designator_label" class="input-text-field">
                <?php echo $workplace_add_project_number_label; ?>
                <input id="designator" type="text" class="input-send unable"
                  title="<?php echo $workplace_add_project_number_hint; ?>"
                  placeholder="<?php echo $workplace_add_project_number_placeholder; ?>" disabled />
              </label>
              <label class="input-text-field">
                <?php echo $workplace_add_project_name_label; ?>
                <input id="name" type="text" class="input-send" title="<?php echo $workplace_add_project_name_hint; ?>"
                  placeholder="<?php echo $workplace_add_project_name_placeholder; ?>" />
              </label>
              <label class="input-text-field">
                <?php echo $workplace_add_project_description_label; ?>
                <textarea id="description" rows="4" type="text" class="input-send"
                  title="<?php echo $workplace_add_project_description_hint; ?>"
                  placeholder="<?php echo $workplace_add_project_description_placeholder; ?>"></textarea>
              </label>
              <label class="checkbox-field" title="<?php echo $workplace_add_project_favorite_checkbox_hint; ?>">
                <input id="favorite" type="checkbox" class="input-send"
                  title="<?php echo $workplace_add_project_favorite_checkbox_hint; ?>" />
                <?php echo $workplace_add_project_favorite_label; ?>
              </label>
              <div class="end">
                <button onMouseDown="File_Form('<?php echo $workplace_add_project_button_href; ?>')"
                  title="<?php echo $workplace_add_project_create_button_hint; ?>">
                  <?php echo $workplace_add_project_create_button_text; ?>
                </button>
              </div>
            <?php }?>
          
        </div>
        <span class="error-alert"></span>
      </div>

    </div>

  </div>

</div>
<?php echo $common_footer; ?>
<script type="text/javascript">

  $('#auto_designator').on('change', function (event) {
    if ($('#auto_designator').is(':checked')) {
      $('#designator').prop('disabled', true);
      $('#designator').addClass('unable');
      $('#designator').val('');
    } else {
      $('#designator').prop('disabled', false);
      $('#designator').removeClass('unable');
    }
  });

</script>