<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_categories_move_header . " ". $current_category['name']; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      
      <div class="info-content-block">
        <div class="list">

          <label class="input-text-field search-selector">
            <?php echo $workplace_categories_move_category_label; ?>
           
            <select id="parent_guid" class="input-send" size="10">
              <?php foreach ($categories as $category) { ?>
                <?php if (in_array($category[ 'guid' ],$forbidden_category ) ===false ){ ?>
              <option id="<?php echo $category[ 'guid' ]; ?>" value="<?php echo $category[ 'guid' ]; ?>"><?php echo $category[ 'name' ]; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </label>

          <div class="between">
            <a href="<?php echo $cancel_button_href; ?>">
              <button type="button">
                <?php echo $workplace_categories_move_cancel_button_text; ?>
              </button>
            </a>
            <button
              onMouseDown="File_Form('<?php echo $move_button_href; ?>')">
              <?php echo $workplace_categories_move_move_button_text; ?>
            </button>
          </div>
        </div>
        <span class="error-alert"></span>
      </div>


    </div>
  </div>

</div>
<?php echo $common_footer; ?>
