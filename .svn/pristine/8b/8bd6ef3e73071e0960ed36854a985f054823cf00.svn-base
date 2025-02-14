<?php echo $common_header; ?>

<div id="content">

  <h1><?php echo $workplace_items_subitems_alternatives_add_header . ' ' . $subitem_info['mpn']; ?></h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">

      <div class="list info-content-block">

        <label class="input-text-field">
          <?php echo $workplace_items_subitems_alternatives_add_alternative_item_label; ?>
          <input id="alternative_list" type="text" list="alternative_guid"
            title="<?php echo $workplace_add_alternative_guid_hint;  ?>"
            placeholder="<?php echo $workplace_add_alternative_guid_placeholder; ?>" required />

          <select id="alternative_guid" class="input-send" size="10">
            <?php foreach ($items as $item) { ?>
            <option id="<?php echo $item['guid']; ?>" value="<?php echo $item['guid']; ?>">
              <?php echo $item['mpn'] . ' - ' . $item['manufacturer_name']; ?>
            </option>
            <?php } ?>
          </select>

        </label>

        <div class="between">
          <a href="<?php echo $cancel_button_href; ?>"><button type="button">
              <?php echo $workplace_items_subitems_alternatives_add_cancel_button_text; ?>
            </button></a>
          <button
            onMouseDown="File_Form('<?php echo $add_button_href; ?>',[['subitem_index_guid','<?php echo $subitem_index_guid; ?>']])">
            <?php echo $workplace_items_subitems_alternatives_add_alternative_add_button_text; ?>
          </button>
        </div>

        <span class="error-alert"></span>
      </div>

    </div>

  </div>

</div>
<?php echo $common_footer; ?>

<script>

  $('#alternative_list').keyup(function () {
    Search();
  });

  function Search() {
    $.ajax({
      url: 'index.php?route=workplace/items/subitems/alternatives/add/Search',
      type: 'POST',
      dataType: 'json',
      data: 'search=' + $('#alternative_list').val(),
      success: function (json) {

        $('#alternative_guid').html('')
        if (json['return_code']) {

          if (json['items']) {

            json['items'].forEach((item) => {
              $('#alternative_guid').append('<option id="' + item['guid'] + '" value="' + item['guid'] + '">' + item['mpn'] + ' - ' + item['manufacturer_name'] + '</option>');
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