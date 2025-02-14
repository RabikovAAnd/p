<div class="header-container unselectable-text-element">

  <a class="header-logo-link" href="<?php echo $logo_href; ?>">ANVILEX</a>
  <div class="header-buttons">
      <a class="header-button header-language-button"
         href="<?php echo $header_header_language_button_href; ?>"
         title="<?php echo $header_header_language_button_hint; ?>" >
          <img class="header-icon" src="./catalog/view/company_files/language.png">
          <span class="header-icon-count" ><?php echo $header_header_language_button_text; ?></span>
      </a>
      <a class="header-button  header-location-button"
         href="<?php echo $header_header_location_button_href; ?>"
         title="<?php echo $header_header_location_button_hint; ?>">
          <img class="header-icon" src="./catalog/view/company_files/countries.png">
          <span class="header-icon-count" ><?php echo $header_header_location_button_text;?></span>
        </a>
      <a class="header-button header-cart-button"
         href="<?php echo $header_header_cart_button_href; ?>"
         title="<?php echo $header_header_cart_button_hint; ?>" >
          <img class="header-icon" src="./catalog/view/company_files/cart.png">
          <span id="cart-icon-count" class="header-icon-count" ><?php echo $header_header_cart_button_text;?></span>
      </a>
      <a class="header-account-button header-button  header-login-button" href="<?php echo $header_header_account_button_href; ?>" title="<?php echo $header_header_account_button_hint; ?>"><?php echo $header_header_account_button_text; ?></a>
      <?php if ( $header_header_workplace_button_enabled == true ) { ?>
      <a class="header-account-button header-button header-workplace-button" href="<?php echo $header_header_workplace_button_href; ?>" title="<?php echo $header_header_workplace_button_hint; ?>"><?php echo  $header_header_workplace_button_text; ?></a>
      <?php } ?>
      <?php if ( $header_header_logout_button_enabled == true ) { ?>
      <a class="header-account-button header-button header-exit-button" href="<?php echo $header_header_logout_button_href; ?>" title="<?php echo $header_header_logout_button_hint; ?>"><?php echo $header_header_logout_button_text; ?></a>
      <?php } ?>

  </div>

</div>

<div class="second-header unselectable-text-element">
  <a class="second-header-button" href="<?php echo $header_header_home_button_href; ?>" title="<?php echo $header_header_home_button_hint; ?>"><?php echo $header_header_home_button_text; ?></a>
  <a class="second-header-button" href="<?php echo $header_header_about_button_href; ?>" title="<?php echo $header_header_about_button_hint; ?>"><?php echo $header_header_about_button_text; ?></a>
  <a class="second-header-button" href="<?php echo $header_header_contact_button_href; ?>" title="<?php echo $header_header_contact_button_hint; ?>"><?php echo $header_header_contact_button_text; ?></a>
  <a class="second-header-button" href="<?php echo $header_header_careers_button_href; ?>" title="<?php echo $header_header_careers_button_hint; ?>"><?php echo $header_header_careers_button_text; ?></a>
  <a class="second-header-button" href="<?php echo $header_header_catalog_button_href; ?>" title="<?php echo $header_header_catalog_button_hint; ?>"><?php echo $header_header_catalog_button_text; ?></a>
</div>

<script>
  $(document).ready(function() {
    let links = $('.second-header').find('a');
    for (let link of links){
      if($(link).attr('href') === window.location.href){
        $(link).addClass('active-button')
      }
    }
  });
</script>