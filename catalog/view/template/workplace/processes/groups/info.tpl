<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $processes_group[ 'data' ][ 'name' ]; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="list">
        <div class="info-content-block list">
          <div class="info-content-block end">
            <a href="<?php echo $edit_button_href; ?>">
              <button class="small-button" type="button">
                <?php echo $workplace_processes_groups_info_edit_button_text; ?>
              </button>
            </a>
          </div>
          <div>
            <span>
              <?php echo $workplace_processes_groups_info_general_data_guid_text; ?>:
              <?php echo $processes_group[ 'data' ][ 'guid' ]; ?>
            </span>
            <br>
            <span>
              <?php echo $workplace_processes_groups_info_general_data_create_date_text; ?>:
              <?php echo $processes_group[ 'data' ][ 'creation_date' ]; ?>
            </span>
            <br>
            <span>
              <?php echo $workplace_processes_groups_info_general_data_modification_date_text; ?>:
              <?php echo $processes_group[ 'data' ][ 'modification_date' ]; ?>
            </span>
            <br>
            <span>
              <?php echo $workplace_processes_groups_info_general_data_status_text; ?>:
              <?php echo $processes_group[ 'data' ][ 'status' ]; ?>
            </span>


          </div>

        </div>

        <div class="info-content-block list">
          <h2>
            <?php echo $workplace_processes_groups_info_processes_header; ?>
          </h2>
          <div class="info-content-block end">
            <a href="<?php echo $add_process_button_href; ?>">
              <button class="small-button" type="button">
                <?php echo $workplace_processes_groups_info_add_process_button_text; ?>
              </button>
            </a>
          </div>
          <?php if( isset( $processes ) ){ ?>
            <?php if( count( $processes ) > 0){ ?>
            <div class="table-menu-style">
              <div class="processes-table table-menu-header">
                <span><b>
                    <?php echo $workplace_processes_groups_info_processes_table_name; ?>
                  </b></span>
                <span><b>
                    <?php echo $workplace_processes_groups_info_processes_table_status; ?>
                  </b></span>
              </div>

              <?php foreach (  $processes as $process ){ ?>
              <div id="<?php echo $process[ 'element_href' ]; ?>" class="processes-table table-menu-element">
                <span>
                    <?php echo $process[ 'name' ]; ?>
                </span>
                <span>
                  <?php echo $process[ 'status' ]; ?>
                </span>
                <div class="table-button-menu" style="display: none;">
                  <a href="<?php echo $process[ 'edit_button_href' ]; ?>"
                    title="<?php echo $workplace_processes_groups_info_edit_button_hint; ?>">
                    <button type="button">
                      <?php echo $workplace_processes_groups_info_edit_button_text; ?>
                    </button></a>

                    <button type="button" onMouseDown="File_Form('<?php echo $process[ 'active_button_href' ]; ?>')">
                      <?php echo $workplace_processes_groups_info_active_button_text; ?>
                    </button>
                    <button type="button" onMouseDown="File_Form('<?php echo $process[ 'inactive_button_href' ]; ?>')">
                      <?php echo $workplace_processes_groups_info_inactive_button_text; ?>
                    </button>
                  <button class="red-button" type="button"
                    onMouseDown="File_Form('<?php echo $process[ 'remove_button_href' ]; ?>')">
                    <?php echo $workplace_processes_groups_info_remove_button_text; ?>
                  </button>
                </div>
              </div>
              <?php } ?>
            <?php } ?>
          </div>

          <?php } ?>
        </div>

      </div>

    </div>
  </div>

<?php echo $common_footer; ?>