<?php echo $common_header; ?>
<div id="content-section">

  <div class="generic-page-header-grid">
    <div class="generic-page-header-empty-cell"></div>
    <div class="generic-page-header-title-cell">
      <h1 class="generic-page-header-title-text"><?php echo $search_page_headline; ?></h1>
    </div>
  </div>

  <div class="catalog-teaser-search-grid">
    <div class="catalog-teaser-header-search-cell">
      <div class="catalog-teaser-header-search-grid" >
        <div class="catalog-teaser-header-search-section">
          <input class="catalog-teaser-header-search-input" type="text" name="header-search-query" placeholder="<?php echo $catalog_search_page_query_input_placeholder; ?>" value="<?php echo $catalog_search_page_query_input_value; ?>" />
        </div>
        <div class="catalog-teaser-header-search-section">
          <a class="catalog-teaser-header-search-button"><?php echo $catalog_search_page_search_button_caption; ?></a>
        </div>
      </div>
    </div>
  </div>

  <div class="generic-page-content-grid">

    <?php if ( $catalog_search_page_show_products == false ) { ?>

    <div class="generic-page-content-message-text"><?php echo $catalog_search_page_not_found_text; ?></div>

    <?php } else { ?>

    <div class="generic-page-content-message-text"><?php echo $catalog_search_page_found_text . $catalog_search_page_total_products_count; ?></div>

    <div class="products-list-grid">

      <?php foreach ( $products as $product ) { ?>

      <div class="products-list-row">

        <div class="products-list-cell">
          <a href="<?php echo $product[ 'product_href' ]; ?>">
          <div class="products-list-image-cell">
            <?php if ( $product[ 'image_show' ] == false ) { ?>
            <img src="./image/default/no_image.jpg" title="<?php echo $product[ 'product_image_name' ]; ?>"/>
            <?php } else { ?>
            <img src="<?php echo $product[ 'product_image_link' ]; ?>" title="<?php echo $product[ 'product_image_name' ]; ?>"/>
            <?php } ?>
          </div>
          </a>
        </div>

        <div class="products-list-cell">
          <a class= "products-list-mpn-cell" href="<?php echo $product[ 'product_href' ]; ?>"><?php echo $product[ 'product_mpn' ]; ?></a>
        </div>

        <div class="products-list-cell">
          <a class="products-list-manufacturer-cell" href="<?php echo $product[ 'manufacturer_href' ]; ?>"><?php echo $product[ 'manufacturer_name' ]; ?></a>
        </div>

        <div class="products-list-cell">
        <div>Properties</div>
        </div>

        <div class="products-list-cell">
          <div class="products-list-lifecycle-cell"><?php echo $product[ 'product_lifecycle' ]; ?></div>
        </div>

        <div class="products-list-cell">
          <div class="products-list-stock-cell"><?php echo $product[ 'product_stock_quantity' ]; ?></div>
        </div>

        <div>
          <div class="products-list-price-cell"><?php echo $product[ 'product_price' ]; ?></div>
        </div>

        <div class="products-list-cell">
          <a class="products-list-button-cell" href="<?php echo $product[ 'product_href' ]; ?>"><?php echo $product[ 'product_link' ]; ?></a>
        </div>

      </div>

      <?php }?>

    </div>

    <?php }?>

  </div>

</div>

<script type="text/javascript"><!--

$('#content input[name=\'search\']').keydown(function(e) {

	if (e.keyCode == 13)
	{

		$('#button-search').trigger('click');

	}

});

$('#button-search').bind('click', function() {

	url = 'index.php?route=product/search';

	var search = $('#content input[name=\'search\']').attr('value');

	if (search) {
		url += '&search=' + encodeURIComponent(search);
	}

	location = url;

});

//--></script>

<?php echo $common_footer; ?>