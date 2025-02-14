<?php echo $common_header; ?>
<div id="content">

  <h1><?php echo $company_contact_header; ?></h1>
  <div class="info-content-block ">
    <form class="contact-input-form list">

      <label class="input-text-field">
        <span><?php echo $company_contact_email_label; ?></span>
        <input
                type="email"
                id="email"
                class="input-send"
                placeholder="<?php echo $company_contact_email_input; ?>"
                title="<?php echo $company_contact_email_input_hint; ?>"
                required/>
      </label>

      <label class="input-text-field">
        <span><?php echo $company_contact_subject_label; ?></span>
        <input type="text"
               id="subject"
               class="input-send"
               placeholder="<?php echo $company_contact_subject_input; ?>"
               minlength="10"
               maxlength="50"
               title="<?php echo $company_contact_subject_input_hint; ?>"
               required
        />
      </label>

      <label class="input-text-field">
        <span><?php echo $company_contact_message_label; ?></span>
        <textarea
                id="message"
                class="input-send"
                rows="4"
                placeholder="<?php echo $company_contact_message_input; ?>"
                minlength="2"
                maxlength="255"
                title="<?php echo $company_contact_message_input_hint; ?>"
                required
        ></textarea>
      </label>
      <label class="contact__captcha">
        <span><?php echo $company_contact_captcha_label; ?></span>
        <div >
          <img id='captcha_image'>
          <img id="refresh" src="./catalog/view/company_files/refresh_mini.png">
          <input id='captcha'
                  name="captcha"
                 class="input-send"
                 placeholder="<?php echo $company_contact_captcha_placeholder; ?>"
                 minlength="1"
                 maxlength="4"
                 title="<?php echo $company_contact_captcha_input_hint; ?>"
                 required>
        </div>

      </label>
      <div class="send-message">
        <div>
          <label class="checkbox-field">
            <input id="agreement"
                   class="input-send"
                   type="checkbox"
                   required>
            <span><?php echo $company_contact_agreement_personal_data_text; ?>
              <a href="index.php?route=company/privacy"><?php echo $company_contact_agreement_personal_data_href_text; ?></a>
          </span>
          </label>
          <label class="checkbox-field">
            <input id="newsletter"
                   class="input-send"
                   type="checkbox">
            <span><?php echo $company_contact_email_alert_text; ?></span>
          </label>
        </div>
        <button type="button" id="send-message-button"
        onMouseDown="Form_Alert('index.php?route=company/contact/add', '?route=company/contact_confirm')" ><?php echo $company_contact_send_message_button; ?></button>
      </div>
    </form>
    <span class="error-alert"></span>
  </div>

</div>
<?php echo $common_footer; ?>

<script type="text/javascript">
  $(document).ready(function () {
    $.ajax({
      url: 'index.php?route=company/contact/captcha',
      type: 'get',
      dataType: 'json',
      success: function (json) {
        $("#captcha_image").attr("src",json['captcha']);
      }

    });
  });

  $('#refresh').bind('click', function () {

    $.ajax({
      url: 'index.php?route=company/contact/captcha',
      type: 'get',
      dataType: 'json',
      success: function (json) {
        $("#captcha_image").attr("src",json['captcha']);
      }

    });
  });

</script>