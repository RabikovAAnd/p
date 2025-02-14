<?php echo $common_header; ?>
<div id="content">
  <h1 class="header-list__edit">
    <?php echo $workplace_customers_interactions_address_payment_edit_header; ?>
  </h1>


  <div class="account-area">
    <?php echo $workplace_menu; ?>

    <div class="main-area">
      <div class="info-content-block">
        <div class="list">
          <label class="input-text-field">
            <span>*<?php echo $workplace_customers_interactions_address_payment_edit_address_label; ?>
            </span>
            <select type="text" id="address_guid" class="input-send"
              title="<?php echo $workplace_customers_interactions_address_payment_edit_address_hint; ?>" />
            <option value="">
              
              <?php echo $workplace_customers_interactions_address_payment_edit_address_placeholder; ?>
            </option>
            <?php foreach ( $addresses as $address ) { ?>
            <option value="<?php echo $address['guid']; ?>">
              <?php echo $address['address_text']; ?>
            </option>
            <?php } ?>
            </select>
          </label>


          <div class="between">
            <a href="<?php echo $cancel_button_href; ?>">
              <button class="inactive-button">
                <?php echo $workplace_customers_interactions_address_payment_edit_cancel_button_text; ?>
              </button>
            </a>
            <button type="button" id="send-message-button" class="save-changes"
              title="<?php echo $workplace_customers_interactions_address_payment_edit_save_button_hint; ?>"
              onMouseDown="File_Form('<?php echo $edit_button_href; ?>')">
              <?php echo $workplace_customers_interactions_address_payment_edit_save_button_text; ?>
            </button>
          </div>
        </div>

        <span class="error-alert"></span>
      </div>

    </div>

  </div>

</div>

<?php echo $common_footer; ?>
