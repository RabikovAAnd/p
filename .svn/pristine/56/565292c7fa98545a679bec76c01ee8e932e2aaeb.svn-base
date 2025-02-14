<?php echo $common_header; ?>

<div id="content">

  <h1>
    <?php echo $workplace_customers_interactions_items_add_header . ' №' . $order_id; ?>
  </h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="info-content-block">

        <div class="list">
          <label class="input-text-field">
            <?php echo $workplace_customers_interactions_items_add_quantity_label; ?>
            <input id="quantity" type="text" class="input-send"
              title="<?php echo $workplace_customers_interactions_items_add_quantity_hint;  ?>"
              placeholder="<?php echo $workplace_customers_interactions_items_add_quantity_placeholder; ?>" />
          </label>
          <label class="input-text-field">
            <?php echo $workplace_customers_interactions_items_add_item_label; ?>
            <input id="items" type="text" list="item_guid"
              title="<?php echo $workplace_customers_interactions_items_add_item_hint;  ?>"
              placeholder="<?php echo $workplace_customers_interactions_items_add_item_placeholder; ?>" required />
            <select id="item_guid" class="input-send" size="10">
              <?php foreach ($items as $item) { ?>
              <option id="<?php echo $item[ 'guid' ]; ?>" value="<?php echo $item[ 'guid' ]; ?>">
                <?php echo $item[ 'mpn' ] . ' - ' . $item[ 'manufacturer_name' ]; ?>
              </option>
              <?php } ?>
            </select>
          </label>

          <div class="between">
            <a href="<?php echo $cancel_button_href; ?>"><button class="inactive-button">
                <?php echo $workplace_customers_interactions_items_add_cancel_button_text; ?>
              </button></a>
            <button onMouseDown="File_Form('<?php echo $add_button_href; ?>')">
              <?php echo $workplace_customers_interactions_items_add_add_button_text; ?>
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

  $('#items').keyup(function () {
    Search();
  });

  function Search() {
    $.ajax({
      url: 'index.php?route=workplace/customers/interactions/items/add/Search',
      type: 'POST',
      dataType: 'json',
      data: 'search=' + $('#items').val(),
      success: function (json) {
        $('#item_guid').html('')
        if (json['return_code']) {
          if (json['items']) {
            json['items'].forEach((item) => {
              $('#item_guid').append('<option id="' + item['guid'] + '" value="' + item['guid'] + '">' + item['mpn'] + ' - ' + item['manufacturer_name'] + '</option>');
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