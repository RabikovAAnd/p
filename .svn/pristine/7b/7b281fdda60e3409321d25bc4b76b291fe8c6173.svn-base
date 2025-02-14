<?php echo $common_header; ?>

<div id="content">
  <h1><?php echo $workplace_add_legal_entity_header; ?></h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="info-content-block">
        <div class="list">
          <div class="info-content-block list">
            <h2><?php echo $workplace_add_legal_entity_account_data_header; ?></h2>
            <label class="input-text-field">
              <span>
                <?php echo $workplace_add_legal_entity_account_email_label; ?>
              </span>
              <input type="email" id="email" name="email" autocomplete="additional-name" class="input-send"
                title="<?php echo $workplace_add_legal_entity_account_email_hint; ?>"
                placeholder="<?php echo $workplace_add_legal_entity_account_email_placeholder; ?>" min="3" max="96"
                required />

            </label>
          </div>

          <div class="info-content-block list">
            <h2>
              <?php echo $workplace_add_legal_entity_corporate_data_header; ?>
            </h2>

            <label class="input-text-field">
              <span>*
                <?php echo $workplace_add_legal_entity_corporate_data_company_name_label; ?>
              </span>
              <input type="text" id="company_name" name="company" autocomplete="organization" class="input-send"
                title="<?php echo $workplace_add_legal_entity_corporate_data_company_name_hint; ?>"
                placeholder="<?php echo $workplace_add_legal_entity_corporate_data_company_name_placeholder; ?>" />
            </label>
            <label class="input-text-field">
              <span>
                <?php echo $workplace_add_legal_entity_corporate_data_short_company_name_label; ?>
              </span>
              <input type="text" id="short_company_name" class="input-send"
                title="<?php echo $workplace_add_legal_entity_corporate_data_short_company_name_hint; ?>"
                placeholder="<?php echo $workplace_add_legal_entity_corporate_data_short_company_name_placeholder; ?>" />
            </label>
            <label class="input-text-field">
              <span>*
                <?php echo $workplace_add_legal_entity_corporate_data_registration_country_label; ?>
              </span>
              <select type="text" id="registration_country" name="country" autocomplete="off" class="input-send"
                title="<?php echo $workplace_add_legal_entity_corporate_data_registration_country_hint; ?>" />
              <option value="">
                <?php echo $workplace_add_legal_entity_corporate_data_registration_country_placeholder; ?>
              </option>
              <?php foreach ( $countries as $country ) { ?>
              <option value="<?php echo $country[ 'iso_code_2' ]; ?>">
                <?php echo $country[ 'iso_code_2' ] . " - ". $country[ 'name' ]; ?>
              </option>
              <?php } ?>
              </select>
            </label>

          </div>

          <div class="info-content-block list">
            <h2>
              <?php echo  $workplace_add_legal_entity_contact_person_data_header; ?>
            </h2>

            <label class="input-text-field">
              <span>
                <?php echo $workplace_add_legal_entity_contact_person_lastname_label; ?>
              </span>
              <input type="text" id="lastname" name="lastname" autocomplete="family-name"
                title="<?php echo $workplace_add_legal_entity_contact_person_lastname_hint; ?>"
                placeholder="<?php echo $workplace_add_legal_entity_contact_person_lastname_placeholder; ?>"
                class="cart_contact_table_input_name input-send" min="2" max="64" required />
            </label>
            <label class="input-text-field">
              <span>
                <?php echo $workplace_add_legal_entity_contact_person_firstname_label; ?>
              </span>
              <input type="text" id="firstname" name="firstname" autocomplete="given-name"
                title="<?php echo $workplace_add_legal_entity_contact_person_firstname_hint; ?>"
                placeholder="<?php echo  $workplace_add_legal_entity_contact_person_firstname_placeholder; ?>"
                class="cart_contact_table_input_name input-send" min="2" max="32" required />
            </label>
            <label class="input-text-field">
              <span>
                <?php echo  $workplace_add_legal_entity_contact_person_middlename_label; ?>
              </span>
              <input type="text" id="middlename" name="middlename" autocomplete="middle-name"
                title="<?php echo $workplace_add_legal_entity_contact_person_middlename_hint; ?>"
                placeholder="<?php echo  $workplace_add_legal_entity_contact_person_middlename_placeholder; ?>"
                class="cart_contact_table_input_name input-send" min="2" max="32" />
            </label>
          </div>

          <div class="info-content-block list">
            <h2>
              <?php echo $workplace_add_legal_entity_roles_header; ?>
            </h2>

            <label class="checkbox-field">
              <input type="checkbox" class="input-send" id="consumer_role"
                title="<?php echo $workplace_add_legal_entity_checkbox_hint; ?>" name="consumer_role" />
              <span>
                <?php echo $workplace_add_legal_entity_consumer_checkbox_text; ?>
              </span>
            </label>
            <label class="checkbox-field">
              <input type="checkbox" class="input-send" id="manufacturer_role"
                title="<?php echo $workplace_add_legal_entity_checkbox_hint; ?>" name="manufacturer_role" />
              <span>
                <?php echo $workplace_add_legal_entity_manufacturer_checkbox_text; ?>
              </span>
            </label>
            <label class="checkbox-field">
              <input type="checkbox" class="input-send" id="supplier_role"
                title="<?php echo $workplace_add_legal_entity_entity_checkbox_hint; ?>" name="supplier_role" />
              <span>
                <?php echo $workplace_add_legal_entity_supplier_checkbox_text; ?>
              </span>
            </label>
          </div>
          <div class="end">
            <button title="<?php echo $workplace_add_legal_entity_create_button_hint; ?>"
              onMouseDown="File_Form('<?php echo $workplace_add_legal_entity_create_button_href; ?>')">
              <?php echo $workplace_add_legal_entity_create_button_text; ?>
            </button>
          </div>
        </div>
        <span class="error-alert"></span>
      </div>
    </div>

  </div>
</div>
<?php echo $common_footer; ?>