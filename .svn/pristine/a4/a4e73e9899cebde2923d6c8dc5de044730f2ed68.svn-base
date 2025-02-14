<?php echo $common_header; ?>

<div id="content">

  <h1><?php echo $workplace_add_assembly_unit_header . ' ' . $item_mpn; ?></h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">

      <div class="list info-content-block">
        <label class="input-text-field">
          <?php echo $workplace_add_assembly_unit_position_designation_label; ?>
          <input id="designator"
                 type="text"
                 class="input-send"
                 title="<?php echo $workplace_add_assembly_unit_position_designation_hint;  ?>"
                 placeholder="<?php echo $workplace_add_assembly_unit_position_designation_placeholder; ?>"/>
        </label>
        <label class="input-text-field">
          <?php echo $workplace_add_assembly_unit_quantity_label; ?>
          <input id="quantity"
                 type="text"
                 class="input-send"
                 title="<?php echo $workplace_add_assembly_unit_quantity_hint;  ?>"
                 placeholder="<?php echo $workplace_add_assembly_unit_quantity_placeholder; ?>"/>
        </label>
        <label class="input-text-field search-selector">
          <?php echo $workplace_add_assembly_unit_item_label; ?>
          <input 
                  id="item_list"
                  type="text"
                  list="subitems"
                  title="<?php echo $workplace_add_assembly_unit_item_hint;  ?>"
                  placeholder="<?php echo $workplace_add_assembly_unit_item_placeholder; ?>"
                  required/>
          <select id="subitems" class="input-send" size="10">
            <?php foreach ($items as $item) { ?>
            <option id="<?php echo $item[ 'guid' ]; ?>" value="<?php echo $item[ 'guid' ]; ?>"><?php echo $item[ 'mpn' ] . ' - ' . $item[ 'manufacturer_name' ]; ?></option>
            <?php } ?>
          </select>
        </label>

        <div class="between">
        <a href="<?php echo $cancel_button_href; ?>"><button type="button"><?php echo $workplace_add_assembly_unit_cancel_button_text; ?></button></a>
        <button onMouseDown="File_Form('<?php echo $add_button_href; ?>',[['item_guid','<?php echo $item_guid; ?>']])"><?php echo $workplace_add_assembly_unit_add_assembly_unit_button_text; ?></button> 
        </div>

        <span class="error-alert"></span>
      </div>
      
    </div>

  </div>

</div>
<?php echo $common_footer; ?>

<script>

$('#item_list').keyup(function () {
  Search();
});

function Search() {
  $.ajax({
    url: 'index.php?route=workplace/items/subitems/add/Search',
    type: 'POST',
    dataType: 'json',
    data: 'search=' + $('#item_list').val(),
    success: function (json) {
      
      $('#subitems').html('')
      if (json['return_code']) {
        if (json['items']) {
          json['items'].forEach((item) => {
            $('#subitems').append('<option id="'+item['guid']+'" value="' + item['guid'] +'">' + item['mpn'] + ' - ' + item['manufacturer_name'] + '</option>');          
          })
        }
      }
      LinkMouseDown()
  TableButtonMenu()
  SearchSelector()
    },
    error: function (jqXHR, exception, json) {
      console.log('error ' + exception + ' ' + json['error']);
    }
  });
}

</script>