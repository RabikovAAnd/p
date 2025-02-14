<?php echo $common_header; ?>

<div id="content">
  <h1>
    <?php echo $workplace_customers_attributes_add_header; ?>
  </h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="info-content-block">

        <div class="list">

          <div class="list">

          </div>

          <label class="input-text-field">
            <?php echo $workplace_customers_attributes_add_attribute_label; ?>
            <select class="input-send" id="attribute_guid">
              <option value="">
                <?php echo $workplace_customers_attributes_add_attribute_placeholder; ?>
              </option>
              <?php foreach ($attributes as $attribute) { ?>
              <option value="<?php echo $attribute['guid']; ?>">
                <?php echo $attribute['name']; ?>
              </option>
              <?php }?>
            </select>
          </label>
          <label class="input-text-field">
            <?php echo $workplace_customers_attributes_add_value_label; ?>
            <input id="value" type="text" class="input-send" title="<?php echo $workplace_customers_attributes_add_value_hint; ?>"
              placeholder="<?php echo $workplace_customers_attributes_add_value_placeholder; ?>" />
          </label>
          <div class="between">
            <a href="<?php echo $cancel_button_href; ?>"><button type="button">
                <?php echo $workplace_customers_attributes_add_cancel_button_text; ?>
              </button></a>
            <button onMouseDown="File_Form('<?php echo $add_button_href; ?>')">
              <?php echo $workplace_customers_attributes_add_add_button_text; ?>
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

  $('#search').onchange(function () {
    Search(page);
  });




  function Search(page = 1) {
    $.ajax({
      url: 'index.php?route=workplace/projects/projects/add/Search',
      type: 'POST',
      dataType: 'json',
      data: 'search=' + $('#search').val() +
        '&designator=' + $('#designator').is(':checked') +
        '&name=' + $('#name').is(':checked') +
        '&description=' + $('#description').is(':checked') +
        '&page=' + page,
      success: function (json) {
        scroll = false;

        $('#project_guid').html('')
        page_count = json['page_count'];
        $('#found_count').html('<?php echo $workplace_projects_projects_add_found_count_text; ?>: ' + json['project_count']);
        if (json['return_code']) {

          if (json['projects']) {

            json['projects'].forEach((project) => {
              $('#project_guid').append('<option value="' + project['guid'] + '" class="address-block">' +

                project['designator'] + ' - ' + project['name'] +

                '</option>')
            });
          }
        }
      },
      error: function (jqXHR, exception, json) {
        console.log('error ' + exception + ' ' + json['error']);
      }

    });
  }

</script>