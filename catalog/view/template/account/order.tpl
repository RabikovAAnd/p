<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $account_order_header . ' '. $order['id'] . ' ' . $account_order_header_date_from . ' ' . $order['date']; ?>
  </h1>
  <div class="list">
    <div class="order-info">
      <div class="info-content-block">
        <h2>
          <?php echo $account_order_supplier_header; ?>
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
        <?php echo $account_order_supply_company_vat_number_text . ' ' . $order['supplier_company_vat_number']; ?>
      </div>
      <div class="info-content-block">
        <h2>
          <?php echo $account_order_order_info_header; ?>
        </h2>
        <?php echo $account_order_order_number_text . ' ' . $order['id']; ?>
        <br>
        <?php echo $account_order_order_date_text . ' ' . $order['date']; ?>
        <br>
        <?php echo $account_order_order_status_text . ' ' . $order['status_id']; ?>
        <br>
        <?php echo $account_order_customer_number_text . ' ' ?> {Customer number}
        <br>
        <?php echo $account_order_customer_purchasing_order_number_text. ' ' .$order['extern_number']; ?>
      </div>
    </div>
    <div class="addresses">
      <div class="info-content-block">
        <h2>
          <?php echo $account_order_payment_header; ?>
        </h2>
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
        <?php echo $account_order_payment_company_vat_number_text . ' ' . $order['payment_company_vat_number']; ?>
        <br>
        <br>
        <?php echo $account_order_invoice_number_text; ?> {Invoice number}
        <br>
        <?php echo $account_order_payment_method_text; ?> {Payment method name}
        <br>
        <?php echo $account_order_payment_status_text; ?> {Payment status}
      </div>
      <div class="info-content-block">
        <h2>
          <?php echo $account_order_delivery_header; ?>
        </h2>
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
        <?php echo $account_order_delivery_company_vat_number_text . ' ' . $order['delivery_company_vat_number']; ?>
        <br>
        <br>
        <?php echo $account_order_packung_list_number_text; ?> {Packing list number}
        <br>
        <?php echo $account_order_delivery_method_text; ?> {Delivery method name}
        <br>
        <?php echo $account_order_delivery_status_text; ?> {Delivery status}
      </div>
    </div>
    <div class="table-menu-style">
      <div class="order-table  table-menu-header">
        <span class="order-table__mpn"><b>
            <?php echo $account_order_order_table_mpn_text; ?>
          </b></span>
        <span><b>
            <?php echo $account_order_order_table_quantity_text; ?>
          </b></span>
        <span><b>
            <?php echo $account_order_order_table_price_text; ?>
          </b></span>
        <span><b>
            <?php echo $account_order_order_table_net_text; ?>
          </b></span>
        <span><b>
            <?php echo $account_order_order_table_vat_text; ?> (%)
          </b></span>
        <span><b>
            <?php echo $account_order_order_table_vat_text; ?>
          </b></span>
        <span><b>
            <?php echo $account_order_order_table_total_text; ?>
          </b></span>
      </div>
      <?php foreach ($lines as $line){ ?>
      <div class="order-table  table-menu-element">
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
      </div>


      <?php }?>


    </div>
    <div class="order-general-info info-content-block">
      <div>
        <b>
          <?php echo $account_order_general_info_comment_text; ?>
        </b>
        <?php echo $order['comment']; ?>
      </div>
      <div class="order-general-info_amount-info">
        <span><b>
            <?php echo $account_order_general_info_net_text; ?>:
          </b>
          <?php echo $order['net']; ?>
        </span>
        <span><b>
            <?php echo $account_order_general_info_vat_text; ?>:
          </b>
          <?php echo $order['vat']; ?>
        </span>
        <span><b>
            <?php echo $account_order_general_info_total_text; ?>:
          </b>
          <?php echo $order['total']; ?>
        </span>
      </div>

    </div>
  </div>

</div>
<?php echo $common_footer; ?>