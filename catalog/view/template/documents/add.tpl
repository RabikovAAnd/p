<?php echo $common_header; ?>

<div id="content">

  <h1><?php echo $item[ 'mpn' ] . ": " . $documents_add_header; ?></h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">

      <div class="info-content-block">
<div class="list">
        <label class="input-text-field">
          <?php echo $documents_add_file_label; ?>
          <input id="file_data"
                 type="file"
                 class="input-send"
                 title="<?php echo $documents_add_file_hint;  ?>">
        </label>
        <label  class="input-text-field">
          <?php echo $documents_add_document_type_label; ?>
          <input id="document_type_list"
                  
                  type="text"
                  list="document_type"
                  title="<?php echo $documents_add_document_type_hint;  ?>"
                  placeholder="<?php echo $documents_add_document_type_placeholder; ?>"
                  required/>

          <select id="document_type" size="10" class="input-send">
            <?php foreach ($document_types as $document_type) { ?>
              <option value="<?php echo $document_type['guid']; ?>"><?php echo $document_type['name']; ?></option>
              <?php } ?>
          </select>

        
        </label>


        <label class="input-text-field">
          <?php echo $documents_add_document_version_label; ?>
          <input id="document_version"
                 type="text"
                 class="input-send"
                 title="<?php echo $documents_add_document_version_hint;  ?>"
                 placeholder="<?php echo $documents_add_document_version_placeholder; ?>">
        </label>
        <label class="input-text-field">
          <?php echo $documents_add_document_revision_label; ?>
          <input id="document_revision"
                 type="text"
                 class="input-send"
                 title="<?php echo $documents_add_document_revision_hint;  ?>"
                 placeholder="<?php echo $documents_add_document_revision_placeholder; ?>">
        </label>
        <label class="input-text-field">
          <?php echo $documents_add_document_date_label; ?>
          <input id="document_date"
                 type="date"
                 class="input-send"
                 title="<?php echo $documents_add_document_date_hint;  ?>">
        </label>
        <label class="input-text-field">
          <?php echo $documents_add_document_number_label; ?>
          <input id="document_number"
                 type="text"
                 class="input-send"
                 title="<?php echo $documents_add_document_number_hint;  ?>"
                 placeholder="<?php echo $documents_add_document_number_placeholder; ?>">
        </label>
        <label class="input-text-field">
          <?php echo $documents_add_document_name_label; ?>
          <input id="document_name"
                 type="text"
                 class="input-send"
                 title="<?php echo $documents_add_document_name_hint;  ?>"
                 placeholder="<?php echo $documents_add_document_name_placeholder; ?>">
        </label>
        <label class="input-text-field">
          <?php echo $documents_add_document_description_label; ?>
          <textarea id="document_description"
                 type="text"
                 rows="4"
                 class="input-send"
                 title="<?php echo $documents_add_document_description_hint;  ?>"
                 placeholder="<?php echo $documents_add_document_description_placeholder; ?>"></textarea>
        </label>
        <div class="end">
           <button onMouseDown="File_Form('<?php echo  $documents_add_document_button_href; ?>',[['item_guid','<?php echo  $item_guid; ?>']])"><?php echo $documents_add_add_document_button_text; ?></button>
        </div>
       
      </div>
      <span class="error-alert"></span>
      </div>
      
    </div>

  </div>


</div>
<?php echo $common_footer; ?>

 
<script>
$( '#file_data' ).on( "change", function() {
  let datafiles = $(" .input-send[type='file']" );
  console.log( datafiles[0].files);
});

  $('#document_type_list').keyup(function () {
  Search();

});
function Search() {
  $.ajax({
    url: 'index.php?route=documents/add/Search',
    type: 'POST',
    dataType: 'json',
    data: 'search=' + $('#document_type_list').val(),
    success: function (json) {
      $('#document_type').html('')
      if (json['return_code']) {

        if (json['document_types']) {

          json['document_types'].forEach((document_type) => {
            $('#document_type').append('<option value="'+document_type['guid']+'">'+ document_type['name'] + '</option>');
        })
      }
    }
  },
    error: function (jqXHR, exception, json) {
      console.log('error ' + exception + ' ' + json['error']);
    }

  });
}
</script>