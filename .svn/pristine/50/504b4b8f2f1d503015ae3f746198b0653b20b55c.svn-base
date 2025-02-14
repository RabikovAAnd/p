<?php echo $common_header; ?>
<div id="content">
    <h1 class="header-list__edit"><?php echo  $account_orders_list_header; ?></h1>
    <div class="account-area">
        <?php echo $account_menu; ?>
        <div class="info-content-block list">
            <?php if ($orders) { ?>
            <?php foreach ($orders as $order){ ?>
            <a href="<?php echo $order[ 'order_href' ]; ?>" class="info-content-block">
                <div id="<?php echo $order['order_id']; ?>">
                    <span>
                        <b>№<?php echo $order['order_id']; ?></b> (<?php echo $order['order_status']; ?>)
                    </span>
                    <br>
                    <span><?php echo $order['order_date']; ?></span>
                    <br>Цена брутто: <?php echo $order['order_gross']; ?> (Цена нетто: <?php echo $order['order_net']; ?>, НДС: <?php echo $order['order_vat']; ?>)
                    <br>Количество: <?php echo $order['order_quantity']; ?>


                    <br>Адрес оплаты: <?php echo $order['order_payment_address']; ?>
                    <br>Адрес доставки: <?php echo $order['order_delivery_address']; ?>

                </div>

            </a>
            <?php }?>
            <?php } else { ?>
            <div>
                <?php echo $account_orders_list_no_orders_text; ?>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php echo $common_footer; ?>

