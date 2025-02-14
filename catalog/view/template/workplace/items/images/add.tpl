<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_items_images_add_header; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="info-content-block">
        <div class="list">
          <label class="input-text-field">
            <?php echo $workplace_items_images_add_image_label; ?>
            <input id="image_data" type="file" class="input-send"
              title="<?php echo $workplace_items_images_add_image_hint;  ?>">
          </label>
          
          <div class="between">
            
            <a href="<?php echo $cancel_button_href; ?>"><button type="button">
              <?php echo $workplace_items_images_add_cancel_button_text; ?>
            </button></a>
            <button onMouseDown="File_Form('<?php echo  $add_image_button_href; ?>')">
              <?php echo $workplace_items_images_add_add_button_text; ?>
            </button>
          </div>

        </div>
        <span class="error-alert"></span>
      </div>
    </div>

  </div>

</div>
<?php echo $common_footer; ?>