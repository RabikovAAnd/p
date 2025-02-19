<?php echo $common_header; ?>

<div id="content">
  <h1><?php echo $item[ 'product_mpn' ]; ?></h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="info-content-block">
        <div class="list">
          <h2>
            <?php echo $workplace_item_general_data_header; ?>
          </h2>
          <div class="list">

            <label class="checkbox-field">
              <?php if ($item[ 'atomic_item' ] === false) {?>
              <input id="atomic_item" type="checkbox" class="input-send"
                title="<?php echo $workplace_items_edit_atomic_item_hint; ?>" />
              <?php } else { ?>
              <input id="atomic_item" type="checkbox" class="input-send"
                title="<?php echo $workplace_items_edit_atomic_item_hint; ?>" checked />
              <?php } ?>
              <?php echo $workplace_items_edit_general_data_atomic_item_text; ?>
            </label>
            <label class="input-text-field">
              <?php echo $workplace_items_edit_general_data_mpn_text; ?>
              <input id="mpn" type="text" class="input-send" title="<?php echo $workplace_items_edit_mpn_hint;  ?>"
                placeholder="<?php echo $workplace_items_edit_mpn_placeholder; ?>"
                value="<?php echo $item[ 'product_mpn' ]; ?>" />
            </label>
            <label class="input-text-field">
              <?php echo $workplace_items_edit_general_data_order_code_text; ?>
              <input id="order_code" type="text" class="input-send"
                title="<?php echo $workplace_items_edit_general_data_order_code_hint;  ?>"
                placeholder="<?php echo $workplace_items_edit_general_data_order_code_placeholder; ?>"
                value="<?php echo $item[ 'order_code' ]; ?>" />
            </label>
            <label class="input-text-field">
              <?php echo $workplace_items_edit_general_data_manufacturer_text; ?>
              <input id="manufacturer_list" type="text" class="input-send" list="manufacturer"
                title="<?php echo $workplace_items_edit_mpn_hint;  ?>"
                placeholder="<?php echo $workplace_items_edit_mpn_placeholder; ?>"
                value="<?php echo $item[ 'manufacturer_name' ]; ?>" />

              <select id="manufacturer" size="10" class="input-send"
                title="<?php echo $workplace_items_edit_manufacturer_hint; ?>" required>
                <?php if ($item_manufacturer_exist === true) {?>
                <option value="<?php echo $item[ 'manufacturer_guid' ]; ?>" selected="selected">
                  <?php echo $item[ 'manufacturer_name' ]; ?>
                </option>
                <?php }  ?>
                <?php foreach ($manufacturers as $manufacturer) { ?>
                <?php if ($item_manufacturer_exist === true && $manufacturer['guid'] != $item[ 'manufacturer_guid' ]) { ?>
                <option value="<?php echo $manufacturer['guid']; ?>">
                  <?php echo $manufacturer['name']; ?>
                </option>
                <?php } ?>
                <?php } ?>
              </select>

            </label>
            <label class="input-text-field">
              <?php echo $workplace_items_edit_general_data_description_text; ?>
              <textarea id="description" type="text" rows="4" class="input-send"
                title="<?php echo $workplace_items_edit_mpn_hint; ?>"
                placeholder="<?php echo $workplace_items_edit_mpn_placeholder; ?>"><?php echo $item[ 'description' ]; ?></textarea>
            </label>
            <label class="input-text-field">
              <?php echo $workplace_items_edit_unit_label; ?>
              <select id="unit" name="unit" class="input-send" title="<?php echo  $workplace_items_edit_unit_hint;  ?>"
                required>
                <option value="placeholder">
                  <?php echo $workplace_items_edit_unit_placeholder; ?>
                </option>
                <?php if ( isset($item[ 'unit_data' ])){ ?>
                <option value="<?php echo $item['quantisation_unit_id']; ?>" selected>
                  <?php echo $item[ 'unit_data' ][ 'name_declination_1']; ?>
                </option>
                <?php foreach ($units as $unit) { ?>
                <?php if ( $unit['id']!==$item['quantisation_unit_id']){ ?>
                <option value="<?php echo $unit['id']; ?>">
                  <?php echo $unit['name']; ?>
                </option>
                <?php } ?>
                <?php } ?>
                <?php } else{ ?>
                <?php foreach ($units as $unit) { ?>
                <option value="<?php echo $unit['id']; ?>">
                  <?php echo $unit['name']; ?>
                </option>
                <?php } ?>
                <?php } ?>
              </select>
            </label>
          </div>
          <div class="between">
            
            <a href="<?php echo $cancel_button_href; ?>"><button type="button">
              <?php echo $workplace_items_edit_cancel_button_text; ?>
            </button></a>
            <button
              onMouseDown="File_Form('<?php echo $workplace_items_edit_item_button_href; ?>',[['guid','<?php echo $item[ 'guid' ]; ?>']])">
              <?php echo $workplace_items_edit_edit_item_button_text; ?>
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

  $('#manufacturer_list').keyup(function () {
    Search();
  });

  function Search() {
    $.ajax({
      url: 'index.php?route=workplace/items/create/search',
      type: 'POST',
      dataType: 'json',
      data: 'search=' + $('#manufacturer_list').val(),
      success: function (json) {
        $('#manufacturer').html('');
        if (json['return_code']) {
          if (json['manufacturers']) {
            json['manufacturers'].forEach((manufacturer) => {
              $('#manufacturer').append('<option value="' + manufacturer['guid'] + '">' + manufacturer['name'] + '</option>');
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