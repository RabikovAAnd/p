<?php echo $common_header; ?>
<div id="content">
  <h1 class="header-list__edit"><?php echo $workplace_customers_address_edit_header; ?></h1>

  
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    
    <div class="main-area">
    <div class="info-content-block">
<div class="list">
 <div class="address">
          <div>
            <label class="input-text-field">
              <?php echo $workplace_customers_address_edit_country_label; ?>
              <select  id="country_id"
                       name="country_id"
                       title="<?php echo $workplace_customers_address_edit_country_hint; ?>"
                       class="input-send"
                       required>
                <option value="0"><?php echo $workplace_customers_address_edit_country_placeholder; ?></option>
                <?php foreach ($countries as $country) { ?>
                <?php if ($country['country_id'] == $address['country_id']) { ?>
                <option value="<?php echo $country['country_id']; ?>"
                        selected="selected"><?php echo $country['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </label>
            <label class="input-text-field">
              <?php echo $workplace_customers_address_edit_region_label; ?>
              <select  id="zone_id"
                       name="zone_id"
                       class="input-send"
                       title="<?php echo $workplace_customers_address_edit_region_hint; ?>"
                       required>
                <option value="0"><?php echo $workplace_customers_address_edit_region_placeholder; ?></option>
                <?php foreach ($zones as $zone) { ?>
                <?php if ($zone['zone_id'] == $address['zone_id']) { ?>
                <option value="<?php echo $zone['zone_id']; ?>"
                        selected="selected"><?php echo $zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $zone['zone_id']; ?>"><?php echo $zone['name']; ?></option>
                <?php } ?>


                <?php } ?>
              </select>
            </label>
          </div>
          <label class="input-text-field">
            <?php echo $workplace_customers_address_edit_postcode_label; ?>
            <input  id="postcode"
                    type="text"
                    class="input-send"
                    title="<?php echo $workplace_customers_address_edit_postcode_hint; ?>"
                    placeholder="123456"
                    value="<?php echo $address['postcode']; ?>">
          </label>
          <label class="input-text-field">
            <?php echo $workplace_customers_address_edit_city_label; ?>
            <input  id="city"
                    type="text"
                    class="input-send"
                    title="<?php echo $workplace_customers_address_edit_city_hint; ?>"
                    placeholder="<?php echo $workplace_customers_address_edit_city_placeholder; ?>"
                    value="<?php echo $address['city']; ?>">
          </label>
          <div>
            <label class="input-text-field">
              <?php echo $workplace_customers_address_edit_street_label; ?>
              <input  id="street"
                      type="text"
                      class="input-send"
                      title="<?php echo $workplace_customers_address_edit_street_hint; ?>"
                      placeholder="<?php echo $workplace_customers_address_edit_street_placeholder; ?>"
                      value="<?php echo $address['street']; ?>">
            </label>
          </div>
          <div>
            <label class="input-text-field">
              <?php echo $workplace_customers_address_edit_house_number_label; ?>
              <input  id="house"
                      type="text"
                      class="input-send"
                      title="<?php echo $account_address_form_edit_house_number_hint; ?>"
                      placeholder="80"
                      value="<?php echo $address['house']; ?>">
            </label>
            <label class="input-text-field">
              <?php echo $workplace_customers_address_edit_building_label; ?>
              <input  id="building"
                      type="text"
                      class="input-send"
                      title="<?php echo $workplace_customers_address_edit_building_hint; ?>"
                      placeholder="1"
                      value="<?php echo $address['building']; ?>">
            </label>
            <label class="input-text-field">

              <?php echo $workplace_customers_address_edit_apartment_label; ?>
              <input  id="apartment"
                      type="text"
                      class="input-send"
                      title="<?php echo $workplace_customers_address_edit_apartment_hint; ?>"
                      placeholder="77"
                      value="<?php echo $address['apartment']; ?>">
            </label>
          </div>

      </div>

      <div class="between">
        <a 
           href="<?php echo $cancel_button_href; ?>">
           <button class="inactive-button">
            <?php echo $workplace_customers_address_edit_cancel_button_text; ?>
           </button>
        </a>
        <button type="button" id="send-message-button"
                class="save-changes"
                title="<?php echo $workplace_customers_address_edit_save_button_hint; ?>"
                onMouseDown="File_Form('<?php echo $save_button_href; ?>')"
                value="<?php echo $button_save_changes; ?>">
          <?php echo $workplace_customers_address_edit_save_button_text; ?>
        </button>
      </div>
</div>
       
      <span class="error-alert"></span>
    </div>

  </div>

</div>

</div>

<?php echo $common_footer; ?>

<script type="text/javascript">

  $('#country_id').bind('change', function () {
    if(this.value !== '0'){
      $.ajax({
        url: 'index.php?route=workplace/customers/address/edit/country',
        data: 'country_id='  + this.value,
        type: 'get',
        dataType: 'json',
        success: function (json) {

          let html = '<option value="0"><?php echo $workplace_customers_address_edit_country_placeholder; ?></option>';

          if (json['zone'].length !== 0) {
            for (i = 0; i < json['zone'].length; i++) {
              html += '<option value="' + json['zone'][i]['zone_id'] + '"';

              if (json['zone'][i]['zone_id'] === '<?php echo $zone_id; ?>') {
                html += ' selected="selected"';
              }

              html += '>' + json['zone'][i]['name'] + '</option>';
            }
          } else {
            html += '<option value="-1" selected="selected"><?php echo $workplace_customers_address_edit_zone_none_text; ?></option>';
          }


          $('#zone_id').html(html);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          // ANVILEX : zone_id fix
          let html = '<option value="-1" selected="selected"><?php echo $workplace_customers_address_edit_zone_none_text; ?></option>';
          $('#zone_id').html(html);

          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });
    }else{
      $.ajax({
        url: 'index.php?route=workplace/customers/address/edit/set_zones',
        type: 'get',
        data: 'country_id='  + this.value,
        dataType: 'json',
        success: function (json) {
          let html = '<option value="0"><?php echo $workplace_customers_address_edit_zone_placeholder; ?></option>';

          if (json['zone'].length !== 0) {
            for (i = 0; i < json['zone'].length; i++) {
              html += '<option value="' + json['zone'][i]['zone_id'] + '"';

              if (json['zone'][i]['zone_id'] === '<?php echo $zone_id; ?>') {
                html += ' selected="selected"';
              }

              html += '>' + json['zone'][i]['name'] + '</option>';
            }
          } else {
            html += '<option value="-1" selected="selected"><?php echo $workplace_customers_address_edit_zone_none_text; ?></option>';
          }


          $('#zone_id').html(html);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          // ANVILEX : zone_id fix
          let html = '<option value="-1" selected="selected"><?php echo $workplace_customers_address_edit_zone_none_text; ?></option>';
          $('#zone_id').html(html);

          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });
    }

  });
  $('#zone_id').bind('change', function () {
    if(this.value !== '0'){
      $.ajax({
        url: 'index.php?route=workplace/customers/address/edit/set_country_by_zone',
        data: 'zone_id='  + this.value,
        type: 'get',
        dataType: 'json',
        success: function (json) {


          $('#country_id').val( json['country_id']);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          // ANVILEX : zone_id fix
          let html = '<option value="-1" selected="selected"><?php echo $workplace_customers_address_edit_zone_none_text; ?></option>';
          $('#zone_id').html(html);

          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });
    }

  });
</script>
