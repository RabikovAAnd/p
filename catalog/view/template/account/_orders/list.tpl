<?php echo $common_header; ?>
<div id="content">

  <div class="generic-page-header-grid">
    <div class="generic-page-header-empty-cell"></div>
    <div class="generic-page-header-title-cell">
      <h1 class="generic-page-header-title-text"><?php echo $page_heading_text; ?></h1>
    </div>
  </div>

  <div class="generic-page-content-grid">
  
    <?php if ( $orders_show == false ) { ?>
    <div class="generic-page-message-text"><?php echo $page_message_no_orders_text; ?></div>
  
    <?php } else { ?>

    <div class="customer-order-list-grid">
  
      <div class="customer-order-list-header-row">
  
        <div class="customer-order-list-cell">
          <div class="customer-order-list-cell-value-headline"><?php echo $customer_order_id_text; ?></div>
        </div>

        <div class="customer-order-list-cell">
          <div class="customer-order-list-cell-value-headline"><?php echo $customer_order_date_text; ?></div>
        </div>

        <div class="customer-order-list-cell">
          <div class="customer-order-list-cell-value-headline"><?php echo $customer_order_item_lines_text; ?></div>
        </div>

        <div class="customer-order-list-cell">
          <div class="customer-order-list-cell-value-headline"><?php echo $customer_order_total_text; ?></div>
        </div>

        <div class="customer-order-list-cell">
          <div class="customer-order-list-cell-value-headline"><?php echo $customer_order_status_text; ?></div>
        </div>

      </div>
  
      <?php foreach ( $orders as $order ) { ?>
  
      <a class="customer-order-list-row-link" href="<?php echo $order[ 'href' ]; ?>">
      <div class="customer-order-list-row">
  
        <div class="customer-order-list-cell">
          <div class="customer-order-list-cell-value-text"><?php echo $order[ 'id' ]; ?></div>
        </div>

        <div class="customer-order-list-cell">
          <div class="customer-order-list-cell-value-text"><?php echo $order[ 'date' ]; ?></div>
        </div>

        <div class="customer-order-list-cell">
          <div class="customer-order-list-cell-value-text"><?php echo $order[ 'item_count' ]; ?></div>
        </div>

        <div class="customer-order-list-cell">
          <div class="customer-order-list-cell-value-text"><?php echo $order[ 'total' ]; ?></div>
        </div>

        <div class="customer-order-list-cell">
          <div class="customer-order-list-cell-value-headline"><?php echo $order[ 'status' ]; ?></div>
        </div>

      </div>
      </a>

      <?php } ?>
    
    </div>
    <?php } ?>
    
  </div>
  
</div>
<?php echo $common_footer; ?>