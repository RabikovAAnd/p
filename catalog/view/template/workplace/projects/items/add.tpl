<?php echo $common_header; ?>

<div id="content">
  <h1><?php echo $workplace_add_item_header; ?></h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="info-content-block">

        <div class="list">

          <div class="list">
            <div>
              <label class="checkbox-field">
                <input type="checkbox" id="id" title="<?php echo $workplace_add_item_id_input_hint; ?>"
                  class="input-send" />
                <span>
                  <?php echo $workplace_add_item_id_label; ?>
                </span>
              </label>

              <label class="checkbox-field">
                <input type="checkbox" id="mpn" title="<?php echo $workplace_add_item_mpn_input_hint; ?>"
                  class="input-send" checked />
                <span>
                  <?php echo $workplace_add_item_mpn_label; ?>
                </span>
              </label>

              <label class="checkbox-field">
                <input type="checkbox" id="description"
                  title="<?php echo $workplace_add_item_description_input_hint; ?>" class="input-send" />
                <span>
                  <?php echo $workplace_add_item_description_label; ?>
                </span>
              </label>
              <label class="checkbox-field">
                <input type="checkbox" id="manufacturer_find"
                  title="<?php echo $workplace_add_item_manufacturer_find_input_hint; ?>" />
                <span>
                  <?php echo $workplace_add_item_manufacturer_find_label; ?>
                </span>
              </label>
            </div>

            <label class="input-text-field" id="manufacturer_find_label" style="display: none">
              <?php echo $workplace_add_item_manufacturer_label; ?>
              <input type="text" id="manufacturer" title="<?php echo $workplace_add_item_manufacturer_input_hint; ?>"
                class="input-send" placeholder="<?php echo $workplace_add_item_manufacturer_input_placeholder; ?>" />
            </label>
          </div>
          <span id="found_count">
            <?php echo $workplace_add_item_found_count_text; ?>:
            <?php echo $item_count; ?>
          </span>
          <label class="input-text-field" id="search_field">

            <input id="search" list="item_guid" title="<?php echo $workplace_add_item_search_input_hint; ?>"
              placeholder="<?php echo $workplace_add_item_search_input_placeholder; ?>" />
            <select class="input-send" size="10" id="item_guid">
              <?php foreach ($items as $item) { ?>
              <option value="<?php echo $item['guid']; ?>">
                <?php echo $item['mpn']; ?> -
                <?php echo $item['manufacturer_name']; ?>

              </option>
              <?php }?>
            </select>
          </label>
          <div class="between">
            <a href="<?php echo $cancel_button_href; ?>"><button type="button">
                <?php echo $workplace_add_item_cancel_button_text; ?>
              </button></a>
            <button
              onMouseDown="File_Form('<?php echo $workplace_add_item_button_href; ?>',[['guid','<?php echo $project_guid; ?>']])">
              <?php echo $workplace_add_item_add_item_to_project_button_text; ?>
            </button>
          </div>
        </div>
        <span class="error-alert"></span>
      </div>
    </div>


  </div>
</div>
<?php echo $common_footer; ?>
</div>

<script>


  $('#manufacturer_find').on('change', function (event) {
    if ($('#manufacturer_find').is(':checked')) {
      $('#manufacturer_find_label').show()
      console.log('show')
    } else {
      $('#manufacturer_find_label').hide()
      console.log('hide')
    }
  });

  let page = 1;
  let scroll = false;
  let page_count = "<?php echo $page_count; ?>";
  $(window).scroll(function () {
    if (($(this).scrollTop() >= ($('#catalog').height() - $(window).height() * 0.5)) && (page_count > page) && !scroll) {
      scroll = true;
      ++page;
      Search(page);
    }
  })
  $('#search').keyup(function () {
    page = 1;
    Search(page);
  });
  $('#id').click(function () {
    page = 1;
    Search(page);
  });
  $('#mpn').click(function () {
    page = 1;
    Search(page);
  });
  $('#description').click(function () {
    page = 1;
    Search(page);
  });

  $('#manufacturer').keyup(function () {
    page = 1;
    Search(page);
  });


  function Search(page = 1) {
    $.ajax({
      url: 'index.php?route=workplace/projects/items/add/Search',
      type: 'POST',
      dataType: 'json',
      data: 'search=' + $('#search').val() +
        '&id=' + $('#id').is(':checked') +
        '&mpn=' + $('#mpn').is(':checked') +
        '&description=' + $('#description').is(':checked') +
        '&manufacturer=' + $('#manufacturer').val() +
        '&page=' + page,
      success: function (json) {
        scroll = false;
        if (page === 1) {
          $('#item_guid').html('')
        }
        page_count = json['page_count'];
        $('#found_count').html('<?php echo $workplace_add_item_found_count_text; ?>: ' + json['item_count']);
        if (json['return_code']) {

          if (json['items']) {

            json['items'].forEach((item) => {
              $('#item_guid').append('<option value="' + item['guid'] + '" class="address-block">' +

                item['mpn'] + ' - ' + item['manufacturer_name'] +

                '</option>')
            });
          }
        }
      },
      error: function (jqXHR, exception, json) {
        console.log('error ' + exception + ' ' + json['error']);
      }

    });
  }

</script>