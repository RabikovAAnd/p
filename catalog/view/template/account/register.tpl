<?php echo $common_header; ?>

<h1>
  <?php echo  $account_register_header; ?>
</h1>
<div id="content" class="info-content-block list">
  <?php echo  $account_register_main_text; ?>
  <div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="list">

      <div class="info-content-block">
        <h2>
          <?php echo  $account_register_account_data_header; ?>
        </h2>
        <label id="checkbox_legal_entity" class="checkbox-field">
          <input type="checkbox" class="input-send" id="legal_entity"
            title="<?php echo  $account_register_entity_checkbox_hint; ?>" name="legal_entity">
          <span>
            <?php echo  $account_register_entity_checkbox_text; ?>
          </span>
        </label>
        <div class="content">


          <label class="input-text-field">
            <span>*
              <?php echo  $account_register_personal_data_email_label; ?>
            </span>
            <input type="email" id="email" name="email" autocomplete="additional-name" class="input-send"
              title="<?php echo  $account_register_personal_data_email_hint; ?>"
              placeholder="<?php echo  $account_register_personal_data_email_placeholder; ?>" min="3" max="96"
              required />
          </label>
          <label class="input-text-field">
            <span>*
              <?php echo  $account_register_password_data_password_label; ?>
            </span>
            <input type="password" id="password" autocomplete="new-password" name="password" class="input-send"
              title="<?php echo  $account_register_password_data_password_hint; ?>" min="4" max="20" required />
          </label>
          <label class="input-text-field">
            <span>*
              <?php echo  $account_register_password_data_confirm_password_label; ?>
            </span>
            <input type="password" id="confirm" name="confirm" class="input-send"
              title="<?php echo  $account_register_password_data_confirm_password_hint; ?>" min="4" max="20" required />
          </label>


        </div>


      </div>


      <div class="company_info info-content-block" style="display: none">
        <h2 class='company_info' style="display: none">
          <?php echo  $account_register_company_data_header; ?>
        </h2>
        <div class="content ">
          <label class="input-text-field">
            <span>
              <?php echo  $account_register_company_data_company_name_label; ?>
            </span>
            <input type="text" id="company_name" name="company" autocomplete="organization" class="input-send"
              title="<?php echo  $account_register_company_data_company_name_hint; ?>"
              placeholder="<?php echo $account_register_company_data_company_name_placeholder; ?>" />
          </label>
          <label class="input-text-field">
            <span>*
              <?php echo  $account_register_company_data_company_register_id_label; ?>
            </span>
            <input type="text" id="company_register_id" name="company_register_id"
              title="<?php echo  $account_register_company_data_company_register_id_hint; ?>" class="input-send"
              required />
          </label>
          <label class="input-text-field">
            <span>*
              <?php echo  $account_register_company_data_company_tax_id_label; ?>
            </span>
            <input type="text" id="company_tax_id" name="company_tax_id"
              title="<?php echo  $account_register_company_data_company_tax_id_hint; ?>" class="input-send" required />
          </label>
        </div>

      </div>
      <div class="info-content-block">
        <h2>
          <?php echo  $account_register_personal_data_header; ?>
        </h2>
        <div class="content">
          <label class="input-text-field">
            <span>*
              <?php echo  $account_register_personal_data_lastname_label; ?>
            </span>
            <input type="text" id="lastname" name="lastname" autocomplete="family-name"
              title="<?php echo  $account_register_personal_data_lastname_hint; ?>"
              placeholder="<?php echo  $account_register_personal_data_lastname_placeholder; ?>"
              class="cart_contact_table_input_name input-send" min="2" max="32" required>
          </label>
          <label class="input-text-field">
            <span>*
              <?php echo  $account_register_personal_data_firstname_label; ?>
            </span>
            <input type="text" id="firstname" name="firstname" autocomplete="given-name"
              title="<?php echo  $account_register_personal_data_firstname_hint; ?>"
              placeholder="<?php echo  $account_register_personal_data_firstname_placeholder; ?>"
              class="cart_contact_table_input_name input-send" min="2" max="32" required>
          </label>
          <label class="input-text-field">
            <span>
              <?php echo  $account_register_personal_data_middlename_label; ?>
            </span>
            <input type="text" id="middlename" name="middlename" autocomplete="email"
              title="<?php echo  $account_register_personal_data_middlename_hint; ?>"
              placeholder="<?php echo  $account_register_personal_data_middlename_placeholder; ?>"
              class="cart_contact_table_input_name input-send" min="2" max="32">
          </label>
          <label class="input-text-field">
            <span>
              <?php echo  $account_register_personal_data_telephone_label; ?>
            </span>
            <input type="tel" id="telephone" name="telephone" autocomplete="tel" class="input-send"
              title="<?php echo  $account_register_personal_data_telephone_hint; ?>" placeholder="+XXX (XXX) XX-XX-XX"
              min="2" max="32" pattern="/[0-9+-()]/v" />
          </label>

        </div>
      </div>

      <div class="info-content-block list">
        <h2>
          <?php echo  $account_register_newsletter_header; ?>
        </h2>
        <label class="checkbox-field">
          <input type="checkbox" id="newsletter" name="newsletter"
            title="<?php echo  $account_register_newsletter_hint; ?>" class="input-send" checked="checked" />
          <span>
            <?php echo  $account_register_newsletter_checkbox_text; ?>
          </span>
        </label>

      </div>

      <div class="terms-and-conditions">
        <div>
          <label class="checkbox-field">
            <input type="checkbox" class="input-send" id="terms"
              title="<?php echo  $account_register_information_terms_of_use_hint; ?>" name="terms">
            <span>
              <?php echo  $account_register_agreement_information_data_text; ?>
              <a href="index.php?route=company/terms">
                <?php echo  $account_register_information_terms_of_use_text; ?>
              </a>
              <?php echo  $account_register_agreement_information_conjunction_data_text; ?>
              <a href="index.php?route=company/conditions">
                <?php echo  $account_register_information_conditions_text; ?>
              </a>
            </span>
          </label>
          <label class="checkbox-field">
            <input type="checkbox" id="privacy" name="privacy"
              title="<?php echo  $account_register_agreement_personal_data_hint; ?>" class="input-send">
            <span>
              <?php echo  $account_register_agreement_personal_data_text; ?>
              <a href="index.php?route=company/privacy">
                <?php echo  $account_register_agreement_personal_data_href_text; ?>
              </a>
            </span>
          </label>
        </div>
        <div id="submit-button">
          <button type="submit" title="<?php echo  $account_register_register_button_hint; ?>"
            onMouseDown="Form_Alert('index.php?route=account/register/create', '?route=account/register_success')">
            <?php echo $account_register_register_button_text; ?>
          </button>
        </div>
      </div>

    </form>
    <span class="error-alert"></span>
  </div>


</div>
<script type="text/javascript">

  $('#legal_entity').on('change', function (event) {
    if ($('#legal_entity').is(':checked')) {
      $('.company_info').show()
    } else {
      $('.company_info').hide()
    }
  });

</script>

<?php echo $common_footer; ?>