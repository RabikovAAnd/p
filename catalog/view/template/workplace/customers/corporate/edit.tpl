<?php echo $common_header; ?>

<div id="content">
  <h1><?php echo $workplace_customers_edit_corporate_header; ?></h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="info-content-block">
      
        <div class="list">
        <div class="info-content-block list">
          <h2><?php echo $workplace_customers_edit_corporate_corporate_data_header; ?></h2>
                    
            <label class="input-text-field">
              <span>*<?php echo $workplace_customers_edit_corporate_corporate_data_company_name_label; ?></span>
              <input type="text"
                     id="company_name"
                     name="company"
                     autocomplete="organization"
                     class="input-send"
                     title="<?php echo $workplace_customers_edit_corporate_corporate_data_company_name_hint; ?>"
                     placeholder="<?php echo $workplace_customers_edit_corporate_corporate_data_company_name_placeholder; ?>"
                     value="<?php echo $customer['company_name']; ?>"/>
            </label>
            <label class="input-text-field">
              <span>
                <?php echo $workplace_customers_edit_corporate_corporate_data_short_company_name_label; ?>
              </span>
              <input type="text" id="short_company_name" class="input-send"
                title="<?php echo $workplace_customers_edit_corporate_corporate_data_short_company_name_hint; ?>"
                placeholder="<?php echo $workplace_customers_edit_corporate_corporate_data_short_company_name_placeholder; ?>" 
                value="<?php echo $customer['company_short_name']; ?>"/>
            </label>
            <label class="input-text-field">
              <span>*<?php echo $workplace_customers_edit_corporate_corporate_data_registration_country_label; ?></span>
              <select type="text"
                      id="registration_country"
                      name="country"
                      autocomplete="off"
                      class="input-send"
                      title="<?php echo $workplace_customers_edit_corporate_corporate_data_registration_country_hint; ?>">
                <option value=""><?php echo $workplace_customers_edit_corporate_corporate_data_registration_country_placeholder; ?></option>
                <?php if ( isset($customer[ 'registration_country' ]) && $customer[ 'registration_country' ]!=''){ ?>
                    <option value="<?php echo $customer[ 'registration_country' ]; ?>" selected><?php echo $customer[ 'registration_country' ] . " - ". $customer['country'][ 'description' ]; ?></option>
                    <?php foreach ( $countries as $country ) { ?>
                      <?php if ( $country['iso_code_2']!==$customer['registration_country']){ ?>
                    <option value="<?php echo $country[ 'iso_code_2' ]; ?>"><?php echo $country[ 'iso_code_2' ] . " - ". $country[ 'name' ]; ?></option>
                    <?php } ?>
                    <?php } ?>
                  <?php } else{ ?>
                    <?php foreach ( $countries as $country ) { ?>
                      <option value="<?php echo $country[ 'iso_code_2' ]; ?>"><?php echo $country[ 'iso_code_2' ] . " - ". $country[ 'name' ]; ?></option>
                      <?php } ?>
                <?php } ?>
              </select>
            </label>
          
        </div>

        <div class="info-content-block list">
          <h2><?php echo  $workplace_customers_edit_corporate_contact_person_data_header; ?></h2>
          
            <label class="input-text-field">
              <span><?php echo $workplace_customers_edit_corporate_contact_person_lastname_label; ?></span>
              <input type="text"
                     id="lastname"
                     name="lastname"
                     autocomplete="family-name"
                     title="<?php echo $workplace_customers_edit_corporate_contact_person_lastname_hint; ?>"
                     placeholder="<?php echo $workplace_customers_edit_corporate_contact_person_lastname_placeholder; ?>"
                     class="cart_contact_table_input_name input-send"
                     min="2"
                     max="64"
                     value="<?php echo $customer['lastname']; ?>"
                     required/>
            </label>
            <label class="input-text-field">
              <span><?php echo $workplace_customers_edit_corporate_contact_person_firstname_label; ?></span>
              <input type="text"
                     id="firstname"
                     name="firstname"
                     autocomplete="given-name"
                     title="<?php echo $workplace_customers_edit_corporate_contact_person_firstname_hint; ?>"
                     placeholder="<?php echo  $workplace_customers_edit_corporate_contact_person_firstname_placeholder; ?>"
                     class="cart_contact_table_input_name input-send"
                     min="2"
                     max="32"
                     value="<?php echo $customer['firstname']; ?>"
                     required/>
            </label>
            <label class="input-text-field">
              <span><?php echo  $workplace_customers_edit_corporate_contact_person_middlename_label; ?></span>
              <input type="text"
                     id="middlename"
                     name="middlename"
                     autocomplete="middle-name"
                     title="<?php echo $workplace_customers_edit_corporate_contact_person_middlename_hint; ?>"
                     placeholder="<?php echo  $workplace_customers_edit_corporate_contact_person_middlename_placeholder; ?>"
                     class="cart_contact_table_input_name input-send"
                     min="2"
                     max="32"
                     value="<?php echo $customer['middlename']; ?>"/>
            </label>
         
        </div>

        <div class="info-content-block list">
          <h2><?php echo $workplace_customers_edit_corporate_roles_header; ?></h2>
         
            <label class="checkbox-field">
              <?php if ( $customer[ 'consumer' ] === '1'){ ?>
              <input
                type="checkbox"
                class="input-send"
                id="consumer_role"
                title="<?php echo $workplace_customers_edit_corporate_checkbox_hint; ?>"
                name="consumer_role"
                checked/>
                <?php } else{ ?>
                  <input
                  type="checkbox"
                  class="input-send"
                  id="consumer_role"
                  title="<?php echo $workplace_customers_edit_corporate_checkbox_hint; ?>"
                  name="consumer_role"/>
                <?php } ?>
              <span><?php echo $workplace_customers_edit_corporate_consumer_checkbox_text; ?></span>
            </label>
            <label class="checkbox-field">
              <?php if ( $customer[ 'manufacturer' ] === '1'){ ?>
              <input
                type="checkbox"
                class="input-send"
                id="manufacturer_role"
                title="<?php echo $workplace_customers_edit_corporate_checkbox_hint; ?>"
                name="manufacturer_role"
                checked/>
              <?php } else{ ?>
                <input
                type="checkbox"
                class="input-send"
                id="manufacturer_role"
                title="<?php echo $workplace_customers_edit_corporate_checkbox_hint; ?>"
                name="manufacturer_role"/>
                <?php } ?>
                <span><?php echo $workplace_customers_edit_corporate_manufacturer_checkbox_text; ?></span>
            </label>
            <label class="checkbox-field">
              <?php if ( $customer[ 'supplier' ] === '1'){ ?>
              <input
                type="checkbox"
                class="input-send"
                id="supplier_role"
                title="<?php echo $workplace_customers_edit_corporate_entity_checkbox_hint; ?>"
                name="supplier_role"
                checked/>
                <?php } else{ ?>
                  <input
                    type="checkbox"
                    class="input-send"
                    id="supplier_role"
                    title="<?php echo $workplace_customers_edit_corporate_entity_checkbox_hint; ?>"
                    name="supplier_role"/>
                  <?php } ?>
              <span><?php echo $workplace_customers_edit_corporate_supplier_checkbox_text; ?></span>
            </label>
          
        </div>

        <div class="between">
          <a href="<?php echo $cancel_button_href; ?>"><button type="button">
              <?php echo $workplace_customers_edit_corporate_cancel_button_text; ?>
            </button></a>
          <button type="submit"
                  title="<?php echo $workplace_customers_edit_corporate_edit_button_hint; ?>"
                  onMouseDown="File_Form('<?php echo $workplace_edit_corporate_edit_button_href; ?>',[['customer_guid','<?php echo $customer_guid; ?>']])">
                  <?php echo $workplace_customers_edit_corporate_edit_button_text; ?>
          </button>
        </div>
      </div>

      <span class="error-alert"></span>
    </div>
    </div>
    
  </div>
</div>
<?php echo $common_footer; ?>