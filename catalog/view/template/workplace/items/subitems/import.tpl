<?php echo $common_header; ?>

<div id="content">

  <h1><?php echo $workplace_import_subitem_header . ' ' . $item[ 'mpn' ]; ?></h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div id="field" class="info-content-block">
        <div id="import-menu">
          <input id="file" type="file" onchange="showFile(this)" accept=".csv">
          <div id="import-button" onclick="importFile()"></div>
        </div>
        <div id="file-data"></div>
      </div>
    </div>
  </div>
</div>
<?php echo $common_footer; ?>

<script>
  function showFile(input) {

    let file = input.files[0];
    let reader = new FileReader();

    // prepare data
    var data = new FormData();
    data.append("item_guid", '<?php echo $item[ 'guid' ]; ?>');
    data.append("file_data", file);

    $.ajax({
      type: 'POST',
      url: '<?php echo $get_file_button_href; ?>',
      data: data,
      processData: false,
      dataType: 'json',
      contentType: false,
      enctype: 'multipart/form-data',
      success: function (json) {

        if (json['return_code']) {
          $('#file-data').html('');
          // $('#file-data').addClass('units-table');
          $('#file-data').addClass('table-menu-style');
          $('#field').addClass('list');

          $('#import-menu').css({ gap: "var(--global-gap)" });
          $('#file-data').append(
            '<div class="units-table table-menu-header">' +
            '<span><b>' +
            '<?php echo $workplace_import_subitem_units_table_designator_text; ?>' +
            '</b></span>' +
            '<span><b>' +
            '<?php echo $workplace_import_subitem_units_table_quantity_text; ?>' +
            '</b></span>' +
            '<span><b>' +
            '<?php echo $workplace_import_subitem_units_table_id_text; ?>' +
            '</b></span>' +
            '<span><b>' +
            '<?php echo $workplace_import_subitem_units_table_mpn_text; ?>' +
            '</b></span>' +
            '<span><b>' +
            '<?php echo $workplace_import_subitem_units_table_manufacturer_text; ?>' +
            '</b></span>'
            + '</div>');
          $("#import-button").html('');
          $("#import-button").append('<button type="button">Импортировать</button>');

          if (json['subitems']) {
            json['subitems'].forEach((subitem) => {
              if (subitem['valid']) {

                $('#file-data').append(
                  '<div class="units-table table-menu-element">'
                  + '<span id="' + subitem['guid'] + '"> ' + subitem['designator'] + '</span> '
                  + '<span id="' + subitem['guid'] + '"> ' + subitem['quantity'] + '</span>'
                  + '<span id="' + subitem['guid'] + '"> ' + subitem['item_id'] + '</span> '
                  + '<span id="' + subitem['guid'] + '"> ' + '<a href=' + subitem['item_href'] + '>' + subitem['mpn'] + '</a>' + '</span> '
                  + '<span id="' + subitem['guid'] + '">' + subitem['manufacturer_name'] + '</span>'
                  + '</div>');
              }
              else {
                $('#file-data').append(
                  '<div class="units-table table-menu-element not-valid">'
                  + '<span id="' + subitem['guid'] + '">' +
                  subitem['designator'] + '</span>'
                  + '<span id="' + subitem['guid'] + '">' +
                  subitem['quantity'] + '</span>'
                  + '<span id="' + subitem['guid'] + '">' +
                  subitem['item_id'] + '</span>'
                  + '<span id="' + subitem['guid'] + '">'
                  + '<a href=' + subitem['item_href'] + '>' +
                  subitem['mpn'] + '</a>' + '</span>'
                  + '<span id="' + subitem['guid'] + '">' +
                  subitem['manufacturer_name'] + '</span> '
                  + '</div>');
              }


            });

          }

        }

      },
      error: function (jqXHR, exception, json) {
        console.log('XHR: ' + JSON.stringify(jqXHR));
        console.log('exception: ' + exception);
      }
    });
  }

  function importFile() {

    let file = $('#file')[0].files[0];
    let reader = new FileReader();

    // prepare data
    var data = new FormData();
    data.append("item_guid", '<?php echo $item[ 'guid' ] ?>');
    data.append("file_data", file);

    $.ajax({
      type: 'POST',
      url: '<?php echo $import_file_button_href; ?>',
      data: data,
      processData: false,
      dataType: 'json',
      contentType: false,
      enctype: 'multipart/form-data',
      success: function (json) {
        if (json['redirect_url']) {
          if (json['redirect_url'] !== '') {
            window.location.replace(json['redirect_url']);
          }
        }
      },
      error: function (jqXHR, exception, json) {
        alert('Error!');
        console.log('XHR: ' + JSON.stringify(jqXHR));
        console.log('exception: ' + exception);
      }
    });
  }
</script>