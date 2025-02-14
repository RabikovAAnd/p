<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_units_add_header; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">

      <div class="info-content-block">
        <div class="list">

          <?php if(isset($unit_languages)) {?>
            
            <?php foreach($unit_languages as $unit_language) {?>
              <div class="info-content-block list">
                <h2><?php echo $unit_language['language_label']; ?></h2>
                <label class="input-text-field">
                <?php echo $unit_language['symbol_label']; ?>
                <input id="<?php echo $unit_language['symbol_id']; ?>" type="text" class="input-send"
                  title="<?php echo $unit_language['symbol_hint']; ?>"
                  placeholder="<?php echo $unit_language['symbol_placeholder']; ?>" />
              </label>
            <label class="input-text-field">
              <?php echo $unit_language['name_label']; ?>
              <input id="<?php echo $unit_language['name_id']; ?>" type="text" class="input-send"
                title="<?php echo $unit_language['name_hint']; ?>"
                placeholder="<?php echo $unit_language['name_placeholder']; ?>" />
            </label>
              </div>
              
            <?php } ?>
          <?php } ?>
         
          <label class="checkbox-field">
            <input id="status" type="checkbox" class="input-send"
              title="<?php echo $workplace_units_add_status_hint; ?>" />
            <?php echo $workplace_units_add_status_label; ?>
          </label>
         
          <div class="between">
            <a href="<?php echo $cancel_button_href; ?>">
              <button type="button">
                <?php echo $workplace_units_add_cancel_button_text; ?>
              </button>
            </a>
            <button
              onMouseDown="File_Form('<?php echo $add_button_href; ?>')">
              <?php echo $workplace_units_add_add_button_text; ?>
            </button>
          </div>
        </div>
        <span class="error-alert"></span>
      </div>


    </div>
  </div>

</div>
<?php echo $common_footer; ?>