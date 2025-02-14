<?php echo $common_header; ?>
<div id="content-section">

  <h1><?php echo $company_shipping_header; ?></h1>

  <?php if ( count( $forwarders ) === 0 ) { ?>

    <div class="info-content-block">
      <div class="info-text">
        <?php echo  $company_shipping_no_methods_text; ?>
      </div>
    </div>

  <?php } else { ?>

    <div class="info-content-block">
      <div class="info-text">
        <?php echo $company_shipping_main_text; ?>

    </div>

    <?php foreach ( $forwarders as $forwarder ) { ?>
    <div id="<?php echo $forwarder[ 'id' ]; ?>" class="info-content-block shipping__type">
      <h2><?php echo $forwarder[ 'name' ]; ?></h2>
      <div class="info-content-text shipping__type-value">
        <img class="shipping__type-img" src="<?php echo $forwarder[ 'image_data' ]; ?>" title="<?php echo $forwarder[ 'name' ]; ?>"/>
        <div>
          <div class="info-text"><?php echo $forwarder[ 'description' ]; ?></div>
          <div class="shipping__type-methods">
            <?php foreach ( $forwarder[ 'methods' ] as $method ) { ?>
            <span><?php echo $method[ 'name' ]; ?></span>
            <?php } ?>
          </div>
        </div>

      </div>
    </div>
    <?php } ?>
    </div>
  <?php } ?>

</div>
<?php echo $common_footer; ?>
<script type="text/javascript">

  document.addEventListener('click', function (event) {
    let ship_type = event.target;
    if (ship_type.closest(".shipping__type")) {
      let el = ship_type.closest(".shipping__type");
      let shipping_id = $(el).attr('id');
      let ships = $(".shipping__type");
      for (let i = 0; i < ships.length; i++) {
        ships[i].className = ships[i].className.replace("active", "");
      }
      el.className += " " + "active";
      $.ajax({
        url: 'index.php?route=cart/show/set_delivery_method',
        type: 'POST',
        dataType: 'json',
        data: { id: shipping_id },

        success: function (json) {
          console.log(json['error']);
        },
        error: function (jqXHR, exception, json) {
          console.log(json['error']);
        }

      });
    }
  });

</script>