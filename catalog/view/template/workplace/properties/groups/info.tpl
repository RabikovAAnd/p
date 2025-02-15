<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $group[ 'name' ]; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="list">
        <div class="info-content-block list">
          <h2>
            <?php echo $workplace_properties_info_groups_header; ?>
          </h2>
          <div class="info-content-block end">
            <a href="<?php echo $edit_button_href; ?>">
              <button class="small-button" type="button">
                <?php echo $workplace_properties_info_edit_button_text; ?>
              </button>
            </a>
          </div>
          <div>
            <span>
              <?php echo $workplace_properties_info_general_data_name_text; ?>:
              <?php echo $group[ 'name' ]; ?>
            </span>
            <br>
            <span>
              <?php echo $workplace_properties_info_general_data_status_text; ?>:
              <?php echo $group[ 'status' ]; ?>
            </span>
            <br>
            <span>
              <?php echo $workplace_properties_info_general_data_create_date_text; ?>:
              <?php echo $group[ 'date_added' ]; ?>
            </span>
            <br>
            <span>
              <?php echo $workplace_properties_info_general_data_guid_text; ?>:
              <?php echo $group[ 'guid' ]; ?>
            </span>

          </div>

        </div>

        <div class="info-content-block list">
          <h2>
            <?php echo $workplace_properties_info_properties_header; ?>
          </h2>
          <div class="info-content-block end">
            <a href="<?php echo $add_property_button_href; ?>">
              <button class="small-button" type="button">
                <?php echo $workplace_properties_info_add_property_button_text; ?>
              </button>
            </a>
          </div>
          <?php if( isset( $properties ) ){ ?>
          <div class="table-menu-style">
            <div class="properties-table table-menu-header">
              <span><b>
                  <?php echo $workplace_properties_info_properties_table_name; ?>
                </b></span>
                <span><b>
                    <?php echo $workplace_properties_info_properties_table_units; ?>
                  </b></span>
                <span><b>
                    <?php echo $workplace_properties_info_properties_table_status; ?>
                  </b></span>
            </div>

            <?php foreach (  $properties as $property ){ ?>
            <div id="<?php echo $property[ 'element_href' ]; ?>" class="properties-table table-menu-element">
              <span><a href="<?php echo $property[ 'href' ]; ?>">
                  <?php echo $property[ 'name' ]; ?>
                </a>
              </span>
              <span>
                  <?php echo $property[ 'unit' ][ 'data' ][ 'name' ]; ?>
              </span>
              <span>
                <?php echo $property[ 'status' ]; ?>
              </span>
              <div class="table-button-menu" style="display: none;">
                <a href="<?php echo $property[ 'edit_button_href' ]; ?>"
                  title="<?php echo $workplace_item_property_edit_button_hint; ?>">
                  <button type="button">
                    <?php echo $workplace_properties_info_edit_button_text; ?>
                  </button></a>

                <button class="red-button" type="button"
                  onMouseDown="File_Form('<?php echo $property[ 'remove_button_href' ]; ?>')">
                  <?php echo $workplace_properties_info_remove_button_text; ?>
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

</div>
<?php echo $common_footer; ?>