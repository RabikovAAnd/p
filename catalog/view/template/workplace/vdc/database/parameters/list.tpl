<?php echo $common_header; ?>
<div id="content">
  <h1><?php echo 'VDC global parameters'; ?></h1>
  
  <div class="account-area">

    <?php echo $workplace_menu; ?>

    <div class="main-area">

      <div class="info-content-block end">
        <a href="<?php echo $parameter_create_href; ?>"><button class="small-button" type="button"><?php echo 'Create'; ?></button></a>
      </div>
<!--
      <div class="info-content-block list">
        <div id="search_field">
          <input id="search" title="<?php echo $workplace_projects_search_input_hint; ?>"
            placeholder="<?php echo $workplace_projects_search_input_placeholder; ?>" />
        </div>
        <div>
          <label class="checkbox-field">
            <input type="checkbox" id="designator" title="<?php echo $workplace_projects_number_search_hint; ?>" class="input-send" checked />
            <span><?php echo $workplace_projects_number_search_label; ?></span>
          </label>
          <label class="checkbox-field">
            <input type="checkbox" id="name" title="<?php echo $workplace_projects_name_search_hint; ?>" class="input-send" />
            <span><?php echo $workplace_projects_name_search_label; ?></span>
          </label>
          <label class="checkbox-field">
            <input type="checkbox" id="description" title="<?php echo $workplace_projects_description_search_hint; ?>" class="input-send" />
            <span><?php echo $workplace_projects_description_search_label; ?></span>
          </label>
        </div>
        <div>
          <span id="found_count">
            <?php echo $workplace_projects_found_count_text; ?>:
            <?php echo $project_count; ?>
          </span>
        </div>
      </div>
-->
      <div class="table-menu-style">

        <div class="parameters-table table-menu-header">
          <span><b><?php echo $workplace_projects_projects_table_number_text; ?></b></span>
          <span><b><?php echo $workplace_projects_projects_table_name_text; ?></b></span>
          <span><b><?php echo 'Datatype'; ?></b></span>
          <span><b><?php echo 'Units'; ?></b></span>
          <span><b><?php echo 'Access' ?></b></span>
          <span><b><?php echo 'Type' ?></b></span>
        </div>

        <?php foreach ( $parameters as $parameter ) { ?>
        <div class="parameters-table table-menu-element">
          <span><?php echo $parameter[ 'parameter_id' ]; ?></span>
          <span><a href="<?php echo $parameter[ 'href' ]; ?>"><?php echo $parameter[ 'name' ]; ?></a></span>
          <span><?php echo $parameter[ 'datatype_name' ]; ?></span>
          <span><?php echo $parameter[ 'units_name' ]; ?></span>
          <span><?php echo $parameter[ 'access_mode_name' ]; ?></span>
          <span><?php echo $parameter[ 'storage_type_name' ]; ?></span>
          <div class="table-button-menu" style="display: none;">
            <button
              onMouseDown="File_Form('<?php echo $parameter_edit_button_href; ?>',[['parameter_guid','<?php echo $parameter[ 'guid' ]; ?>']])">
              <?php echo 'Edit'; ?>
            </button>
          </div>

        </div>
        <?php } ?>

      </div>

    </div>
  </div>
</div>
<?php echo $common_footer; ?>


<script>

  let page = 1;
  let scroll = false;
  let page_count = "<?php echo $page_count; ?>";

  $(window).scroll(function () {
    if (($(this).scrollTop() >= ($('.table-menu-style').height() - $(window).height() * 0.5)) && (page_count > page) && !scroll) {
      scroll = true;
      ++page;
      Search(page);
    }
  })

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
      url: 'index.php?route=workplace/projects/list/search',
      type: 'POST',
      dataType: 'json',
      data: 'search=' + $('#search').val() +
        '&designator=' + $('#designator').is(':checked') +
        '&name=' + $('#name').is(':checked') +
        '&description=' + $('#description').is(':checked') +
        '&page=' + page,
      success: function (json) {
        scroll = false;
        if (page === 1) {
          $('.table-menu-style').html('')
          if (json['projects']) {
            if (json['projects'].length > 0) {
              $('.table-menu-style').append("<div class='projects-table table-menu-header'>"
                + "<span><b>" + "<?php echo $workplace_projects_projects_table_number_text; ?>" + "</b></span>"
                + "<span><b>" + "<?php echo $workplace_projects_projects_table_name_text; ?>" + "</b></span>"
                + "<span><b>" + "<?php echo $workplace_projects_projects_table_status_text; ?>" + "</b></span>"
                + "</div>"
              )
            }
          }
        }
        page_count = json['page_count'];
        $('#found_count').html('<?php echo $workplace_projects_found_count_text; ?>: ' + json['project_count']);
        if (json['return_code']) {

          if (json['projects']) {
            json['projects'].forEach((project) => {
              $('.table-menu-style').append(
                "<div class='projects-table table-menu-element'>"
                + "<span>" + project['designator'] + "</span>"
                + "<span><a href='" + project['href'] + "'>" + project['name'] + "</a></span>"
                + "<span>" + project['status'] + "</span>"
                + "</div>")
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