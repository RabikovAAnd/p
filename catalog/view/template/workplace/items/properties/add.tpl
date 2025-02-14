<?php echo $common_header; ?>

<div id="content">
  <h1><?php echo $workplace_add_property_header; ?></h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
     <div class="info-content-block">
      <div class="list" >

          <label  class="input-text-field">

            <span><?php echo $workplace_add_property_property_group_label; ?></span>
            <input
              id="properties_groups_list"
              placeholder="<?php echo $workplace_add_property_property_group_placeholder; ?>"/>
            <select
              id="property_group"
              size="10"
              name="properties_group_guid"
              class="input-send">
                <?php foreach ($properties_groups as $properties_group) { ?>
                <option value="<?php echo $properties_group[ 'guid' ]; ?>"><?php echo $properties_group[ 'name' ]; ?></option>
                <?php } ?>
            </select>
          </label>
          <label  class="input-text-field">
            <span><?php echo $workplace_add_property_property_name_label; ?></span>
            <input
            id="properties_list"
              placeholder="<?php echo $workplace_add_property_property_name_placeholder; ?>"/>
            <select
              id="property_guid"
              size="10"
              name="property_guid"
              class="input-send"
              title="<?php echo $account_address_form_edit_zone_hint; ?>"
              required>

            </select>
          </label>

          <label  class="input-text-field">
          <span><?php echo  $workplace_add_property_property_value_label; ?></span>
          <input type="property_value"
                 id="property_value"
                 name="property_value"
                 class="input-send"
                 title="<?php echo  $workplace_add_property_property_value_hint; ?>"
                 placeholder="<?php echo  $workplace_add_property_property_value_placeholder; ?>"
                 required/>
        </label>

        <label  class="input-text-field">
          <span><?php echo $workplace_add_property_unit_name_label; ?></span>
         
          <select
            id="unit_guid"
            name="unit_guid"
            class="input-send"
            required>
            <option value=""><?php echo $workplace_add_property_unit_placeholder; ?></option>
          </select>
        </label>

        <div class="between">
          <a href="<?php echo $cancel_button_href; ?>"><button type="button">
            <?php echo $workplace_add_property_cancel_button_text; ?>
          </button></a>
          <button id="submit-button" type="submit"
          title="<?php echo  $workplace_add_customer_register_button_hint; ?>"
          onMouseDown="File_Form('<?php echo $workplace_add_property_button_href; ?>',
          [
            ['item_guid', '<?php echo $item_guid; ?>'],
            ['property_guid', $('#property_guid').val()],
            ['property_value', $('#property_value').val()],
            ['unit_guid', $('#unit_guid').val()],
            ['property_group', $('#property_group').val()]
          ])">
          <?php echo $workplace_add_property_add_property_button_text; ?>
          </button>
        </div>

      </div>
      <span class="error-alert"></span>
    </div>
    </div>

  </div>

</div>
<?php echo $common_footer; ?>
<script>

  $('#properties_groups_list').keyup(function () {
    Group_Search();
  });

  function Group_Search() {
    $.ajax({
      url: 'index.php?route=workplace/items/properties/add/Group_Search',
      type: 'POST',
      dataType: 'json',
      data: 'search=' + $('#properties_groups_list').val(),
      success: function (json) {
        $('#property_group').html('')
        if (json['return_code']) {
          if (json['properties_groups']) {
            json['properties_groups'].forEach((property_group) => {
              $('#property_group').append('<option value="' + property_group['guid'] +'">' + property_group['name'] + '</option>');
            })
          }
        }
      },
      error: function (jqXHR, exception, json) {
        console.log('error ' + exception + ' ' + json['error']);
      }
    });
  }

  $('#properties_list').keyup(function () {
    Property_Search();
  });

  $('#property_group').change(function () {
    Property_Search();
  });
  function Property_Search() {
    $.ajax({
      url: 'index.php?route=workplace/items/properties/add/Property_Search',
      type: 'POST',
      dataType: 'json',
      data: 'search=' + $('#properties_list').val()+'&group_guid=' + $('#property_group').val(),
      success: function (json) {
        $('#property_guid').html('')
        
        if (json['return_code']) {
          if (json['properties']) {
            json['properties'].forEach((property) => {
              $('#property_guid').append('<option value="' + property['guid'] +'">' + property['name'] + '</option>');
            })
          }
        }
      },
      error: function (jqXHR, exception, json) {
        console.log('error ' + exception + ' ' + json['error']);
      }
    });
  }


  $('#property_guid').change(function () {
    Unit_Search();
  });
  function Unit_Search() {
    $.ajax({
      url: 'index.php?route=workplace/items/properties/add/Unit_Search',
      type: 'POST',
      dataType: 'json',
      data: 'property_guid=' + $('#property_guid').val(),
      success: function (json) {
        $('#unit_guid').html('')
        $('#unit_guid').append('<option value="">' +  '<?php echo $workplace_add_property_unit_placeholder; ?>' + '</option>');
        if (json['return_code']) {
          if (json['units']) {
            json['units'].forEach((unit) => {
              let unit_name = (unit['description']['name_declination_1']) ? unit['description']['name_declination_1']: unit['name']
              $('#unit_guid').append('<option value="' + unit['guid'] +'">' + unit_name + '</option>');
            })
          }
        }
      },
      error: function (jqXHR, exception, json) {
        console.log('error ' + exception + ' ' + json['error']);
      }
    });
  }

</script>