
<?php echo $common_header; ?>
<div>

    <h1><?php echo $text_category_header; ?></h1>
    <div class="list">
        <?php echo $text_category_description; ?>

        <div class="list">
          <?php if ( count( $items ) === 0 ) { ?>
            <div><?php echo $items_list_no_items_text; ?></div>
          <?php } else { ?>
            <?php foreach ( $items as $item ) { ?>
    
            <div id="<?php echo $item[ 'data' ][ 'guid' ]; ?>"
                 class="info-content-block item">
                <a href="<?php echo $item[ 'data' ][ 'href' ]; ?>">
                    <?php if ( $item[ 'data' ][ 'image_data' ] == '' ) { ?>
                    <img src="./image/default/no_image.jpg" title="<?php echo $item[ 'data' ][ 'mpn' ]; ?>"/>
                    <?php } else { ?>
                    <img src="<?php echo $item[ 'data' ][ 'image_data' ]; ?>"
                         title="<?php echo $item[ 'data' ][ 'mpn' ]; ?>"/>
                    <?php } ?>
                </a>
    
                <div>
                    <span><?php echo $items_list_vendor_code_text; ?>: <a
                                href="<?php echo $item[ 'data' ][ 'href' ]; ?>">
                            <?php echo $item[ 'data' ][ 'mpn' ]; ?>
                        </a>
                    </span>
                    <br>
                    <span>
                        <?php echo $items_list_manufacturer_text; ?>: <a
                                href="<?php echo $item[ 'data' ][ 'manufacturer_href' ]; ?>">
                            <?php echo $item[ 'data' ][ 'manufacturer_name' ]; ?>
                        </a>
                    </span>
                    <br>
                    <span>
                        <?php foreach ( $item[ 'properties' ] as $property ) { ?>
                        <?php echo $property[ 'property_name' ] . ": " . $property[ 'value' ] ?>
                        <?php } ?>
                    </span>
                </div>
                <div class="item__amount-info">
                    <div class="item__cart-info">
                        <div>
                            <div class="item__features">
                                <span class="item__stock_quantity"><?php echo $items_list_stock_text; ?>:
                                  <b><?php echo $item[ 'warehouse' ][ 'quantity' ]; ?></b> pcs.
                                </span>
                                <br>
                                <span class="item__stock_price"><?php echo $items_list_price_text; ?>:
                                  <b><?php echo $item[ 'warehouse' ][ 'price' ]; ?></b> EUR
                                </span>
                                <br>
                            </div>
    
                            <div class="item__quantity-button">
                                <button type="button" onMouseDown="Set_Quantity()"
                                         data-action="minus">-</button>
                                <input class="item__item-quantity"
                                       onchange="Set_Quantity()"
                                       data-action="input"
                                       type="number"
                                       min="0"
                                       value="<?php echo $item[ 'cart' ][ 'quantity' ]; ?>"
                                       max="<?php echo $item[ 'warehouse' ][ 'quantity' ]; ?>"/>
                                <button type="button" onMouseDown="Set_Quantity()"
                                        data-action="plus">+</button>
                            </div>
                        </div>
                        <span>
                            <?php echo $items_list_total_price_text; ?>: <b><span class="item__total"><?php echo $item[ 'cart' ][ 'total' ]; ?></span></b><?php echo ' ' . $item[ 'cart' ][ 'currency' ]; ?>
    
                        </span>
                        </div>
    
                </div>
    
            </div>
    
            <?php } ?>
          <?php } ?>  
        </div>
    </div>

</div>
<?php echo $common_footer; ?>

<script type="text/javascript">
    //Reset quantity
    window.addEventListener("unload", function () {
        let itemQuantity = document.querySelectorAll(".item__amount-info");
        for (let item of itemQuantity) {
            let quantity = item.querySelectorAll('.item__item-quantity');
            quantity[0].value = 0;
        }
    });

</script>
