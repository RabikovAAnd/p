<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_categories_edit_header . " ". $category['name']; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">

      <div class="info-content-block">
        <div class="list">
          <?php if(isset($category_languages)) {?>
            
            <?php foreach($category_languages as $category_language) {?>
            <label class="input-text-field">
              <?php echo $category_language['label']; ?>
              <input id="<?php echo $category_language['id']; ?>" type="text" class="input-send"
                title="<?php echo $category_language['hint']; ?>"
                placeholder="<?php echo $category_language['placeholder']; ?>" 
                value="<?php echo $categories_description[$category_language['code']]['name']; ?>"/>
            </label>
            <?php } ?>
          <?php } ?>
         
          <label class="input-text-field">
            <?php echo $workplace_categories_edit_status_label; ?>
            <select id="status"  class="input-send"
              title="<?php echo $workplace_categories_edit_status_hint; ?>" required>
              <?php if (isset($category[ 'status' ]) === true) {?>
              <option value="<?php echo $category[ 'status' ]; ?>" selected="selected">
                <?php echo $category[ 'status' ]; ?>
              </option>
              <?php }  ?>
              <?php foreach ($status_list as $status) { ?>
              <?php if ($status != $category[ 'status' ]) { ?>
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
                <?php echo $workplace_categories_edit_cancel_button_text; ?>
              </button>
            </a>
            <button
              onMouseDown="File_Form('<?php echo $edit_button_href; ?>')">
              <?php echo $workplace_categories_edit_edit_button_text; ?>
            </button>
          </div>
        </div>
        <span class="error-alert"></span>
      </div>


    </div>
  </div>

</div>
<?php echo $common_footer; ?>