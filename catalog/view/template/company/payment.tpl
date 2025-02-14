<?php echo $common_header; ?>
<div id="content-section">

  <h1><?php echo $company_payment_header; ?></h1>
  
  <?php if ( count( $payment_methods ) == 0 ) { ?>

    <div class="info-content-block">
      <div class="info-text">
        <?php echo  $company_payment_no_methods_text; ?>
      </div>
    </div>

  <?php } else { ?>

    <div class="info-content-block list">
      <div class="info-text">
        <?php echo  $company_payment_main_text; ?>

    </div>

    <?php foreach ( $payment_methods as $payment_method ) { ?>
    <div id="<?php echo $payment_method[ 'id' ]; ?>" class="info-content-block payment__type">
      <h2><?php echo $payment_method[ 'name' ]; ?></h2>
      <div class="info-content-text payment__type-value">
        <img class="payment__type-img" src="./image/default/no_image.jpg"
             title="<?php echo $payment_method[ 'name' ]; ?>"/>
        <div class="info-text"><?php echo $payment_method[ 'description' ]; ?></div>
      </div>
    </div>
    <?php } ?>
    </div>
  <?php } ?>

</div>
<?php echo $common_footer; ?>
<script>
  document.addEventListener('click', function (event) {
    let payment_type = event.target;
    if (payment_type.closest(".payment__type")) {
      let el = payment_type.closest(".payment__type");
      let ships = $(".payment__type");
      let payment_id = $(el).attr('id');
      for (let i = 0; i < ships.length; i++) {
        ships[i].className = ships[i].className.replace("active", "");
      }
      el.className += " " + "active";
      $.ajax({
        url: 'index.php?route=cart/show/set_payment_method',
        type: 'POST',
        dataType: 'json',
        data: { id: payment_id },

        success: function (json) {
          console.log(json['error'] );
        },
        error: function (jqXHR, exception, json) {
          console.log( 'error ' + exception + ' ' + json['error'] );
        }

      });
    }
  });
</script>