<?php echo $common_header; ?>

<div id="content">
  <h1><?php echo $workplace_projects_projects_add_header; ?></h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="info-content-block">

        <div class="list">

          <div class="list">
            <div>
              <label class="checkbox-field">
                <input type="checkbox" id="designator" title="<?php echo $workplace_projects_projects_add_number_search_hint; ?>"
                  class="input-send" checked />
                <span>
                  <?php echo $workplace_projects_projects_add_number_search_label; ?>
                </span>
              </label>
              <label class="checkbox-field">
                <input type="checkbox" id="name" title="<?php echo $workplace_projects_projects_add_name_search_hint; ?>"
                  class="input-send" />
                <span>
                  <?php echo $workplace_projects_projects_add_name_search_label; ?>
                </span>
              </label>
              <label class="checkbox-field">
                <input type="checkbox" id="description" title="<?php echo $workplace_projects_projects_add_description_search_hint; ?>"
                  class="input-send" />
                <span>
                  <?php echo $workplace_projects_projects_add_description_search_label; ?>
                </span>
              </label>
            </div>
          </div>
          <span id="found_count">
            <?php echo $workplace_projects_projects_add_found_count_text; ?>:
            <?php echo $project_count; ?>
          </span>
          <label class="input-text-field" id="search_field">

            <input id="search" list="project_guid_list" title="<?php echo $workplace_projects_projects_add_search_input_hint; ?>"
              placeholder="<?php echo $workplace_projects_projects_add_search_input_placeholder; ?>" />

            <select class="input-send" size="10" id="project_guid">
              <?php foreach ($projects as $project) { ?>
              <option value="<?php echo $project['guid']; ?>">
                <?php echo $project['designator']; ?> -
                <?php echo $project['name']; ?>

              </option>
              <?php }?>
            </select>
          </label>
          <div class="between">
            <a href="<?php echo $cancel_button_href; ?>"><button type="button">
                <?php echo $workplace_projects_projects_add_cancel_button_text; ?>
              </button></a>
            <button
              onMouseDown="File_Form('<?php echo $workplace_add_project_button_href; ?>')">
              <?php echo $workplace_projects_projects_add_add_button_text; ?>
            </button>
          </div>
        </div>
        <span class="error-alert"></span>
      </div>
    </div>


  </div>
</div>
<?php echo $common_footer; ?>
</div>

<script>

  $('#search').keyup(function () {
    page = 1;
    Search(page);
  });
  $('#designator').click(function () {
    page = 1;
    Search(page);
  });
  $('#name').click(function () {
    page = 1;
    Search(page);
  });
  $('#description').click(function () {
    page = 1;
    Search(page);
  });



  function Search(page = 1) {
    $.ajax({
      url: 'index.php?route=workplace/projects/projects/add/Search',
      type: 'POST',
      dataType: 'json',
      data:  'search=' + $('#search').val() +
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