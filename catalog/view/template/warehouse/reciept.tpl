<?php echo $common_header; ?>
<div>

  <div class="generic-page-header-grid">
    <div class="generic-page-header-empty-cell"></div>
    <div class="generic-page-header-title-cell">
      <h1 class="generic-page-header-title-text"><?php echo $heading_title; ?></h1>
    </div>
  </div>
  
  <div class="generic-page-content-grid">

    <div class="marketing-website-add-grid">

      <div class="marketing-website-add-cell">
<!--
        <div class="marketing-website-add-query-grid" >
          <div class="marketing-website-add-query-cell">
            <div>Supplier XXX</div>
          </div>
          <div class="marketing-website-add-query-cell">
            <a class="marketing-website-add-query-button" id="select-supplier-button"><?php echo $website_add_button_caption; ?></a>
          </div>
        </div>
        
        <div id="supplier-search-container">
        <div class="marketing-website-add-query-grid" >
          <div class="marketing-website-add-query-cell">
            <input class="marketing-website-add-query-input" type="text" id="supplier-search-query-input" name="supplier-search-query-input" placeholder="" value="" />
          </div>
          <div class="marketing-website-add-query-cell">
            <a class="marketing-website-add-query-button" id="supplier-search-button"><?php echo $website_add_button_caption; ?></a>
          </div>
        </div>

        <div class="" id="supplier-searsh-result">
          
          <div>
            <input type="radio" id="supplier_1" name="supplier" value="1">
            <label for="supplier_1">Supplier 1</label>
          </div>
          
          <div>
            <input type="radio" id="supplier_2" name="supplier" value="2">
            <label for="supplier_2">Supplier 2</label>
          </div>
          
          <div>
            <input type="radio" id="supplier_3" name="supplier" value="3">
            <label for="supplier_3">Supplier 3</label>
          </div>
          
        </div>
        
        </div>
-->
        
        <div class="marketing-website-add-query-grid" >
          <div class="marketing-website-add-query-cell">
            <input class="marketing-website-add-query-input" type="text" id="mpn-input" name="mpn-input" placeholder="<?php echo $mpn_add_placeholder_text; ?>" value="" />
          </div>
        </div>

        <div class="marketing-website-add-query-grid" >
          <div class="marketing-website-add-query-cell">
            <input class="marketing-website-add-query-input" type="text" id="manufacturer-input" name="manufacturer-input" placeholder="<?php echo $manufacturer_add_placeholder_text; ?>" value="" />
          </div>
        </div>

        <div class="marketing-website-add-query-grid" >
          <div class="marketing-website-add-query-cell">
            <input class="marketing-website-add-query-input" type="text" id="quantity-input" name="quantity-input" placeholder="<?php echo $quantity_add_placeholder_text; ?>" value="" />
          </div>
        </div>
<!--
        <div class="marketing-website-add-query-grid" >
          <div class="marketing-website-add-query-cell">
            <input class="marketing-website-add-query-input" type="text" id="supplier-search-query-input" name="supplier-search-query-input" placeholder="" value="" />
          </div>
        </div>
-->
          <div class="marketing-website-add-query-cell">
            <a class="marketing-website-add-query-button" id="marketing-website-add-query-button"><?php echo $website_add_button_caption; ?></a>
          </div>

      </div>

      <div class="marketing-website-add-results-cell" id="website-add-results">

      </div>
    
    </div>
  
  </div>

</div>
 
<script type="text/javascript"><!--

//------------------------------------------------------------------------------
/*
$( 'a#item-add-button1' ).bind( 'click', function() {

alert( 'Select' );

  $( 'div#supplier-search-container' ).toggle( "slow" );

});

$( 'a#supplier-search-button' ).bind( 'click', function() {

  // Get query string
  var supplier_query = $( 'input#supplier-search-query-input' ).attr( 'value' );

alert( 'Search' + supplier_query );

  $.ajax({
    url: 'index.php?route=warehouse/reciept/get_supplier',
    type: 'post',
    data: 'query=' + supplier_query,
    dataType: 'json',
    success: function( json ) {

alert( 'Search' + json );

    json[ 'customers' ].forEach( function( customer_data_raw ) {

alert( 'Row' + customer_data_raw );

  });

      switch ( json[ 'return_code' ] )
      {

        case 'success':
        {

          var html = '<div class="marketing-website-add-results-grid" >';
          html += '<div class="marketing-website-add-results-cell">';
          html += json[ 'url' ];
          html += '</div>';
          html += '<div class="marketing-website-add-results-cell">';
          html += '<?php echo $website_add_result_added_text; ?>';
          html += '</div>';
          html += '</div>';

          $( 'div#website-add-results' ).prepend( html );

          $( 'input#website-url-input' ).val('');
          
          break;

        }

      }
      
    }
    
  });

});
*/
//------------------------------------------------------------------------------

//$( 'a#marketing-website-add-query-button' ).bind( 'click', function() {
$(document).on( 'click', 'a#marketing-website-add-query-button', function() {

	// Get filter settings
	var item_mpn = $( 'input#mpn-input' ).val();
	var item_manufacturer = $( 'input#manufacturer-input' ).val();
  var item_quantity = $( 'input#quantity-input' ).val();

//	alert ( 'Type: ' + item_mpn + ', Status: ' + item_manufacturer + ', Text: ' + item_quantity );

  $.ajax({
    url: 'index.php?route=warehouse/reciept/add',
    type: 'post',
    data: 'mpn=' + item_mpn + '&manufacturer=' + item_manufacturer + '&quantity=' + item_quantity,
    dataType: 'json',
    success: function( json ) {

    	if ( json[ 'error' ] == false )
    	{
    
    		alert( 'Ok.' );
    		
    	}
    	else
    	{

    		alert( 'Error.' );
    
    	}
      
    }
    
  });

});

//------------------------------------------------------------------------------
/*
$( 'input[type=radio][name=supplier]' ).bind( 'click', function() {

  // Get query string
  var supplier_id = $( 'input[type=radio][name=supplier]:checked' ).val();

alert( 'Select list : ' + supplier_id );

  $( 'div#supplier-search-container' ).hide( "slow" );

});
*/
//------------------------------------------------------------------------------
/*
$( 'a#website-add-button' ).bind( 'click', function() {

  // Get query string
  var website_url = $( 'input#website-url-input' ).attr( 'value' );

  $.ajax({
    url: 'index.php?route=marketing/websites/add',
    type: 'post',
    data: 'url=' + website_url,
    dataType: 'json',
    success: function( json ) {

      switch ( json[ 'return_code' ] )
      {

        case 'success':
        {

          var html = '<div class="marketing-website-add-results-grid" >';
          html += '<div class="marketing-website-add-results-cell">';
          html += json[ 'url' ];
          html += '</div>';
          html += '<div class="marketing-website-add-results-cell">';
          html += '';
          html += '</div>';
          html += '</div>';

          $( 'div#website-add-results' ).prepend( html );

          $( 'input#website-url-input' ).val('');
          
          break;

        }

      }
      
    }
    
  });

});
*/
//--------------------------------------------------------------------------------
--></script>

<?php echo $common_footer; ?>
