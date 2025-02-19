<?php echo $common_header; ?>
<div id="content">
  <h1 class="header-list__edit">
    <?php echo $workplace_customers_interactions_info_header . ' '. $order['id'] . ' ' . $workplace_customers_interactions_info_header_date_from . ' ' . $order['date']; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area list">

      <div class="info-content-block">
        <h2>
          <?php echo $workplace_customers_interactions_info_supplier_header; ?>
        </h2>
        <?php echo $order['supplier_company_name']; ?>
        <br>
        <?php echo $order['supplier_address_street']; ?>
        <?php echo $order['supplier_address_house']; ?>
        <?php echo $order['supplier_address_building']; ?>
        <?php echo $order['supplier_address_room']; ?>
        <br>
        <?php echo $order['supplier_address_postcode']; ?>
        <?php echo $order['supplier_address_city']; ?>
        <br>
        <?php echo $order['supplier_address_zone_name']; ?>
        <br>
        <?php echo $order['supplier_address_country_name']; ?>
        <br>
        <br>
        <?php echo $workplace_customers_interactions_info_supply_company_vat_number_text . ' ' . $order['supplier_company_vat_number']; ?>
      </div>
      <div class="info-content-block">
        <h2>
          <?php echo $workplace_customers_interactions_info_order_info_header; ?>
        </h2>
        <?php echo $workplace_customers_interactions_info_order_number_text . ' ' . $order['id']; ?>
        <br>
        <?php echo $workplace_customers_interactions_info_order_date_text . ' ' . $order['date']; ?>
        <br>
        <?php echo $workplace_customers_interactions_info_order_status_text . ' ' . $order['status_id']; ?>
        <br>
        <?php echo $workplace_customers_interactions_info_customer_number_text . ' ' ?>
        <?php echo $order[ 'customer' ]['contact_id']; ?>
        <br>
        <?php echo $workplace_customers_interactions_info_customer_full_name_text . ' ' ?>
        <?php echo $order[ 'customer' ]['lastname']; ?>
        <?php echo $order[ 'customer' ]['firstname']; ?>
        <?php echo $order[ 'customer' ]['middlename']; ?>
        <br>
        <?php echo $workplace_customers_interactions_info_customer_purchasing_order_number_text . ' ' .$order['extern_number']; ?>
        <br>
        <?php echo $workplace_customers_interactions_info_general_info_comment_text . ' ' . $order['comment']; ?>
      </div>

      <div class="info-content-block list">
        <h2>
          <?php echo $workplace_customers_interactions_info_payment_header; ?>
        </h2>
        <div class="info-content-block end">
          <a href="<?php echo $edit_payment_address_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_customers_interactions_info_edit_button_text; ?>
            </button>
          </a>
        </div>
        <?php echo $order['payment_company_name']; ?>
        <br>
        <?php echo $order['payment_address_street']; ?>
        <?php echo $order['payment_address_house']; ?>
        <?php echo $order['payment_address_building']; ?>
        <?php echo $order['payment_address_room']; ?>
        <br>
        <?php echo $order['payment_address_postcode']; ?>
        <?php echo $order['payment_address_city']; ?>
        <br>
        <?php echo $order['payment_address_zone_name']; ?>
        <br>
        <?php echo $order['payment_address_country_name']; ?>
        <br>
        <br>
        <?php echo $workplace_customers_interactions_info_payment_company_vat_number_text . ' ' . $order['payment_company_vat_number']; ?>
        <br>
        <br>
        <?php echo $workplace_customers_interactions_info_invoice_number_text; ?> {Invoice number}
        <br>
        <?php echo $workplace_customers_interactions_info_payment_method_text; ?> {Payment method name}
        <br>
        <?php echo $workplace_customers_interactions_info_payment_status_text; ?> {Payment status}
      </div>
      <div class="info-content-block list">
        <h2>
          <?php echo $workplace_customers_interactions_info_delivery_header; ?>
        </h2>
        <div class="info-content-block end">
          <a href="<?php echo $edit_delivery_address_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_customers_interactions_info_edit_button_text; ?>
            </button>
          </a>
        </div>
        <?php echo $order['delivery_company_name']; ?>
        <br>
        <?php echo $order['delivery_address_street']; ?>
        <?php echo $order['delivery_address_house']; ?>
        <?php echo $order['delivery_address_building']; ?>
        <?php echo $order['delivery_address_room']; ?>
        <br>
        <?php echo $order['delivery_address_postcode']; ?>
        <?php echo $order['delivery_address_city']; ?>
        <br>
        <?php echo $order['delivery_address_zone_name']; ?>
        <br>
        <?php echo $order['delivery_address_country_name']; ?>
        <br>
        <br>
        <?php echo $workplace_customers_interactions_info_delivery_company_vat_number_text . ' ' . $order['delivery_company_vat_number']; ?>
        <br>
        <br>
        <?php echo $workplace_customers_interactions_info_packung_list_number_text; ?> {Packing list number}
        <br>
        <?php echo $workplace_customers_interactions_info_delivery_method_text; ?> {Delivery method name}
        <br>
        <?php echo $workplace_customers_interactions_info_delivery_status_text; ?> {Delivery status}
      </div>
      <div class="info-content-block list">
        <h2>
          <?php echo $workplace_customers_interactions_info_order_table_header; ?>
        </h2>
        <div class="info-content-block end">
          <a href="<?php echo $add_order_line_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_customers_interactions_info_add_button_text; ?>
            </button>
          </a>
        </div>
        <div class="table-menu-style">
          <div class="order-table  table-menu-header">
            <span class="order-table__mpn"><b>
                <?php echo $workplace_customers_interactions_info_order_table_mpn_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_customers_interactions_info_order_table_quantity_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_customers_interactions_info_order_table_price_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_customers_interactions_info_order_table_net_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_customers_interactions_info_order_table_vat_text; ?> (%)
              </b></span>
            <span><b>
                <?php echo $workplace_customers_interactions_info_order_table_vat_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_customers_interactions_info_order_table_total_text; ?>
              </b></span>
          </div>
          <?php foreach ($lines as $line){ ?>
          <div id="<?php echo $line[ 'element_href' ]; ?>" class="order-table  table-menu-element">
            <span>
              <?php echo $line['mpn']; ?><br>
              <?php echo $line['description']; ?>
            </span>
            <span>
              <?php echo $line['quantity']; ?>
            </span>
            <span>
              <?php echo $line['price']; ?>
            </span>
            <span>
              <?php echo $line['net']; ?>
            </span>
            <span>
              <?php echo $line['vat_rate']; ?>
            </span>
            <span>
              <?php echo $line['vat']; ?>
            </span>
            <span>
              <?php echo $line['total']; ?>
            </span>
            <div class="table-button-menu" style="display: none;">
              <button type="button" class="red-button"
                title="<?php echo $workplace_customers_interactions_info_remove_button_hint; ?>"
                onMouseDown="File_Form('<?php echo $line[ 'remove_button_href' ]; ?>')">
                <?php echo $workplace_customers_interactions_info_remove_button_text; ?>
              </button>
              <a href="<?php echo $line[ 'change_button_href' ]; ?>">
                <button type="button" title="<?php echo $workplace_customers_interactions_info_change_button_hint; ?>">
                  <?php echo $workplace_customers_interactions_info_change_button_text; ?>
                </button>
              </a>

            </div>
          </div>
          <?php }?>
        </div>
        <div class="end info-content-block">
          <span><b>
              <?php echo $workplace_customers_interactions_info_general_info_net_text . ': '; ?>
            </b>
            <?php echo $order['net']; ?>
            <br>
            <b>
              <?php echo $workplace_customers_interactions_info_general_info_vat_text . ': '; ?>
            </b>
            <?php echo $order['vat']; ?>
            <br>
            <b>
              <?php echo $workplace_customers_interactions_info_general_info_total_text . ': '; ?>
            </b>
            <?php echo $order['total']; ?>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $common_footer; ?>