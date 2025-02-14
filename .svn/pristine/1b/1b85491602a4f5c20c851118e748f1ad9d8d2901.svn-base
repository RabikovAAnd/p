<?php echo $common_header; ?>

<div id="content">
  <h1><?php echo $workplace_add_supplier_header; ?></h1>

<div class="account-area">
  <?php echo $workplace_menu; ?>
  <div class="main-area">
    <div class="info-content-block">
    <div class="list">
      
      <label class="input-text-field">       
        <span><?php echo $workplace_add_supplier_supplier_label; ?></span>
        <input
          id="supplier_list"
          title="<?php echo  $workplace_add_supplier_supplier_hint; ?>"
          placeholder="<?php echo $workplace_add_supplier_supplier_placeholder; ?>"/>
        <select 
          id="supplier" 
          size="10" 
          class="input-send">
            <?php foreach ( $suppliers as $supplier ) { ?>
            <option value="<?php echo $supplier[ 'guid' ]; ?>"><?php echo $supplier[ 'company_name' ]; ?> <?php echo $supplier[ 'lastname' ]; ?> <?php echo $supplier[ 'name' ]; ?></option>
            <?php } ?>
        </select>
      </label>

      <label class="input-text-field">
        <?php echo $workplace_add_supplier_supplier_article_label; ?>
        <input id="supplier_article" type="text" class="input-send" title="<?php echo $workplace_add_supplier_supplier_article_hint; ?>"
          placeholder="<?php echo $workplace_add_supplier_supplier_article_placeholder; ?>" />
      </label>
      <div class="between">
        <a href="<?php echo $cancel_button_href; ?>"><button type="button">
          <?php echo $workplace_add_supplier_cancel_button_text; ?>
        </button></a>
        <button
          title="<?php echo  $workplace_add_supplier_add_supplier_button_hint; ?>"
          onMouseDown="File_Form('<?php echo  $workplace_add_supplier_button_href; ?>',[['item_guid','<?php echo  $item_guid; ?>']])">
          <?php echo $workplace_add_supplier_add_supplier_button_text; ?>
        </button>
      </div>

    </div>
    <span class="error-alert"></span>
  </div>
  </div>
  
</div>

</div>
<?php echo $common_footer; ?>
  
<script type="text/javascript">

$('#supplier_list').keyup(function () {
  Search();
});

function Search() {
  $.ajax({
    url: 'index.php?route=workplace/items/suppliers/add/search',
    type: 'POST',
    dataType: 'json',
    data: 'search=' + $('#supplier_list').val(),
    success: function (json) {
      $('#supplier').html('')
      if (json['return_code']) {
        if (json['suppliers']) {
          json['suppliers'].forEach((supplier) => {
            $('#supplier').append('<option value="' + supplier['guid'] +'">' + supplier['company_name'] + " "+ supplier['lastname'] + " " + supplier['name']  + '</option>');          
          })
        }
      }
    },
    error: function (jqXHR, exception, json) {
      console.log('error ' + exception + ' ' + json['error']);
    }
  });
}

  $('#legal_entity').on('change', function (event) {
    if ($('#legal_entity').is(':checked')) {
      $('.company_info').show()
    } else {
      $('.company_info').hide()
    }
  });

</script>