<?php echo $common_header; ?>

<div id="content">

  <h1>
    <?php echo $document[ 'name' ] . ": " . $documents_replace_header; ?>
  </h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">

      <div class="info-content-block">
        <div class="list">
          <label class="input-text-field">
            <?php echo $documents_replace_file_label; ?>
            <input id="file_data" type="file" class="input-send" title="<?php echo $documents_replace_file_hint;  ?>">
          </label>

          <div class="between">      
            <a href="<?php echo $cancel_button_href; ?>"><button type="button">
              <?php echo $documents_replace_cancel_button_text; ?>
            </button></a>
            <button
              onMouseDown="File_Form('<?php echo  $documents_replace_document_button_href; ?>')">
              <?php echo $documents_replace_save_button_text; ?>
            </button>
          </div>

        </div>
        <span class="error-alert"></span>
      </div>

    </div>

  </div>


</div>
<?php echo $common_footer; ?>


<script>
  $('#file_data').on("change", function () {
    let datafiles = $(" .input-send[type='file']");
    console.log(datafiles[0].files);
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
              $('#document_type').append('<option value="' + document_type['guid'] + '">' + document_type['name'] + '</option>');
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