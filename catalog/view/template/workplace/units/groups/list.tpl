<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_units_groups_header; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="list">
        <div class="info-content-block end">
          <a href="<?php echo $add_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_units_groups_add_type_button_text; ?>
            </button>
          </a>
        </div>

        <div class="table-menu-style">
          <div class="unit-groups-table table-menu-header">
            <span><b><?php echo $workplace_units_groups_types_table_name; ?></b></span>
            <span><b><?php echo $workplace_units_groups_types_table_status; ?></b></span>
          </div>

          <?php foreach ( $unit_groups as $unit_group ) { ?>
          <div id="unit_group_<?php echo $unit_group[ 'element_href' ]; ?>" class="unit-groups-table table-menu-element">
            <span><a href="<?php echo $unit_group[ 'href' ]; ?>">
                <?php echo $unit_group[ 'name' ]; ?>
              </a>
            </span>
            <span>
              <?php echo $unit_group[ 'status' ]; ?>
            </span>
            <div class="table-button-menu" style="display: none;">
              <a href="<?php echo $unit_group[ 'edit_button_href' ]; ?>"
                title="<?php echo $workplace_unit_groups_edit_button_hint; ?>">
                <button type="button">
                  <?php echo $workplace_units_groups_edit_button_text; ?>
                </button></a>

              <button type="button" onMouseDown="File_Form('<?php echo $unit_group[ 'active_button_href' ]; ?>')">
                <?php echo $workplace_units_groups_active_button_text; ?>
              </button>
              <button type="button" onMouseDown="File_Form('<?php echo $unit_group[ 'inactive_button_href' ]; ?>')">
                <?php echo $workplace_units_groups_inactive_button_text; ?>
              </button>
              <button class="red-button" type="button" onMouseDown="File_Form('<?php echo $unit_group[ 'remove_button_href' ]; ?>')">
                <?php echo $workplace_units_groups_remove_button_text; ?>
              </button>

            </div>
          </div>
          <?php } ?>

        </div>
      </div>

    </div>

  </div>

</div>
<?php echo $common_footer; ?>