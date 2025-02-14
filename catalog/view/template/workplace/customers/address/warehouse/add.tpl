<?php echo $common_header; ?>
<div id="content">
  <h1 class="header-list__edit">
    <?php echo $workplace_customers_address_warehouse_add_header . ' ' . $address['address_text']; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>

    <div class="main-area">
      <div class="info-content-block">
        <div class="list">

          <label class="input-text-field">
            <?php echo $workplace_customers_address_warehouse_add_name_label; ?>
            <input id="name" type="text" class="input-send"
              title="<?php echo $workplace_customers_address_warehouse_add_name_hint; ?>"
              placeholder="<?php echo $workplace_customers_address_warehouse_add_name_placeholder; ?>">
          </label>
          <label class="input-text-field">
            <?php echo $workplace_customers_address_warehouse_add_description_label; ?>
            <input id="description" type="text" class="input-send"
              title="<?php echo $workplace_customers_address_warehouse_add_description_hint; ?>"
              placeholder="<?php echo $workplace_customers_address_warehouse_add_description_placeholder; ?>">
          </label>
          <label class="input-text-field">
            <?php echo $workplace_customers_address_warehouse_add_code_label; ?>
            <input id="code" type="text" class="input-send"
              title="<?php echo $workplace_customers_address_warehouse_add_code_hint; ?>"
              placeholder="<?php echo $workplace_customers_address_warehouse_add_code_placeholder; ?>">
          </label>
          <label class="checkbox-field">
            <input id="status" type="checkbox" class="input-send"
              title="<?php echo $workplace_customers_address_warehouse_add_status_hint; ?>" checked/>
            <?php echo $workplace_customers_address_warehouse_add_status_label; ?>
          </label>
  
          <div class="between">

            <a href="<?php echo $cancel_button_href; ?>"
              title="<?php echo $workplace_customers_address_warehouse_add_cancel_button_hint; ?>">
              <button class="inactive-button">
                <?php echo $workplace_customers_address_warehouse_add_cancel_button_text; ?>
              </button>

            </a>
            <button type="button" id="send-message-button" class="save-changes"
              title="<?php echo $workplace_customers_address_warehouse_add_save_button_hint; ?>"
              onMouseDown="File_Form( '<?php echo $save_button_href; ?>' )" >
              <?php echo $workplace_customers_address_warehouse_add_add_button_text; ?>
            </button>

          </div>
        </div>

        <span class="error-alert"></span>
      </div>

    </div>

  </div>

</div>

<?php echo $common_footer; ?>