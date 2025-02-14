<?php echo $common_header; ?>

<div id="content">
  <h1>
    <?php echo $workplace_items_header; ?>
  </h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="list">
      <div class="info-content-block end">
        <a href="<?php echo $add_item_href; ?>">
          <button class="small-button" type="button">
            <?php echo $workplace_items_add_item_button_text; ?>
          </button>
        </a>
      </div>

      <div class="list info-content-block">
        <div id="search_field">

          <input id="search" title="<?php echo $workplace_items_search_input_hint; ?>"
            placeholder="<?php echo $workplace_items_search_input_placeholder; ?>" />
        </div>
        <div class="list">
          <div>
            <label class="checkbox-field">
              <input type="checkbox" id="id" title="<?php echo $workplace_items_id_input_hint; ?>" class="input-send" />
              <span>
                <?php echo $workplace_items_id_label; ?>
              </span>
            </label>

            <label class="checkbox-field">
              <input type="checkbox" id="mpn" title="<?php echo $workplace_items_mpn_input_hint; ?>" class="input-send"
                checked />
              <span>
                <?php echo $workplace_items_mpn_label; ?>
              </span>
            </label>

            <label class="checkbox-field">
              <input type="checkbox" id="description" title="<?php echo $workplace_items_description_input_hint; ?>"
                class="input-send" />
              <span>
                <?php echo $workplace_items_description_label; ?>
              </span>
            </label>
            <label class="checkbox-field">
              <input type="checkbox" id="manufacturer_find"
                title="<?php echo $workplace_items_manufacturer_find_input_hint; ?>" />
              <span>
                <?php echo $workplace_items_manufacturer_find_label; ?>
              </span>
            </label>
          </div>


          <label class="input-text-field" id="manufacturer_find_label" style="display: none">
            <?php echo $workplace_items_manufacturer_label; ?>

            <input type="text" id="manufacturer" title="<?php echo $workplace_items_manufacturer_input_hint; ?>"
              class="input-send" placeholder="<?php echo $workplace_items_manufacturer_input_placeholder; ?>" />

          </label>
        </div>
        <span id="found_count">
          <?php echo $workplace_items_found_count_text; ?>:
          <?php echo $item_count; ?>
        </span>

      </div>

      <div id="catalog" class="table-menu-style">
        <div class="items-table table-menu-header">
          <span><b>
              <?php echo $workplace_items_table_id_text; ?>
            </b></span>
          <span><b>
              <?php echo $workplace_items_table_mpn_text; ?>
            </b></span>
          <span><b>
              <?php echo $workplace_items_table_manufacturer_name_text; ?>
            </b></span>
          <span><b>
              <?php echo $workplace_items_table_status_text; ?>
            </b></span>
        </div>
        <?php foreach ( $items as $item ){ ?>
        <div id="<?php echo $item['guid']; ?>" class="items-table table-menu-element">
          <span>
            <?php echo $item[ 'id' ]; ?>
          </span>
          <span><a href="<?php echo $item[ 'item_href' ]; ?>">
              <?php echo $item[ 'mpn' ]; ?>
            </a></span>
          <span>
            <?php echo $item[ 'manufacturer_name' ]; ?>
          </span>
          <span>
            <?php echo $item[ 'status' ]; ?>
          </span>

        </div>
        <?php } ?>

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
      url: 'index.php?route=workplace/items/list/Search',
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
          $('#catalog').html('')
          if (json['items']) {
            if (json['items'].length > 0) {
              $('#catalog').append("<div class='items-table table-menu-header'>"
                + "<span><b>" + "<?php echo $workplace_projects_projects_table_number_text; ?>" + "</b></span>"
                + "<span><b>" + "<?php echo $workplace_projects_projects_table_name_text; ?>" + "</b></span>"
                + "<span><b>" + "<?php echo $workplace_projects_projects_table_status_text; ?>" + "</b></span>"
                + "<span><b>" + "<?php echo $workplace_projects_projects_table_status_text; ?>" + "</b></span>"
                + "</div>"
              )
            }
          }
        }

        page_count = json['page_count'];
        $('#found_count').html('<?php echo $workplace_items_found_count_text; ?>: ' + json['item_count']);

        if (json['return_code']) {

          if (json['items']) {

            json['items'].forEach((item) => {
              $('#catalog').append(
                "<div id='" + item['guid'] + "' class='items-table table-menu-element'>"
                + "<span>" + item['id'] + "</span>"
                + "<span><a href='" + item['item_href'] + "'>" + item['mpn'] + "</a></span>"
                + "<span>" + item['manufacturer_name'] + "</span>"
                + "<span>" + item['status'] + "</span>"
                + "</div>")

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