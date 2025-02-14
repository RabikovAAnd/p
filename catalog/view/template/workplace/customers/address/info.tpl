<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo  $address[ 'address_text' ]; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="list">
        <div class="info-content-block list">
          <div class="info-content-block end">
            <a href="<?php echo $edit_button_href; ?>">
              <button class="small-button" type="button">
                <?php echo $workplace_customers_address_info_edit_button_text; ?>
              </button>
            </a>
          </div>
          <div>
            <span>
              <?php echo $workplace_customers_address_info_general_data_guid_text; ?>:
              <?php echo $address[ 'guid' ]; ?>
            </span>
            <br>
            <span>
              <?php echo $workplace_customers_address_info_general_data_address_text; ?>:
              <?php echo $address[ 'address_text' ]; ?>
            </span>
            <br>
            <span>
              <?php echo $workplace_customers_address_info_general_data_status_text; ?>:
              <?php echo $address[ 'active' ]; ?>
            </span>


          </div>

        </div>

        <div class="info-content-block list">
          <h2>
            <?php echo $workplace_customers_address_info_warehouses_table_header; ?>
          </h2>
          <div class="info-content-block end">
            <a href="<?php echo $add_warehouse_button_href; ?>">
              <button class="small-button" type="button">
                <?php echo $workplace_customers_address_info_add_warehouse_button_text; ?>
              </button>
            </a>
          </div>
          <?php if( isset( $warehouses ) ){ ?>
          <?php if( count( $warehouses ) > 0){ ?>
          <div class="table-menu-style">
            <div class="warehouses-table table-menu-header">
              <span><b>
                  <?php echo $workplace_customers_address_info_warehouses_table_name_text; ?>
                </b></span>
              <span><b>
                  <?php echo $workplace_customers_address_info_warehouses_table_code_text; ?>
                </b></span>
              <span><b>
                  <?php echo $workplace_customers_address_info_warehouses_table_status_text; ?>
                </b></span>
            </div>

            <?php foreach (  $warehouses as $warehouse ){ ?>
            <div id="<?php echo $warehouse[ 'element_href' ]; ?>" class="warehouses-table table-menu-element">
              <span><a href="<?php echo $warehouse[ 'href' ]; ?>">
                  <?php echo $warehouse[ 'name' ]; ?>
                </a>
              </span>
              <span>
                <?php echo $warehouse[ 'code' ]; ?>
              </span>
              <span>
                <?php echo $warehouse[ 'status' ]; ?>
              </span>
              <div class="table-button-menu" style="display: none;">
                <a href="<?php echo $warehouse[ 'edit_button_href' ]; ?>"
                  title="<?php echo $workplace_customers_address_info_edit_button_hint; ?>">
                  <button type="button">
                    <?php echo $workplace_customers_address_info_edit_button_text; ?>
                  </button></a>
                <!-- 

                    <button type="button" onMouseDown="File_Form('<?php echo $unit[ 'active_button_href' ]; ?>')">
                      <?php echo $workplace_customers_address_info_active_button_text; ?>
                    </button>
                    <button type="button" onMouseDown="File_Form('<?php echo $unit[ 'inactive_button_href' ]; ?>')">
                      <?php echo $workplace_customers_address_info_inactive_button_text; ?>
                    </button>
                  <button class="red-button" type="button"
                    onMouseDown="File_Form('<?php echo $unit[ 'remove_button_href' ]; ?>')">
                    <?php echo $workplace_customers_address_info_remove_button_text; ?>
                  </button> -->
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