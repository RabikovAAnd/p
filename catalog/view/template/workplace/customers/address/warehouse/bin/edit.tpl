<?php echo $common_header; ?>
<div id="content">
  <h1 class="header-list__edit">
    <?php echo $workplace_customers_address_warehouse_bin_edit_header; ?>
  </h1>


  <div class="account-area">
    <?php echo $workplace_menu; ?>

    <div class="main-area">
      <div class="info-content-block">
        <div class="list">

          <label class="input-text-field">
            <?php echo $workplace_customers_address_warehouse_bin_edit_code_label; ?>
            <input id="code" type="text" class="input-send"
              title="<?php echo $workplace_customers_address_warehouse_bin_edit_code_hint; ?>"
              placeholder="<?php echo $workplace_customers_address_warehouse_bin_edit_code_placeholder; ?>"
              value="<?php echo $bin['code']; ?>">
          </label>

          <div class="between">
            <a href="<?php echo $cancel_button_href; ?>">
              <button class="inactive-button">
                <?php echo $workplace_customers_address_warehouse_bin_edit_cancel_button_text; ?>
              </button>
            </a>
            <button type="button" id="send-message-button" class="save-changes"
              title="<?php echo $workplace_customers_address_warehouse_bin_edit_save_button_hint; ?>"
              onMouseDown="File_Form('<?php echo $save_button_href; ?>')">
              <?php echo $workplace_customers_address_warehouse_bin_edit_save_button_text; ?>
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
    if (this.value !== '0') {
      $.ajax({
        url: 'index.php?route=workplace/customers/address/edit/country',
        data: 'country_id=' + this.value,
        type: 'get',
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
    } else {
      $.ajax({
        url: 'index.php?route=workplace/customers/address/edit/set_zones',
        type: 'get',
        data: 'country_id=' + this.value,
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
    if (this.value !== '0') {
      $.ajax({
        url: 'index.php?route=workplace/customers/address/edit/set_country_by_zone',
        data: 'zone_id=' + this.value,
        type: 'get',
        dataType: 'json',
        success: function (json) {


          $('#country_id').val(json['country_id']);
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