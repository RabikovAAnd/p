<?php echo $common_header; ?>
<div>
  <h1><?php echo $cart_show_cart_header; ?></h1>
  <div class="cart info-content-block">

    <?php foreach ($products as $product) { ?>
    <div id="<?php echo $product[ 'product_guid' ]; ?>" class="item">

      <?php if ( $product[ 'product_image_link' ] == '' ) { ?>
      <img class="item__cart-img" src="./image/default/no_image.jpg"
           title="<?php echo $product[ 'product_image_name' ]; ?>"/>
      <?php } else { ?>
      <img class="item__cart-img" src="<?php echo $product[ 'product_image_link' ]; ?>"
           title="<?php echo $product[ 'product_image_name' ]; ?>"/>
      <?php } ?>

      <div class="item__info">

        <div>
          <div><?php echo $cart_show_cart_model_text; ?>:
            <a href="<?php echo $product[ 'product_href' ]; ?>"><?php echo $product[ 'product_mpn' ]; ?></a>
          </div>
          <div><?php echo $cart_show_cart_manufacturer_text; ?>:
            <a href="<?php echo $product[ 'product_manufacturer_href' ]; ?>"><?php echo $product[ 'product_manufacturer_name' ]; ?></a>
          </div>
          <p class="item__description"><?php echo $product[ 'product_description' ]; ?></p>
        </div>

        <div class="item__amount-info">
          <div class="item__quantity-button">
            <button type="button" onclick="Set_Quantity()"
                    data-action="minus">-
            </button>
            <input class="item__item-quantity"
                   onchange="Set_Quantity()"
                   data-action="input"
                   type="number"
                   min="0"
                   value="<?php echo $product[ 'product_cart_quantity' ]; ?>"
                   max="<?php echo $product[ 'product_stock_quantity' ]; ?>"/>
            <button type="button" onclick="Set_Quantity()"
                    data-action="plus">+
            </button>
          </div>

          <div class="item__features">
            <?php echo $cart_show_cart_price_text; ?>: <span
                    class="item__price"><?php echo $product[ 'product_cart_price' ]; ?></span><?php echo $product[ 'product_cart_currency' ]; ?>
            <br><?php echo $cart_show_cart_net_text; ?>: <span
                    class="item__net"><?php echo $product[ 'product_cart_net' ]; ?></span><?php echo $product[ 'product_cart_currency' ]; ?>
            <br><?php echo $cart_show_cart_vat_text . ' (' . $product[ 'product_cart_vat_rate' ] . ')'; ?>:
            <span class="item__vat"><?php echo $product[ 'product_cart_vat' ]; ?></span><?php echo $product[ 'product_cart_currency' ]; ?>
            <br><b><?php echo $cart_show_cart_amount_text; ?>: <span
                      class="item__total"><?php echo $product[ 'product_cart_total' ]; ?></span></b><?php echo $product[ 'product_cart_currency' ]; ?>
          </div>
        </div>
      </div>
      <a class="item__remove" href="<?php echo $product[ 'button_remove_product_href' ]; ?>">
        <img class="item__remove-button" src="./image/common/close.png" data-action="delete">
      </a>
    </div>
    <?php } ?>

    <div class="cart__features">
      <div><?php echo $cart_show_cart_net_text; ?>: <span
                class="cart__net"><?php echo $cart_net; ?></span><?php echo $product[ 'product_cart_currency' ]; ?>
      </div>
      <div><?php echo $cart_show_cart_vat_text; ?>: <span
                class="cart__vat"><?php echo $cart_vat ?></span><?php echo $product[ 'product_cart_currency' ]; ?>
      </div>
      <div><b><?php echo $cart_show_cart_total_amount_text; ?>: <span
                  class="cart__total"><?php echo $cart_total; ?></span><?php echo $product[ 'product_cart_currency' ]; ?>
        </b></div>
    </div>

  </div>

  <h1><?php echo $cart_show_contact_info_header; ?></h1>

  <div class="contact-data">
    <div class="contact-data__customer-data">
      <div class="info-content-block">
        <h2><?php echo $cart_show_customer_data_header; ?></h2>
        <div class="contact-data__info">
          <div>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_lastname_label; ?>
              <input id="customer_lastname"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_customer_data_lastname_hint;  ?>"
                     placeholder="<?php echo $cart_show_personal_data_lastname_placeholder; ?>">
            </label>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_firstname_label; ?>
              <input
                      id="customer_firstname"
                      type="text"
                      class="input-send"
                      title="<?php echo $cart_show_customer_data_firstname_hint;  ?>"
                      placeholder="<?php echo $cart_show_personal_data_firstname_placeholder; ?>">
            </label>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_middlename_label; ?>
              <input id="customer_middlename"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_customer_data_middlename_hint;  ?>"
                     placeholder="<?php echo $cart_show_personal_data_middlename_placeholder; ?>">
            </label>
          </div>
          <div>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_email_label; ?>
              <input id="customer_email"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_customer_data_email_hint;  ?>"
                     placeholder="<?php echo $cart_show_personal_data_email_placeholder; ?>">
            </label>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_telephone_label; ?>
              <input id="customer_telephone"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_customer_data_telephone_hint;  ?>"
                     placeholder="+XXX (XXX) XX-XX-XX">
            </label>
          </div>
        </div>
        <?php if ( $customer_logged === true ) { ?>
        <div class="list">
          <h2><?php echo $cart_show_invoice_to_header; ?></h2>
          <div id="payment_address_guid"
               name="address_id"
               class="addresses-list">
            <?php foreach ( $payment_addresses as $payment_address ) { ?>
            <?php if ( $payment_address['guid'] == $cart[ 'payment_address_guid' ] ) { ?>
            <span class="info-content-block address__type active"
                  id="<?php echo $payment_address['guid']; ?>"><?php echo $payment_address['address_name']; ?></span>
            <?php } else { ?>
            <span class="info-content-block address__type "
                  id="<?php echo $payment_address['guid']; ?>"><?php echo $payment_address['address_name']; ?></span>
            <?php }?>
            <?php } ?>
          </div>
        </div>
        <?php } ?>
      </div>

      <?php if ( $customer_logged !== true ) { ?>
      <div class="contact-data__address">
        <div id="customer_address-info" class="contact-data__address-info info-content-block">
          <div>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_country_label; ?>
              <select id="customer_country"
                      name="country_id"
                      class="input-send"
                      title="<?php echo  $cart_show_customer_data_country_hint;  ?>"
                      required>
                <option value="0"><?php echo $cart_show_country_placeholder; ?></option>
                <?php foreach ($countries as $country) { ?>
                <?php if ($country['country_id'] == $country_id) { ?>
                <option value="<?php echo $country['country_id']; ?>"
                        selected="selected"><?php echo $country['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </label>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_region_label; ?>
              <select id="customer_zone"
                      name="zone_id"
                      class="input-send"
                      title="<?php echo  $cart_show_customer_data_zone_hint;  ?>"
                      required>
                <option value="0"><?php echo $cart_show_zone_placeholder; ?></option>
                <?php foreach ($zones as $zone) { ?>

                <option value="<?php echo $zone['zone_id']; ?>"><?php echo $zone['name']; ?></option>

                <?php } ?>
              </select>
            </label>
          </div>

          <div>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_postcode_label; ?>
              <input id="customer_postcode"
                     type="text"
                     title="<?php echo $cart_show_customer_data_postcode_hint;  ?>"
                     class="input-send"
                     placeholder="123456">
            </label>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_city_label; ?>
              <input id="customer_city"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_customer_data_city_hint;  ?>"
                     placeholder="<?php echo $cart_show_personal_data_city_placeholder; ?>">
            </label>
          </div>

          <div>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_street_label; ?>
              <input id="customer_street"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_customer_data_street_hint;  ?>"
                     placeholder="<?php echo $cart_show_personal_data_street_placeholder; ?>">
            </label>
          </div>
          <div>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_house_number_label; ?>
              <input id="customer_house_number"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_customer_data_house_number_hint;  ?>"
                     placeholder="80">
            </label>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_building_label; ?>
              <input id="customer_building"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_customer_data_building_hint;  ?>"
                     placeholder="1">
            </label>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_apartment_label; ?>
              <input id="customer_apartment"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_customer_data_apartment_hint;  ?>"
                     placeholder="77">
            </label>
          </div>

          <?php if ( $customer_logged === true ) { ?>
          <label class="contact-data__save-address checkbox">
            <input type="checkbox"><?php echo $cart_show_personal_data_save_address_text; ?>
          </label>
          <?php } ?>

        </div>

      </div>
      <?php } ?>
    </div>

    <div class="contact-data__recipient_data ">
      <div class="info-content-block">
        <h2><?php echo $cart_show_recipient_data_header; ?></h2>
        <div class="contact-data__info">
          <div>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_lastname_label; ?>
              <input id="recipient_lastname"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_recipient_data_lastname_hint;  ?>"
                     placeholder="<?php echo $cart_show_personal_data_lastname_placeholder; ?>">
            </label>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_firstname_label; ?>
              <input id="recipient_firstname"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_recipient_data_firstname_hint;  ?>"
                     placeholder="<?php echo $cart_show_personal_data_firstname_placeholder; ?>">
            </label>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_middlename_label; ?>
              <input id="recipient_middlename"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_recipient_data_middlename_hint;  ?>"
                     placeholder="<?php echo $cart_show_personal_data_middlename_placeholder; ?>">
            </label>
          </div>
          <div>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_email_label; ?>
              <input id="recipient_email"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_recipient_data_email_hint; ?>"
                     placeholder="<?php echo $cart_show_personal_data_email_placeholder; ?>">
            </label>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_telephone_label; ?>
              <input id="recipient_telephone"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_recipient_data_telephone_hint; ?>"
                     placeholder="+XXX (XXX) XX-XX-XX">
            </label>
          </div>
        </div>
        <?php if ($customer_logged) { ?>
        <div class="list">
          <h2><?php echo $cart_show_delivery_to_header; ?></h2>

          <div id="delivery_address_guid"

               class="addresses-list">

            <?php foreach ($delivery_addresses as $delivery_address) { ?>
            <?php if ( $delivery_address[ 'guid' ] == $cart[ 'delivery_address_guid' ] ) { ?>

            <span class="info-content-block address__type active"
                  id="<?php echo $delivery_address['guid']; ?>"><?php echo $delivery_address['address_name']; ?></span>
            <?php } else { ?>
            <span class="info-content-block address__type "
                  id="<?php echo $delivery_address['guid']; ?>"><?php echo $delivery_address['address_name']; ?></span>
            <?php }?>
            <?php } ?>
          </div>
        </div>
        <?php } ?>
      </div>

      <?php if ( $customer_logged !== true ) { ?>
      <div class="contact-data__address ">

        <div id="recipient_address-info" class="contact-data__address-info info-content-block">
          <div>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_country_label; ?>
              <select id="recipient_country"
                      name="country_id"
                      class="input-send"
                      title="<?php echo  $cart_show_recipient_data_country_hint; ?>"
                      required>
                <option value="0"><?php echo $cart_show_country_placeholder; ?></option>
                <?php foreach ($countries as $country) { ?>
                <?php if ($country['country_id'] == $country_id) { ?>
                <option value="<?php echo $country['country_id']; ?>"
                        selected="selected"><?php echo $country['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </label>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_region_label; ?>
              <select id="recipient_zone"
                      name="zone_id"
                      class="input-send"
                      title="<?php echo  $cart_show_recipient_data_zone_hint;  ?>"
                      required>
                <option value="0"><?php echo $cart_show_zone_placeholder; ?></option>
                <?php foreach ($zones as $zone) { ?>

                <option value="<?php echo $zone['zone_id']; ?>"><?php echo $zone['name']; ?></option>

                <?php } ?>
              </select>
            </label>
          </div>

          <div>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_postcode_label; ?>
              <input id="recipient_postcode"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_recipient_data_postcode_hint;  ?>"
                     placeholder="123456">
            </label>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_city_label; ?>
              <input id="recipient_city"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_recipient_data_city_hint;  ?>"
                     placeholder="<?php echo $cart_show_personal_data_city_placeholder; ?>">
            </label>
          </div>

          <div>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_street_label; ?>
              <input id="recipient_street"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_recipient_data_street_hint;  ?>"
                     placeholder="<?php echo $cart_show_personal_data_street_placeholder; ?>">
            </label>
          </div>
          <div>

            <label class="input-text-field">
              <?php echo $cart_show_personal_data_house_number_label; ?>
              <input id="recipient_house_number"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_recipient_data_house_number_hint;  ?>"
                     placeholder="80">
            </label>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_building_label; ?>
              <input id="recipient_building"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_recipient_data_building_hint; ?>"
                     placeholder="1">
            </label>
            <label class="input-text-field">
              <?php echo $cart_show_personal_data_apartment_label; ?>
              <input id="recipient_apartment"
                     type="text"
                     class="input-send"
                     title="<?php echo $cart_show_recipient_data_apartment_hint; ?>"
                     placeholder="77">
            </label>
          </div>
          <?php if ($customer_logged) { ?>
          <label class="contact-data__save-address checkbox">
            <input type="checkbox"
                   class="input-send">
            <?php echo $cart_show_personal_data_save_address_text; ?>
          </label>
          <?php } ?>

        </div>

      </div>
      <?php }?>
    </div>

  </div>


  <h1><?php echo $cart_show_delivery_method_header; ?></h1>

  <div id='delivery_method_id' class="shipping info-content-block">

    <?php if ( count( $delivery_methods ) === 0 ){ ?>
    <div><?php echo $cart_show_no_delivery_methods_text; ?></div>
    <?php } else { ?>
    <?php foreach ( $delivery_methods as $delivery_method ) { ?>
    <?php if ( $delivery_method[ 'id' ] == $cart[ 'delivery_method_id' ] ) { ?>
    <div id="<?php echo $delivery_method[ 'id' ]; ?>" class="shipping__type info-content-block active">
      <?php } else { ?>
      <div id="<?php echo $delivery_method[ 'id' ]; ?>" class="shipping__type info-content-block">
        <?php } ?>
        <img class="shipping__type-img" src="./image/default/no_image.jpg"
             title="<?php echo $delivery_method[ 'name' ]; ?>"/>
        <div class="shipping__type-value">
          <h2><?php echo $delivery_method[ 'name' ]; ?></h2>
          <div>
            <?php echo $delivery_method[ 'description' ]; ?>
            <br><span class="shipping__type-price"><?php echo $cart_show_delivery_period_text; ?>: <b><?php echo $delivery_method[ 'delivery_time_minimum' ] . '-' . $delivery_method[ 'delivery_time_maximum' ]; ?></b></span>
            <br><span><?php echo $cart_show_delivery_method_price_text; ?>: <b><?php echo $delivery_method[ 'price' ] . ' ' . $delivery_method[ 'currency_code' ]; ?></b></span>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php } ?>

    </div>

    <h1><?php echo $cart_show_payment_method_header; ?></h1>

    <div id='payment_method_id' class="payment info-content-block">

    <?php if ( count( $payment_methods ) === 0 ){ ?>
    <div><?php echo $cart_show_no_payment_methods_text; ?></div>
    <?php } else { ?>
    <?php foreach ( $payment_methods as $payment_method ) { ?>
    <div id="<?php echo $payment_method[ 'id' ]; ?>" class="info-content-block payment__type <?php echo ( $payment_method[ 'id' ] == $cart[ 'payment_method_id' ] ) ? 'active' : ''; ?>">

      <img class="payment__type-img" src="./image/default/no_image.jpg"
            title="<?php echo $payment_method[ 'name' ]; ?>"/>
      <div class="payment__type-value">
        <h2><?php echo $payment_method[ 'name' ]; ?></h2>
        <div>
          <?php echo $payment_method[ 'description' ]; ?>
          <?php /*
          ANVILEX KM: Temporary removed
          <br><span><?php echo $cart_show_payment_period_text; ?>: immediatly</span>
          <br><span class="payment__type-price"><?php echo $cart_show_payment_commission_text; ?>: 5 EUR</span>
          */ ?>
        </div>
      </div>
    </div>
    <?php } ?>
    <?php } ?>

      </div>

      <h1><?php echo $cart_show_order_header; ?></h1>

      <div class="info-content-block">
        <div class="cart-execution">
          <div class="cart-execution__comment">
            <textarea
                    id="comment"
                    rows="4"
                    class="input-send"
                    title="<?php echo $cart_show_order_comment_hint;  ?>"
                    placeholder="<?php echo $cart_show_order_comment_placeholder; ?>"><?php echo $cart[ 'comment' ]; ?></textarea>
            <div>
              <label>
                <input id="agreement_information_data"
                       type="checkbox"
                       class="input-send">
                <?php echo $cart_show_agreement_information_data_text; ?>
                <a href="index.php?route=company/terms">
                  <?php echo $cart_show_information_terms_of_use_text; ?>
                </a>
                <?php echo $cart_show_agreement_information_conjunction_data_text; ?>
                <a href="index.php?route=company/conditions">
                  <?php echo $cart_show_information_conditions_text; ?>
                </a>
              </label>
              <label>
                <input id="agreement_personal_data"
                       type="checkbox"
                       class="input-send">
                <?php echo $cart_show_agreement_personal_data_text; ?>
                <a href="index.php?route=company/privacy"><?php echo $cart_show_agreement_personal_data_href_text; ?></a>
              </label>
            </div>
          </div>

          <div class="cart-execution__submit">
            <div class="cart-execution__result">
                <span><b><?php echo $cart_show_cart_net_text; ?>:</b> <?php echo $cart_net; ?>
                  <br>
                    <b><?php echo $cart_show_cart_vat_text; ?>:</b> <?php echo $cart_vat; ?></span>
              <span><b><?php echo $cart_show_cart_total_amount_text; ?>
                  :</b> <?php echo $cart_total; ?></span>
            </div>
            <button type="submit" class="cart-execution__submit-button"
                    onclick="File_Form('index.php?route=cart/show/add_order')"><?php echo $cart_show_pay_button_text; ?></button>
          </div>

        </div>
        <span class="error-alert"></span>
      </div>
    </div>


    <?php echo $common_footer; ?>
  </div>
</div>

  <script type="text/javascript">
    document.addEventListener('click', function (event) {

      let address_type = event.target;
      if (address_type.closest(".address__type")) {
        let el = address_type.closest(".address__type");
        let guid = $(el).attr('id');
        let ships = el.closest(".addresses-list");
        for (let i = 0; i < ships.children.length; i++) {
          ships.children[i].className = ships.children[i].className.replace("active", "");
        }
        let url = '';
        el.className += " " + "active";
        // if($(address_type).attr('id') === '0'){
        //     $('#'+$(address_type).closest(".addresses-list").attr('id').slice(0, $(address_type).closest(".addresses-list").attr('id').search('_'))+'_address-info').show()
        // }else{
        //     $('#'+$(address_type).closest(".addresses-list").attr('id').slice(0, $(address_type).closest(".addresses-list").attr('id').search('_'))+'_address-info').hide()
        // }set_payment_address
        console.log($(address_type).closest(".addresses-list").attr('id'));
        console.log('GUID: ' + guid);
        if ($(address_type).closest(".addresses-list").attr('id') === 'payment_address_guid') {
          url = 'index.php?route=cart/show/set_payment_address'
        } else {
          url = 'index.php?route=cart/show/set_delivery_address'
        }
        $.ajax({
          url: url,
          type: 'POST',
          dataType: 'json',
          data: 'guid=' + guid,

          success: function (json) {
            console.log('Return code: ' + json['return_code']);
          },
          error: function (jqXHR, exception, json) {
            console.log(json['error']);
          }

        });
      }
    });

    document.addEventListener('click', function (event) {
      let ship_type = event.target;
      if (ship_type.closest(".shipping__type")) {
        let el = ship_type.closest(".shipping__type");
        let shipping_id = $(el).attr('id');
        let ships = el.closest(".shipping");
        for (let i = 0; i < ships.children.length; i++) {
          ships.children[i].className = ships.children[i].className.replace("active", "");
        }
        el.className += " " + "active";
        console.log(shipping_id);
        $.ajax({
          url: 'index.php?route=cart/show/set_delivery_method',
          type: 'POST',
          dataType: 'json',
          data: {id: shipping_id},

          success: function (json) {
            console.log('success ' + json['return_code']);
          },
          error: function (jqXHR, exception, json) {
            console.log(json['error']);
          }

        });
      }
    });
    // $(".item__item-quantity").bind('change', function (event) {
    //   // if ($(this).val() === 0) {
    //   //   console.log($(this).val());
    //   // }
    //   console.log($(this).value());
    //   // window.location.replace(window.location.href.split("?")[0]+'?route=error/not_found')
    //   // <?php echo $product[ 'button_remove_product_href' ]; ?>
    // });
    document.addEventListener('click', function (event) {
      let payment_type = event.target;
      if (payment_type.closest(".payment__type")) {
        let el = payment_type.closest(".payment__type");
        let ships = el.closest(".payment");
        let payment_id = $(el).attr('id');
        for (let i = 0; i < ships.children.length; i++) {
          ships.children[i].className = ships.children[i].className.replace("active", "");
        }
        el.className += " " + "active";
        console.log(payment_id);
        $.ajax({
          url: 'index.php?route=cart/show/set_payment_method',
          type: 'POST',
          dataType: 'json',
          data: {id: payment_id},

          success: function (json) {
            console.log('success ' + json['return_code']);
          },
          error: function (jqXHR, exception, json) {
            console.log('error ' + exception + ' ' + json['error']);
          }

        });
      }
    });
    $('#comment').bind('change', function () {

      $.ajax({
        url: 'index.php?route=cart/show/set_comment',
        type: 'POST',
        dataType: 'json',
        data: 'comment=' + $(this).val(),
        success: function (json) {
          console.log('success ' + json['return_code']);
        },
        error: function (jqXHR, exception, json) {
          console.log('error ' + exception + ' ' + json['error']);
        }

      });
    });
    $('select[name=\'country_id\']').bind('change', function () {
      if (this.value !== '0') {
        $.ajax({
          url: 'index.php?route=cart/show/country',
          data: 'country_id=' + this.value + '&html_id=' + $(this).attr('id'),
          type: 'get',
          dataType: 'json',
          success: function (json) {

            let html = '<option value="0"><?php echo $cart_show_zone_placeholder; ?></option>';

            if (json['zone'] !== '') {
              for (i = 0; i < json['zone'].length; i++) {
                html += '<option value="' + json['zone'][i]['zone_id'] + '"';

                if (json['zone'][i]['zone_id'] === '<?php echo $zone_id; ?>') {
                  html += ' selected="selected"';
                }

                html += '>' + json['zone'][i]['name'] + '</option>';
              }
            } else {
              html += '<option value="-1" selected="selected"><?php echo $cart_show_zone_none_text; ?></option>';
            }
            let html_id = json['html_id'].slice(0, json['html_id'].indexOf("_"))

            $('#' + html_id + '_zone').html(html);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            // ANVILEX : zone_id fix
            let html = '<option value="-1" selected="selected"><?php echo $cart_show_zone_none_text; ?></option>';
            $('select[name=\'zone_id\']').html(html);

            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
      } else {
        $.ajax({
          url: 'index.php?route=cart/show/set_zones',
          data: 'html_id=' + $(this).attr('id'),
          type: 'get',
          dataType: 'json',
          success: function (json) {
            console.log(json['zone'])
            let html = '<option value="0"><?php echo $cart_show_zone_placeholder; ?></option>';

            if (json['zone'] !== '') {
              for (i = 0; i < json['zone'].length; i++) {
                html += '<option value="' + json['zone'][i]['zone_id'] + '"';

                if (json['zone'][i]['zone_id'] === '<?php echo $zone_id; ?>') {
                  html += ' selected="selected"';
                }

                html += '>' + json['zone'][i]['name'] + '</option>';
              }
            } else {
              html += '<option value="-1" selected="selected"><?php echo $cart_show_zone_none_text; ?></option>';
            }
            let html_id = json['html_id'].slice(0, json['html_id'].indexOf("_"))

            $('#' + html_id + '_zone').html(html);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            // ANVILEX : zone_id fix
            let html = '<option value="-1" selected="selected"><?php echo $cart_show_zone_none_text; ?></option>';
            $('select[name=\'zone_id\']').html(html);

            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
      }

    });

    $('select[name=\'zone_id\']').bind('change', function () {
      if (this.value !== '0') {
        $.ajax({
          url: 'index.php?route=cart/show/set_country_by_zone',
          data: 'zone_id=' + this.value + '&html_id=' + $(this).attr('id'),
          type: 'get',
          dataType: 'json',
          success: function (json) {

            let html_id = json['html_id'].slice(0, json['html_id'].indexOf("_"));
            console.log(html_id);
            $('#' + html_id + '_country').val(json['country_id']);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            // ANVILEX : zone_id fix
            let html = '<option value="-1" selected="selected"><?php echo $cart_show_zone_none_text; ?></option>';
            $('select[name=\'zone_id\']').html(html);

            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
      }

    });
  </script>

