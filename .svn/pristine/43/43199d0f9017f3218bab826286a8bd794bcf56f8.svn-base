<?php echo $common_header; ?>

<div id="content">

  <h1>
    <?php echo $account_address_list_address_list_header; ?>
  </h1>

  <div class="account-area">
    <?php echo $account_menu; ?>
    <div class="info-content-block list">
      <?php if ($addresses) { ?>
      <?php foreach ($addresses as $address){ ?>
      <a href="<?php echo $address[ 'address_href' ]; ?>" class="info-content-block">
        <div id="<?php echo $address['guid']; ?>" class="address-block__address">

          <span class="address-block__detail-address">
            <?php echo $address['street']; ?>
            <?php echo $address['house']; ?>
            <?php if($address['building'] != '') {echo ', ' . $address['building'];} ?>
            <?php if($address['apartment'] != '') {echo ', ' . $address['apartment'];} ?>
          </span>
          <span class="address-block__global-address">
            <?php echo $address['postcode']; ?>,
            <?php echo $address['city']; ?>
          </span>
          <span class="address-block__global-address">
            <?php echo $address['country_name']; ?>,
            <?php echo $address['zone_name']; ?>
          </span>
        </div>

      </a>
      <?php }?>
      <?php } else { ?>
      <div>
        <?php echo $account_address_list_empty_address_list_text; ?>
      </div>
      <?php } ?>
      <a href="<?php echo $address_form_href; ?>" class="end">
        <button type="button" title="<?php echo $account_address_list_add_address_button_hint; ?>">
          <?php echo $account_address_list_add_address_button_text; ?>
        </button>
      </a>

    </div>
  </div>

</div>
<?php echo $common_footer; ?>

<script type="text/javascript">
  /*
    function addAddress(){
      $.ajax({
        url: 'index.php?route=account/address/insert',
        type: 'post',
        dataType: 'json',
        beforeSend: function () {
        },
        success: function (json) {
          console.log(json['return_code']);
        },
        error: function (json) {
          console.log(json['return_code']);
        }
      });
    }
  
  $('.address-block__new-address-btn').bind('click', function () {
    $('.address').hide()
    $('.address-form').show()
  })
  $('.save-changes').bind('click', function () {
    $('.address-form').hide()
    $('.address').show()
  })
  $('.cancel').bind('click', function () {
    $('.address-form').hide()
    $('.address').show()
  })
  */
</script>