<?php echo $common_header; ?>
<div id="content">

  <h1><?php echo $company_contact_confirm_popup_header; ?></h1>
  <div class="info-content-block">
    <form class="code-form">
      
      <label>
        <span><?php echo $company_contact_confirm_popup_code_label; ?></span>
        <input id="code" class="input-send" type="text"/>
      </label>
      <div class="code-form__buttons">
        <button type="button" id="repeat-sending"><?php echo $company_contact_confirm_popup_code_resend; ?></button>
        <button type="button" id="confirm-sending" onMouseDown="Form_Alert('index.php?route=company/contact_confirm/Add_Message', '?route=company/contact_success')"><?php echo $company_contact_confirm_popup_confirm; ?></button>
      </div>

    </form>
    <span class="error-alert"></span>
  </div>

</div>

<script>
  let counter = 5;
  let popup = $('.code-form');
  let rep_send = $('#repeat-sending');
  let sub_send = $('#confirm-sending');
  let final_text = rep_send.text();
  let default_text = rep_send.text() + ': 5';


  function Resend_Message(url){
    console.log(url)
    $.ajax({
      url: url,
      type: 'post',
      dataType: 'json',
      success: function (json) {
        console.log(json['error'])
      },
      error: function (jqXHR, exception, json) {
      }

    });
  }

  function timer(){
    rep_send.unbind('click');
    let count_text = rep_send.text() + ': ';
    rep_send.text(default_text);
    rep_send.addClass("inactive-button");
    let timerId = setInterval(() => {
      counter--;
      rep_send.text(count_text + counter);
      if (counter < 1) {
        clearInterval(timerId);
        rep_send.removeClass("inactive-button");
        rep_send.text(final_text);
        counter = 5;
        rep_send.bind('click', function () {
          timer();
          Resend_Message('index.php?route=company/contact_confirm/Resend_Message');
        });
      }
    }, 1000);
  }
  $(document).ready(function () {
    timer();
  })



</script>
<?php echo $common_footer; ?>