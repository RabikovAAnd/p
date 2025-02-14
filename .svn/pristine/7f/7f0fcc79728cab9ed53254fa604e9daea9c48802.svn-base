<?php echo $common_header; ?>
<div id="content">
  <h1 class="header-list__edit">
    <?php echo $workplace_customer_info_header;?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area list">
      <div class="info-content-block list">
        <h2>
          <?php echo $workplace_customer_general_data_header; ?>
        </h2>
        <div class="info-content-block end">
          <a href="<?php echo $customer_info_edit_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_customer_info_edit_button_text; ?>
            </button>
          </a>
        </div>
        <div class="general-info">
          <?php if ( $customer[ 'legal_entity' ] === '1' ) { ?>
          <?php echo $workplace_customer_info_account_type_text . ': ' . $workplace_customer_info_legal_entity_text; ?><br>
          <?php echo $workplace_customer_info_company_name_text . ': ' . $customer[ 'company_name' ]; ?><br>
          <?php echo $workplace_customer_info_full_name_text; ?>:
          <?php echo $customer[ 'lastname' ]; ?>
          <?php echo $customer[ 'firstname' ]; ?>
          <?php echo $customer[ 'middlename' ]; ?><br>
          <?php } else { ?>
          <?php echo $workplace_customer_info_account_type_text . ': '. $workplace_customer_info_individual_text; ?><br>
          <?php echo $workplace_customer_info_full_name_text; ?>:
          <?php echo $customer[ 'lastname' ]; ?>
          <?php echo $customer[ 'firstname' ]; ?>
          <?php echo $customer[ 'middlename' ]; ?><br>
          <?php } ?>
          <?php echo $workplace_customer_info_registration_country_text; ?>:
          <?php echo $registration_country[ 'description' ]; ?><br>
          <?php echo $workplace_customer_info_email_text; ?>:
          <?php echo $customer[ 'email' ]; ?><br>
          <?php echo $workplace_customer_info_date_creation_text; ?>:
          <?php echo $customer[ 'date_added' ]; ?><br>
          <?php echo $workplace_customer_info_id_text; ?>:
          <?php echo $customer[ 'contact_id' ]; ?><br>
          <?php echo $workplace_customer_info_guid_text; ?>:
          <?php echo $customer[ 'guid' ]; ?>
        </div>
      </div>
      <div class="info-content-block list">
        <h2>
          <?php echo $workplace_customer_info_addinfo_data_header; ?>
        </h2>
        <div class="info-content-block end">
          <a href="<?php echo $customer_info_edit_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_customer_info_add_addinfo_button_text; ?>
            </button>
          </a>
        </div>

      </div>
      <div class="info-content-block list">
        <h2>
          <?php echo $workplace_customer_info_address_data_header; ?>
        </h2>
        <div class="info-content-block end">
          <a href="<?php echo $create_address_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_customer_info_add_address_button_text; ?>
            </button>
          </a>
        </div>
        <?php if( isset($addresses)) { ?>
        <div class="table-menu-style">
          <div class="addresses-table table-menu-header">
            <span><b>
                <?php echo $workplace_customer_info_addresses_table_address_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_customer_info_addresses_table_type_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_customer_info_addresses_table_status_text; ?>
              </b></span>
          </div>

          <?php foreach ( $addresses as $address ) { ?>
          <div class="addresses-table table-menu-element">
            <span>
              <?php echo $address['address_text']; ?>

            </span>
            <span>
              <?php echo $address['type']; ?>
            </span>
            <span>
              <?php echo $address['active']; ?>
            </span>

            <div class="table-button-menu" style="display: none;">

              <a href="<?php echo $address[ 'edit_href' ]; ?>">
                <button type="button" title="<?php echo $workplace_customer_info_allow_permission_button_hint; ?>">
                  <?php echo $workplace_customer_info_commercial_relationships_edit_button_text; ?>
                </button>
              </a>



            </div>
          </div>

          <?php } ?>
        </div>
        <?php } ?>
      </div>
      <div class="info-content-block list">
        <h2>
          <?php echo $workplace_customer_info_commercial_relationships_header; ?>
        </h2>
        <div class="info-content-block end">
          <a href="<?php echo $create_request_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_customer_info_create_request_button_text; ?>
            </button>
          </a>
          <a href="<?php echo $create_offer_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_customer_info_create_offer_button_text; ?>
            </button>
          </a>
        </div>
        <?php if( isset($orders)) { ?>
        <div class="table-menu-style">
          <div class="commercial-relationships-table table-menu-header">
            <span><b>
                <?php echo $workplace_customer_info_commercial_relationships_table_id_text; ?>
              </b></span>
              <span><b>
                  <?php echo $workplace_customer_info_commercial_relationships_table_name_text; ?>
                </b></span>
            <span><b>
                <?php echo $workplace_customer_info_commercial_relationships_table_number_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_customer_info_commercial_relationships_table_date_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_customer_info_commercial_relationships_table_status_text; ?>
              </b></span>
          </div>

          <?php foreach ( $orders as $order ) { ?>
          <div class="commercial-relationships-table table-menu-element">
            <span><a href="<?php echo $order['href']; ?>">
              <?php echo $order['order_id']; ?> </a>
            </span>
            <span>
              <?php echo $order['type']; ?>
            </span>
            <span>
                <?php echo $order['extern_number']; ?>
            </span>
            <span>
              <?php echo $order['date']; ?>
            </span>
            <span>
              <?php echo $order['status']; ?>
            </span>

            <div class="table-button-menu" style="display: none;">
              <button class="red-button" type="button"
                title="<?php echo $workplace_customer_info_remove_permission_button_hint; ?>"
                onMouseDown="File_Form('<?php echo $endpoint[ 'remove_button_href' ]; ?>')">
                <?php echo $workplace_customer_info_commercial_relationships_cancel_button_text; ?>
              </button>

              <button type="button" title="<?php echo $workplace_customer_info_allow_permission_button_hint; ?>"
                onMouseDown="File_Form('<?php echo $endpoint[ 'allow_button_href' ]; ?>')">
                <?php echo $workplace_customer_info_commercial_relationships_edit_button_text; ?>
              </button>

              <button type="button" title="<?php echo $workplace_customer_info_remove_permission_button_hint; ?>"
                onMouseDown="File_Form('<?php echo $endpoint[ 'remove_button_href' ]; ?>')">
                <?php echo $workplace_customer_info_commercial_relationships_order_button_text; ?>
              </button>
            </div>
          </div>

          <?php } ?>
        </div>
        <?php } ?>

      </div>
      <div class="info-content-block list">
        <h2>
          <?php echo $workplace_customer_info_permissions_header; ?>
        </h2>
        <?php if( isset( $endpoints ) ) { ?>
        <div class="table-menu-style">
          <div class="endpoints-table table-menu-header">
            <span><b>
                <?php echo $workplace_customer_info_permissions_table_name_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_customer_info_permissions_table_permission_text; ?>
              </b></span>
          </div>

          <?php foreach ( $endpoints as $endpoint ) { ?>
          <div id="<?php echo $endpoint[ 'element_href' ]; ?>" class="endpoints-table table-menu-element">
            <span>
              <?php echo $endpoint[ 'name' ]; ?>
            </span>
            <span>
              <?php if( $endpoint[ 'access' ]===false)  {?>
              <?php echo $workplace_customer_info_permissions_table_permission_forbidden_button_text; ?>
              <?php } else { ?>
              <?php echo $workplace_customer_info_permissions_table_permission_allowed_button_text; ?>
              <?php } ?>
            </span>

            <div class="table-button-menu" style="display: none;">
              <button type="button" title="<?php echo $workplace_customer_info_allow_permission_button_hint; ?>"
                onMouseDown="File_Form('<?php echo $endpoint[ 'allow_button_href' ]; ?>')">
                <?php echo $workplace_customer_info_allow_permission_button_text; ?>
              </button>

              <button class="red-button" type="button"
                title="<?php echo $workplace_customer_info_remove_permission_button_hint; ?>"
                onMouseDown="File_Form('<?php echo $endpoint[ 'remove_button_href' ]; ?>')">
                <?php echo $workplace_customer_info_remove_permission_button_text; ?>
              </button>
            </div>
          </div>

          <?php } ?>
        </div>
        <?php } ?>

      </div>
    </div>
  </div>
</div>
<?php echo $common_footer; ?>