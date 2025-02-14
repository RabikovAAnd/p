<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_customers_interactions_offer_add_header; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="info-content-block">
        <div class="list">

          <label class="input-text-field">
            <span><?php echo $workplace_customers_interactions_offer_add_offer_label; ?></span>
            <input type="text" id="extern_number" class="input-send"
              title="<?php echo $workplace_customers_interactions_offer_add_offer_hint; ?>"
              placeholder="<?php echo $workplace_customers_interactions_offer_add_offer_placeholder; ?>" />
          </label>
          <label class="input-text-field">
            <span>*<?php echo $workplace_customers_interactions_offer_add_payment_address_label; ?></span>
            <select type="text" id="payment_address" class="input-send"title="<?php echo $workplace_customers_interactions_offer_add_payment_address_hint; ?>">
            <option value=""><?php echo $workplace_customers_interactions_offer_add_payment_address_placeholder; ?></option>
            <?php foreach ( $payment_addresses as $payment_address ) { ?>
            <option value="<?php echo $payment_address['guid']; ?>"><?php echo $payment_address['address_name']; ?></option>
            <?php } ?>
            </select>
          </label>

          <label class="input-text-field">
            <span>*<?php echo $workplace_customers_interactions_offer_add_delivery_address_label; ?></span>
            <select type="text" id="delivery_address" class="input-send"
              title="<?php echo $workplace_customers_interactions_offer_add_delivery_address_hint; ?>">
            <option value=""><?php echo $workplace_customers_interactions_offer_add_delivery_address_placeholder; ?></option>
            <?php foreach ($delivery_addresses as $delivery_address) { ?>
            <option value="<?php echo $payment_address['guid']; ?>"><?php echo $delivery_address['address_name']; ?></option>
            <?php } ?>
            </select>
          </label>
          <label class="input-text-field">
            <span><?php echo $workplace_customers_interactions_offer_add_comment_label; ?></span>
            <textarea id="comment" rows="4" class="input-send"
              title="<?php echo $workplace_customers_interactions_offer_add_comment_hint;  ?>"
              placeholder="<?php echo $workplace_customers_interactions_offer_add_comment_placeholder; ?>"></textarea>
          </label>
          <div class="end">
            <button type="submit" onclick="File_Form('<?php echo $create_button_href;  ?>')">
              <?php echo $workplace_customers_interactions_offer_add_create_button_text; ?>
            </button>
          </div>
        </div>
        <span class="error-alert"></span>
      </div>
    </div>
  </div>
</div>

<?php echo $common_footer; ?>