<?php echo $common_header; ?>
<div itemscope itemtype="http://schema.org/Offer">
    <h1 itemprop="mpn"><?php echo $item[ 'mpn' ]; ?></h1>

    <div id="<?php echo $item[ 'guid' ]; ?>" class="info-content-block item">
        <div class="item__image">
            <?php if ( $item[ 'image_data' ] !== '' ) { ?>
            <img itemprop="image"  src="<?php echo $item[ 'image_data' ]; ?>" title="<?php echo $item[ 'mpn' ]; ?>"/>
            <?php } ?>
        </div>
        <div class="item__info">
            <div class="short-info content-elem">
                <div>
                    <span><?php echo $items_info_vendor_code_text; ?>: <?php echo $item[ 'mpn' ]; ?></span>
                    <br>
                    <span>
                    <?php echo $items_info_manufacturer_text; ?>:
                        <a  itemprop="manufacturer" href="<?php echo $item[ 'manufacturer_href' ]; ?>">
                        <?php echo $item[ 'manufacturer_name' ]; ?>
                        </a>
                    </span>
                </div>
                <div class="item__amount-info">
                    <div class="item__quantity-button">
                        <button type="button" onMouseDown="Set_Quantity()"
                                 data-action="minus">-</button>
                        <input class="item__item-quantity"
                               onchange="Set_Quantity()"
                               data-action="input"
                               type="number"
                               min="0"
                               value="<?php echo $cart[ 'quantity' ]; ?>"
                               max="<?php echo $warehouse[ 'quantity' ]; ?>"/>
                        <button type="button" onMouseDown="Set_Quantity()"
                                data-action="plus">+</button>
                    </div>
                    <div class="item__features">
                        <?php echo $items_info_stock_text; ?>: <b><span class="item__stock_quantity"><?php echo $warehouse[ 'quantity' ]; ?></span></b><?php echo ' ' . $warehouse[ 'unit_name' ]; ?>
                        <br>

                        Unit price: <b><span itemprop="price" class="item__price"><?php echo $cart[ 'price' ]; ?></span></b><span itemprop="priceCurrency" ><?php echo ' ' . $cart[ 'currency' ]; ?></span>
                        <br>

                        Net: <b><span class="item__net"><?php echo $cart[ 'net' ]; ?></span></b><?php echo ' ' . $cart[ 'currency' ]; ?>
                        <br>

                        VAT: <b><span class="item__vat"><?php echo $cart[ 'vat' ]; ?></span></b><?php echo ' ' . $cart[ 'currency' ]; ?>
                        <br>

                        <?php echo $items_info_total_price_text; ?>: <b><span class="item__total"><?php echo $cart[ 'total' ]; ?></span></b><?php echo ' ' . $cart[ 'currency' ]; ?>
                    </div>
                </div>
            </div>

            <?php if ( $item[ 'description' ] !== '' ) { ?>
            <div itemprop="description" class="description content-elem">
                <h3><?php echo $items_info_description_section_header; ?></h3>
                <span><?php echo $item[ 'description' ]; ?></span>
            </div>
            <?php } ?>

            <?php if ( count( $properties ) > 0 ) { ?>
            <div class="properties content-elem">
                <?php foreach ( $properties[ 'groups' ] as $group => $properties ) { ?>
                <h3><?php echo $group; ?></h3>
                <ul>
                    <?php foreach ( $properties as $property_name => $property ) { ?>
                    <li><?php echo $property[ 'property_name' ] . ': ' . $property[ 'property_value' ]; ?></li>
                    <?php } ?>
                </ul>
                <?php } ?>
            </div>
            <?php } ?>

            <?php if ( count( $documents ) > 0 ) { ?>
            <div class="files content-elem">
                <h3><?php echo $items_info_documents_section_header; ?></h3>
                <ul>
                    <?php foreach ( $documents as $document ) { ?>
                    <li>
                        <a><?php echo $document[ 'name' ] ?></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>
        </div>

    </div>
</div>

    <?php echo $common_footer; ?>

<script type="text/javascript">

// Reset quantity
window.addEventListener("unload", function () {
  let itemQuantity = document.querySelectorAll(".item__amount-info");
  for (let item of itemQuantity) {
    let quantity = item.querySelectorAll('.item__item-quantity');
    quantity[0].value = 1;
  }
});

</script>


