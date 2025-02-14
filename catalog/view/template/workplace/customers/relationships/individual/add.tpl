<?php echo $common_header; ?>

<div id="content">
  <h1><?php echo $workplace_customers_relationships_individual_add_header; ?></h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="info-content-block">

        <div class="list">

          <div class="list">
            
          <label class="input-text-field" id="search_field">

            <input id="search" list="customer_guid_list" title="<?php echo $workplace_customers_relationships_individual_add_search_input_hint; ?>"
              placeholder="<?php echo $workplace_customers_relationships_individual_add_search_input_placeholder; ?>" />

            <select class="input-send" size="10" id="customer_guid">
              <?php foreach ($customers as $customer) { ?>
              <option value="<?php echo $customer['guid']; ?>">
                <?php echo $customer['lastname']; ?> <?php echo $customer['firstname']; ?> <?php echo $customer['middlename']; ?>
              </option>
              <?php }?>
            </select>
          </label>
          <div class="between">
            <a href="<?php echo $cancel_button_href; ?>"><button type="button">
                <?php echo $workplace_customers_relationships_individual_add_cancel_button_text; ?>
              </button></a>
            <button
              onMouseDown="File_Form('<?php echo $add_customer_button_href; ?>')">
              <?php echo $workplace_customers_relationships_individual_add_add_button_text; ?>
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

  $('#search').keyup(function () {

    Search();
  });
 


  function Search() {
    $.ajax({
      url: 'index.php?route=workplace/customers/relationships/individual/add/Search',
      type: 'POST',
      dataType: 'json',
      data:  'search=' + $('#search').val(),
      success: function (json) {
        scroll = false;
   
        $('#customer_guid').html('')
        if (json['return_code']) {

          if (json['customers']) {

            json['customers'].forEach((customer) => {
              $('#customer_guid').append('<option value="' + customer['guid'] + '" class="address-block">' +
                customer['lastname']+' ' +customer['firstname']+' ' +customer['middlename'] +
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