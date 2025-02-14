<?php echo $common_header; ?>
<div id="content">
    <h1 class="header-list__edit"><?php echo  $account_newsletter_newsletter_header; ?></h1>
    <div class="account-area">
        <?php echo $account_menu; ?>
        <div class="info-content-block">
            <div class="content newsletter list">
                <label class="checkbox-field">
                    <input type="checkbox"
                           id="newsletter"
                           title="<?php echo $account_newsletter_newsletter_input_hint; ?>"
                           name="<?php echo $customer_data['newsletter']; ?>"
                           class="input-send"/>
                    <span><?php echo  $account_newsletter_newsletter_checkbox_text; ?></span>
                </label>
                <button type="button"
                        title="<?php echo $account_newsletter_save_button_hint; ?>"
                        onMouseDown="File_Form('index.php?route=account/newsletter/Edit_Newsletter')">
                    <?php echo $account_newsletter_save_button_text; ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $common_footer; ?>

<script type="text/javascript">
  $( document ).ready(function() {
    if($('#newsletter').attr('name')==='1'){
      $('#newsletter').prop('checked', true);
    }
  });
</script>