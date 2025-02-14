<?php echo $common_header; ?>


<div>

  <h1><?php echo $account_forgotten_header; ?> </h1>

  <div class="info-content-block">
    <div class="info-text"><?php echo $account_forgotten_email_text; ?></div>
    <form>
      <label>
        <input type="email"
             id='email'
             class="input-send"
             placeholder = "<?php echo $account_forgotten_email_input_placeholder; ?>"
             title="<?php echo $account_forgotten_email_input_hint; ?>"
             autocomplete="off" />
      </label>
      <button type="button"
            title="<?php echo $account_forgotten_continue_button_hint; ?>"
            onMouseDown="File_Form('<?php echo $send_link_button_href; ?>')">
        <?php echo $account_forgotten_email_input_button; ?>
      </button>
    </form>
    <span class="error-alert"></span>
  </div>

</div>

<?php echo $common_footer; ?>

<script>
/*
  $('input').on('change', function () {
    if($('input').val() === ''){
      $('button').addClass("inactive-button")
    }else{
      $('button').removeClass("inactive-button")
    }
  })
*/
</script>