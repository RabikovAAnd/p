<?php echo $common_header; ?>

<div id="content">
  <h1><?php echo $workplace_customers_header; ?></h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div  class="list">

      <div class="info-content-block end">
        <a href="<?php echo $customers_add_individual_link; ?>">
          <button class="small-button" type="button"><?php echo $workplace_customers_add_individual_button_text; ?></button>
        </a>
        <a  href="<?php echo $customers_add_legal_entity_link; ?>">
          <button class="small-button" type="button"><?php echo $workplace_customers_add_legal_entity_button_text; ?></button>
        </a>
      </div>

      <div class="list  info-content-block" id="search_field">
        <input id="search"
               title="<?php echo $workplace_customers_search_input_hint; ?>"
               placeholder="<?php echo $workplace_customers_search_input_placeholder; ?>"/>

        <div>
          <label class="checkbox-field">
            <input type="checkbox"
                   id="manufacturer"
                   title="<?php echo $workplace_customers_manufacturer_input_hint; ?>"
                   class="input-send" checked/>
            <span><?php echo $workplace_customers_manufacturer_label; ?></span>
          </label>
          <label class="checkbox-field">
            <input type="checkbox"
                   id="firstname"
                   title="<?php echo $workplace_customers_firstname_input_hint; ?>"
                   class="input-send"/>
            <span><?php echo $workplace_customers_firstname_label; ?></span>
          </label>
          <label class="checkbox-field">
            <input type="checkbox"
                   id="lastname"
                   title="<?php echo $workplace_customers_lastname_input_hint; ?>"
                   class="input-send"/>
            <span><?php echo $workplace_customers_lastname_label; ?></span>
          </label>
        </div>
        <span id="found_count"><?php echo $workplace_customers_found_count_text; ?>: <?php echo $customer_count; ?></span>
      </div>

      <div id="catalog" class="table-menu-style">
        <div class="customers-table table-menu-header">
          <span><b>
              <?php echo $workplace_customers_table_id_text; ?>
            </b></span>
          <span><b>
              <?php echo $workplace_customers_table_name_text; ?>
            </b></span>
            <span><b>
                <?php echo $workplace_customers_table_registration_country_text; ?>
              </b></span>
              <span><b>
                  <?php echo $workplace_customers_table_contact_person_text; ?>
                </b></span>
              <span><b>
                  <?php echo $workplace_customers_table_status_text; ?>
                </b></span>
        </div>
        <?php foreach ( $customers as $customer ){ ?>
        <div  id="<?php echo $customer['guid']; ?>" class="customers-table table-menu-element">
          <span>
            <?php echo $customer[ 'id' ]; ?>
          </span>
          <span>
            <a href="<?php echo $customer[ 'href' ]; ?>">
            <?php echo $customer[ 'company_name' ]; ?>
          </a>
          </span>
          <span>
            <?php echo $customer[ 'registration_country' ]; ?>
          </span>
            <span>
              <a id="<?php echo $customer[ 'guid' ]; ?>" href="<?php echo $customer[ 'href' ]; ?>">
                <?php echo $customer[ 'lastname' ]; ?> <?php echo $customer[ 'name' ]; ?>
              </a>
              </span>
          <span>
            <?php echo $customer[ 'status' ]; ?>
          </span>
        </div>
        <?php } ?>

      </div>
      <!-- <div>
        <div id="catalog" class="list info-content-block">
          <?php foreach ($customers as $customer){ ?>
            <a id="<?php echo $customer[ 'guid' ]; ?>" href="<?php echo $customer[ 'href' ]; ?>" class="info-content-block">
              <?php echo $customer['company_name']; ?><br><?php echo $customer[ 'lastname' ]; ?> <?php echo $customer[ 'name' ]; ?>
            </a>
          <?php } ?>
        </div>
      </div> -->
    </div>
  </div>
</div>
<?php echo $common_footer; ?>

<script>
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

  $('#firstname').click(function(){
    page = 1;
    Search(page);
  });

  $('#lastname').click(function(){
    page = 1;
    Search(page);
  });

  $('#manufacturer').click(function () {
    page = 1;
    Search(page);
  });

  function Search(page = 1) {
    $.ajax({
      url: 'index.php?route=workplace/customers/list/search',
      type: 'POST',
      dataType: 'json',
      data: 'search=' + $('#search').val() +
        '&firstname=' + $('#firstname').is(':checked') +
        '&lastname=' + $('#lastname').is(':checked') +
        '&manufacturer=' + $('#manufacturer').is(':checked') +
        '&page=' + page,
      success: function (json) {
        scroll = false;
        if (page === 1) {
          $('#catalog').html('')
          if (json['customers']) {
            if (json['customers'].length > 0) {
              $('#catalog').append("<div class='customers-table table-menu-header'>"
                + "<span><b>" + "<?php echo $workplace_customers_table_id_text; ?>" + "</b></span>"
                + "<span><b>" + "<?php echo $workplace_customers_table_name_text; ?>" + "</b></span>"
                + "<span><b>" + "<?php echo $workplace_customers_table_registration_country_text; ?>" + "</b></span>"
                + "<span><b>" + "<?php echo $workplace_customers_table_contact_person_text; ?>" + "</b></span>"
                + "<span><b>" + "<?php echo $workplace_customers_table_status_text; ?>" + "</b></span>"
                + "</div>"
              )
            }
          }
        }
        page_count = json['page_count'];
        $('#found_count').html('<?php echo $workplace_customers_found_count_text; ?>: ' + json['customer_count']);
        if (json['return_code']) {

          if (json['customers']) {

            json['customers'].forEach((customer) => {
              $('#catalog').append(
                "<div id='" + customer['guid'] + "' class='customers-table table-menu-element'>"
                + "<span>" + customer['id'] + "</span>"
                + "<span><a href='" + customer['href'] + "'>"  + customer[ 'company_name' ]+ "</a></span>"
                + "<span>" + customer[ 'registration_country' ] + "</span>"
                + "<span><a href='" + customer['href'] + "'>" + customer[ 'lastname' ]+ " "+customer[ 'name' ]+ "</a></span>"
                + "<span>" + customer['status'] + "</span>"
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