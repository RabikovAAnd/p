<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $warehouse[ 'name' ]; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="list">
        <div class="info-content-block list">
          <div class="info-content-block end">
            <a href="<?php echo $edit_button_href; ?>">
              <button class="small-button" type="button">
                <?php echo $workplace_customers_address_warehouse_info_edit_button_text; ?>
              </button>
            </a>
          </div>
          <div>
            <span>
              <?php echo $workplace_customers_address_warehouse_info_general_data_guid_text; ?>:
              <?php echo $warehouse[ 'guid' ]; ?>
            </span>
            <br>
            <span>
              <?php echo $workplace_customers_address_warehouse_info_general_data_name_text; ?>:
              <?php echo $warehouse[ 'name' ]; ?>
            </span>
            <br>
            <span>
              <?php echo $workplace_customers_address_warehouse_info_general_data_description_text; ?>:
              <?php echo $warehouse[ 'description' ]; ?>
            </span>
            <br>
            <span>
              <?php echo $workplace_customers_address_warehouse_info_general_data_code_text; ?>:
              <?php echo $warehouse[ 'code' ]; ?>
            </span>
            <br>
            <span>
              <?php echo $workplace_customers_address_warehouse_info_general_data_creation_date_text; ?>:
              <?php echo $warehouse[ 'creation_date' ]; ?>
            </span>
            <br>
            <span>
              <?php echo $workplace_customers_address_warehouse_info_general_data_status_text; ?>:
              <?php echo $warehouse[ 'status' ]; ?>
            </span>


          </div>

        </div>

        <div class="info-content-block list">
          <h2>
            <?php echo $workplace_customers_address_warehouse_info_bins_table_header; ?>
          </h2>
          <div class="info-content-block end">
            <a href="<?php echo $add_bin_button_href; ?>">
              <button class="small-button" type="button">
                <?php echo $workplace_customers_address_warehouse_info_add_button_text; ?>
              </button>
            </a>
          </div>
          <?php if( isset( $bins ) ){ ?>
          <?php if( count( $bins ) > 0){ ?>
          <div class="table-menu-style">
            <div class="bins-table table-menu-header">
          
              <span><b>
                  <?php echo $workplace_customers_address_warehouse_info_bins_table_code_text; ?>
                </b></span>
              <span><b>
                  <?php echo $workplace_customers_address_warehouse_info_bins_table_status_text; ?>
                </b></span>
            </div>

            <?php foreach (  $bins as $bin ){ ?>
            <div id="<?php echo $bin[ 'element_href' ]; ?>" class="bins-table table-menu-element">
              <span>
                <?php echo $bin[ 'code' ]; ?>
              </span>
              <span>
                <?php echo $bin[ 'status' ]; ?>
              </span>
              <div class="table-button-menu" style="display: none;">
                <a href="<?php echo $bin[ 'edit_button_href' ]; ?>"
                  title="<?php echo $workplace_customers_address_warehouse_info_edit_button_hint; ?>">
                  <button type="button">
                    <?php echo $workplace_customers_address_warehouse_info_edit_button_text; ?>
                  </button></a>
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