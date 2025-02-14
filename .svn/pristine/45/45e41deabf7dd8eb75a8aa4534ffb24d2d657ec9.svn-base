<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_processes_groups_header; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="list">
        <div class="info-content-block end">
          <a href="<?php echo $add_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_processes_groups_add_type_button_text; ?>
            </button>
          </a>
        </div>

        <?php if( isset( $processes_groups ) && count( $processes_groups )>0){ ?>
        <div class="table-menu-style">
          <div class="processes-groups-table table-menu-header">
            <span><b>
                <?php echo $workplace_processes_groups_processes_groups_table_name; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_processes_groups_processes_groups_table_status; ?>
              </b></span>
          </div>
          <?php foreach ( $processes_groups as $processes_group ) { ?>
          <div id="<?php echo $processes_group[ 'element_href' ]; ?>" class="processes-groups-table table-menu-element">
            <span><a href="<?php echo $processes_group[ 'href' ]; ?>">
                <?php echo $processes_group[ 'name' ]; ?>
              </a>
            </span>
            <span>
              <?php echo $processes_group[ 'status' ]; ?>
            </span>
            <div class="table-button-menu" style="display: none;">
              <a href="<?php echo $processes_group[ 'edit_button_href' ]; ?>"
                title="<?php echo $workplace_unit_groups_edit_button_hint; ?>">
                <button type="button">
                  <?php echo $workplace_processes_groups_edit_button_text; ?>
                </button></a>

              <button type="button" onMouseDown="File_Form('<?php echo $processes_group[ 'active_button_href' ]; ?>')">
                <?php echo $workplace_processes_groups_active_button_text; ?>
              </button>
              <button type="button"
                onMouseDown="File_Form('<?php echo $processes_group[ 'inactive_button_href' ]; ?>')">
                <?php echo $workplace_processes_groups_inactive_button_text; ?>
              </button>
              <button class="red-button" type="button"
                onMouseDown="File_Form('<?php echo $processes_group[ 'remove_button_href' ]; ?>')">
                <?php echo $workplace_processes_groups_remove_button_text; ?>
              </button>

            </div>
          </div>
          <?php } ?>

        </div>
        <?php } ?>
      </div>

    </div>

  </div>

</div>
<?php echo $common_footer; ?>