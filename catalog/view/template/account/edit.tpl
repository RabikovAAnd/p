<?php echo $common_header; ?>

<div id="content" >

  <h1 class="header-list__edit"><?php echo  $account_edit_edit_header; ?></h1>
  <div class="account-area">
    <?php echo $account_menu; ?>

<div class="list">
  <div class="info-content-block">
    <h2><?php echo  $account_edit_account_data_header; ?></h2>
    <?php echo  $account_edit_full_name_text;?>: <?php echo $customer_data['lastname']; ?> <?php echo $customer_data['firstname']; ?> <?php echo $customer_data['middlename']; ?>
    <br><?php echo  $account_edit_email_text;?>: <?php echo $customer_data['email']; ?>
    <br><?php echo  $account_edit_date_creation_text;?>: <?php echo $customer_data['date_added']; ?>
    <br><?php echo  $account_edit_registration_country_text;?>: <?php echo $customer_country['description']; ?>
    <br><?php echo  $account_edit_id_text;?>: <?php echo $customer_data['contact_id']; ?>
    <br><?php echo  $account_edit_account_type_text;?>:
    <?php if ($customer_data['legal_entity'] === '1') { ?>
      <?php echo  $account_edit_legal_entity_text;?>
    <?php } else { ?>
      <?php echo  $account_edit_individual_text;?>
    <?php } ?>
  </div>

  <?php if ($customer_data['legal_entity'] === '1') { ?>
  <div class="info-content-block">
    <h2><?php echo  $account_edit_company_data_header; ?></h2>

  <div class="content company_info ">
    <label class="input-text-field">
      <span><?php echo  $account_edit_company_data_company_name_label; ?></span>
      <input type="text"
             id="company_name"
             name="company"
             class="input-send"
             title="<?php echo  $account_edit_company_data_company_name_hint; ?>"
             placeholder="<?php echo $account_edit_company_data_company_name_placeholder; ?>"
             value="<?php echo $customer_data['company_name']; ?>" />
    </label>
    <label class="input-text-field">
      <span>*<?php echo  $account_edit_company_data_company_id_label; ?></span>
      <input type="text"
             id="company_register_id"
             name="company_id"
             value="<?php echo $customer_data['company_register_id']; ?>"
             title="<?php echo  $account_edit_company_data_company_id_hint; ?>"
             class="input-send"
             required />
    </label>
    <label class="input-text-field">
      <span>*<?php echo  $account_edit_company_data_tax_id_label; ?></span>
      <input type="text"
             id="company_tax_id"
             name="company_tax_id"
             value="<?php echo $customer_data['company_tax_id']; ?>"
             title="<?php echo  $account_edit_company_data_tax_id_hint; ?>"
             class="input-send"
             required />
    </label>
  </div>
  </div>
  <?php } ?>

  <div class="info-content-block">
    <h2><?php echo  $account_edit_personal_data_header; ?></h2>

    <div class="content">
    <label class="input-text-field">
      <span>*<?php echo  $account_edit_personal_data_lastname_label; ?></span>
      <input type="text"
             id="lastname"
             name="lastname"
             title="<?php echo $account_edit_lastname_hint;  ?>"
             placeholder="<?php echo  $account_edit_personal_data_lastname_placeholder; ?>"
             value="<?php echo $customer_data['lastname']; ?>"
             class="input-send"
             min="2" max="32"
             required>
    </label>
    <label class="input-text-field">
      <span>*<?php echo  $account_edit_personal_data_firstname_label; ?></span>
      <input type="text"
             id="firstname"
             name="firstname"
             title="<?php echo $account_edit_firstname_hint;  ?>"
             placeholder="<?php echo  $account_edit_personal_data_firstname_placeholder; ?>"
             value="<?php echo $customer_data['firstname']; ?>"
             class="input-send"
             min="2" max="32"
             required >
    </label>
    <label class="input-text-field">
      <span><?php echo  $account_edit_personal_data_middlename_label; ?></span>
      <input type="text"
             id="middlename"
             name="middlename"
             title="<?php echo $account_edit_middlename_hint;  ?>"
             placeholder="<?php echo  $account_edit_personal_data_middlename_placeholder; ?>"
             value="<?php echo $customer_data['middlename']; ?>"
             class=" input-send"
             min="2" max="32" >
    </label>

    <label class="input-text-field">
      <span><?php echo  $account_edit_personal_data_telephone_label; ?></span>
      <input type="tel"
             id="phone"
             name="phone"
             class="input-send"
             title="<?php echo $account_edit_telephone_hint;  ?>"
             placeholder="+XXX (XXX) XX-XX-XX"
             value="<?php echo $customer_data['phone']; ?>"
             min="2" max="32"
             pattern="/[0-9+-()]/v" />
    </label>

    </div>
    <div class="end">
 <button type="button" onMouseDown="File_Form('<?php echo $account_edit_save_button_href; ?>')"
             title="<?php echo  $account_edit_save_button_hint; ?>">
      <?php echo  $account_edit_save_button_text; ?>
    </button>
    </div>
   
    <span class="error-alert"></span>
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
    if($('#legal_entity').attr('name')==='1'){
      $('#legal_entity').prop('checked', true);
    }

  });

</script>