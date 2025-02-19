<?php echo $common_header; ?>
<div id="content">
  <h1><?php echo $item[ 'product_mpn' ]; ?></h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="info-content-block list">
        <h2>
          <?php echo $workplace_item_general_data_header; ?>
        </h2>
        <div class="info-content-block end">
          <a href="<?php echo $add_item_image_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_item_add_image_button_text; ?>
            </button>
          </a>
          <a href="<?php echo $export_ebay_item_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_item_export_ebay_button_text; ?>
            </button>
          </a>
          <a href="<?php echo $clone_item_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_item_clone_button_text; ?>
            </button>
          </a>
          <a href="<?php echo $edit_item_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_item_edit_button_text; ?>
            </button>
          </a>


          <?php if( $item[ 'favorite' ] === true ){ ?>
          <button class="small-button" id="remove_item_from_favorites"
            onMouseDown="File_Form('<?php echo $remove_item_from_favorites_button_href; ?>',[['item_guid','<?php echo $item[ 'guid' ]; ?>'],['remove',false]])">
            <?php echo $workplace_item_remove_item_from_favorites_button_text; ?>
          </button>
          <?php } else { ?>
          <button class="small-button" id="add_item_to_favorites"
            onMouseDown="File_Form('<?php echo $add_item_to_favorites_button_href; ?>',[['item_guid','<?php echo $item[ 'guid' ]; ?>']])">
            <?php echo $workplace_item_add_item_to_favorites_button_text; ?>
          </button>
          <?php } ?>
        </div>
        <div class="general-info">
          <?php if( isset( $item[ 'main_image' ] ) === true ) { ?>
          <img class="main-item-image"
          src="data:<?php echo $item[ 'main_image' ][ 'image_type' ]; ?>;base64,<?php echo $item[ 'main_image' ][ 'image_data' ]; ?>"/>
          <?php } else { ?>
          <img class="main-item-image" src="./image/default/no_image.jpg"/>
          <?php } ?>
          <div class="general-info-text">
            <span>
              <?php echo $workplace_item_general_data_id_text; ?>:
              <?php echo $item[ 'item_id' ]; ?>
            </span>
            <span>
              <?php echo $workplace_item_general_data_guid_text; ?>:
              <?php echo $item[ 'guid' ]; ?>
            </span>
            <span>
              <?php echo $workplace_item_general_data_atomic_item_text; ?>:
              <?php if( $item[ 'atomic_item' ] === true ){ ?>
              <?php echo $workplace_item_general_data_atomic_item_true; ?>
              <?php } else { ?>
              <?php echo $workplace_item_general_data_atomic_item_false; ?>
              <?php } ?>
            </span>
            <span>
              <?php echo $workplace_item_general_data_mpn_text; ?>:
              <?php echo $item[ 'product_mpn' ]; ?>
            </span>
            <span>
              <?php echo $workplace_item_general_data_order_code_text; ?>:
              <?php echo $item[ 'order_code' ]; ?>
            </span>
            <span>
              <?php echo $workplace_item_general_data_manufacturer_text; ?>:
              <?php echo $item[ 'manufacturer_name' ]; ?>
            </span>
            <span>
              <?php echo $workplace_item_general_data_description_text; ?>:
              <?php echo $item[ 'description' ]; ?>
            </span>

          </div>
        </div>
        <?php if( isset( $item[ 'images' ] ) === true ) { ?>
          <div class="gallery">
            <?php foreach ( $item[ 'images' ] as $image ) { ?>
              <img src="data:<?php echo $image[ 'image_type' ]; ?>;base64,<?php echo $image[ 'image_data' ]; ?>"/>
            <?php } ?>
          </div>
        <?php } ?>
          
        
      </div>

      <div class="info-content-block list">
        <h2>
          <?php echo $workplace_item_properties_header; ?>
        </h2>
        <div class="info-content-block end">
          <a href="<?php echo $add_property_button_href; ?>">
            <button class="small-button">
              <?php echo $workplace_item_add_property_button_text; ?>
            </button>
          </a>
        </div>
        <?php if( count( $groups )>0 ){ ?>
        <div class="list">

          <?php foreach ( $groups as $group ){ ?>

          <span class="text-right" title="<?php echo $group[ 'group_data' ][ 'description' ]; ?>"><b>
              <?php echo $group[ 'group_data' ][ 'name' ]; ?>
            </b></span>

          <div class="table-menu-style">
            <div class="properties-table table-menu-header">
              <span><b>
                  <?php echo $workplace_item_properties_table_property_name; ?>
                </b></span>
                <span class="property_value_header"><b>
                    <?php echo $workplace_item_properties_table_property_value; ?>
                  </b></span>

            </div>

            <?php foreach ( $group[ 'property_data' ] as $property_data ){ ?>
            <div id="<?php echo $property_data[ 'element_href' ]; ?>" class="properties-table table-menu-element">
              <span>
                <?php echo $property_data[ 'name' ]; ?>
              </span>
              <span class="property_value">
                <?php echo $property_data[ 'value' ]; ?> <?php echo $property_data[ 'unit_symbol' ]; ?>
              </span>

              <div class="table-button-menu" style="display: none;">
                <a href="<?php echo $property_data[ 'edit_button_href' ]; ?>"
                  title="<?php echo $workplace_item_property_edit_button_hint; ?>">
                  <button type="button">
                    <?php echo $workplace_item_property_edit_button_text; ?>
                  </button></a>

                <button class="red-button" type="button"
                  onMouseDown="File_Form('<?php echo $property_data[ 'remove_button_href' ]; ?>',[['item_guid','<?php echo $item[ 'guid' ]; ?>'],['property_guid','<?php echo $property_data[ 'property_guid' ]; ?>']])">
                  <?php echo $workplace_item_property_remove_button_text; ?>
                </button>
              </div>
            </div>

            <?php } ?>

          </div>

          <?php } ?>
        </div>
        <?php } ?>
      </div>

      <?php if ( $item[ 'atomic_item' ] === false ) { ?>
      <div class="info-content-block list">
        <h2>
          <?php echo $workplace_item_assembly_units_header; ?>
        </h2>
        <div class="info-content-block end">
          <?php if( count( $subitems ) > 0 ) { ?>
          <a href="<?php echo $subitems_export_bom_button_href; ?>">
            <button class="small-button" type="button"
              title="<?php echo $workplace_item_subitems_export_bom_button_hint; ?>">
              <?php echo $workplace_item_subitems_export_bom_button_text; ?>
            </button></a>
          <a href="<?php echo $subitems_export_smt_button_href; ?>">
            <button class="small-button" type="button"
              title="<?php echo $workplace_item_subitems_export_smt_button_hint; ?>">
              <?php echo $workplace_item_subitems_export_smt_button_text; ?>
            </button></a>
          <?php } ?>
          <a href="<?php echo $subitems_import_button_href; ?>">
            <button class="small-button" type="button"
              title="<?php echo $workplace_item_subitems_import_button_hint; ?>">
              <?php echo $workplace_item_subitems_import_button_text; ?>
            </button></a>
          <a href="<?php echo $subitem_add_button_href; ?>">
            <button class="small-button" type="button" title="<?php echo $workplace_item_subitem_add_button_hint; ?>">
              <?php echo $workplace_item_subitem_add_button_text; ?>
            </button></a>
        </div>
        <?php if( count( $subitems ) > 0 ) { ?>
        <div class="table-menu-style">
          <div class="units-table table-menu-header">
            <span><b>
                <?php echo $workplace_item_units_table_position_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_item_units_table_quantity_text; ?>
              </b></span>
            <div class="subitems-info">
              <span><b>
                  <?php echo $workplace_item_units_table_id_text; ?>
                </b></span>
              <span><b>
                  <?php echo $workplace_item_units_table_mpn_text; ?>
                </b></span>
              <span><b>
                  <?php echo $workplace_item_units_table_mfg_text; ?>
                </b></span>
            </div>
          </div>

          <?php foreach ( $subitems as $subitem ) { ?>
          <div id="<?php echo $subitem[ 'element_href' ]; ?>" class="units-table table-menu-element">
            <span>
              <?php echo $subitem[ 'designator' ]; ?>
            </span>
            <span>
              <?php echo $subitem[ 'quantity' ]; ?>
            </span>
            <div class="subitems">
              <div class="subitems-info">
                <span>
                  <?php echo $subitem[ 'item_id' ]; ?>
                </span>
                <span><a href="<?php echo $subitem[ 'subitem_href' ]; ?>">
                    <?php echo $subitem[ 'mpn' ]; ?>
                  </a></span>
                <span>
                  <?php echo $subitem[ 'manufacturer_name' ]; ?>
                </span>
              </div>
              <?php foreach ( $subitem[ 'alternatives' ] as $alternative ) { ?>
              <div class="subitems-info">
                <span>
                  <?php echo $alternative[ 'item_id' ]; ?>
                </span>
                <span><a href="<?php echo $alternative[ 'href' ]; ?>">
                    <?php echo $alternative[ 'mpn' ]; ?>
                  </a></span>
                <span>
                  <?php echo $alternative[ 'manufacturer_name' ]; ?>
                </span>
              </div>
              <?php } ?>
            </div>

            <div class="table-button-menu" style="display: none;">
              <a href="<?php echo $subitem[ 'add_subitem_alternatives_button_href' ]; ?>"
                title="<?php echo $workplace_item_add_subitem_alternatives_button_hint; ?>">
                <button type="button">
                  <?php echo $workplace_item_add_subitem_alternatives_button_text; ?>
                </button></a>
              <a href="<?php echo $subitem[ 'edit_button_href' ]; ?>"
                title="<?php echo $workplace_item_subitem_edit_button_hint; ?>">
                <button type="button">
                  <?php echo $workplace_item_subitem_edit_button_text; ?>
                </button></a>
              <a href="<?php echo $subitem[ 'replace_button_href' ]; ?>"
                title="<?php echo $workplace_item_subitem_replace_button_hint; ?>">
                <button type="button">
                  <?php echo $workplace_item_subitem_replace_button_text; ?>
                </button></a>
              <button class="red-button" type="button" title="<?php echo $workplace_item_subitem_remove_button_hint; ?>"
                onMouseDown="File_Form('<?php echo $subitem[ 'remove_button_href' ]; ?>',[['subitem_index_guid','<?php echo $subitem[ 'subitem_index_guid' ]; ?>']])">
                <?php echo $workplace_item_subitem_remove_button_text; ?>
              </button>
              <!-- <a href="<?php/* echo $subitem[ 'properties_href' ]; */?>" title=""><button type="button">Properties</button></a> -->
            </div>
          </div>

          <?php } ?>
        </div>
        <?php } ?>
      </div>
      <?php } ?>

      <div class="info-content-block list">
        <h2>
          <?php echo $workplace_item_documents_header; ?>
        </h2>
        <div class="info-content-block end">
          <a href="<?php echo $add_document_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_item_add_document_button_text; ?>
            </button></a>
        </div>

        <?php if( count( $documents )>0 ){ ?>
        <div class="table-menu-style">
          <div class="documents-table table-menu-header">
            <span><b>
                <?php echo $workplace_item_documents_table_name_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_item_documents_table_date_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_item_documents_table_number_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_item_documents_table_version_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_item_documents_table_revision_text; ?>
              </b></span>
          </div>

          <?php foreach ( $documents as $document ){ ?>
          <div id="<?php echo $document[ 'element_href' ]; ?>" class="documents-table table-menu-element">

            <span><a href="<?php echo $document[ 'href' ]; ?>">
                <?php echo $document[ 'name' ]; ?>
              </a></span>
            <span>
              <?php echo $document[ 'date' ]; ?>
            </span>
            <span>
              <?php echo $document[ 'number' ]; ?>
            </span>
            <span>
              <?php echo $document[ 'version' ]; ?>
            </span>
            <span>
              <?php echo $document[ 'revision' ]; ?>
            </span>
            <div class="table-button-menu" style="display: none;">
              <button class="red-button" type="button"
                title="<?php echo $workplace_item_delete_document_button_hint; ?>"
                onMouseDown="File_Form('<?php echo $document[ 'remove_button_href' ]; ?>',[['item_guid','<?php echo $item[ 'guid' ]; ?>'],['document_guid','<?php echo $document[ 'document_guid' ]; ?>']])">
                <?php echo $workplace_item_delete_document_button_text; ?>
              </button>
              <a href="<?php echo $document[ 'replace_button_href' ]; ?>"><button
                type="button"><?php echo $workplace_item_replace_document_button_text; ?></button></a>
            </div>
          </div>
          <?php } ?>
        </div>
        <?php } ?>

      </div>

      <div class="info-content-block list">
        <h2>
          <?php echo $workplace_item_task_table_header; ?>
        </h2>
        <div class="info-content-block end">
          <a href="<?php echo $add_task_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_item_add_task_button_text; ?>
            </button></a>
        </div>
        <?php if( count( $tasks ) > 0 ) { ?>
        <!--        <div class="task-table table-style"> -->
        <div class="table-menu-style">
          <div class="task-table table-menu-header">
            <span><b>
                <?php echo $workplace_item_task_table_header_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_item_task_table_priority_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_item_task_table_status_text; ?>
              </b></span>
            <!--          <span><b><?php echo 'Date'/*$workplace_item_task_table_create_date_text;*/ ?></b></span> -->
            <!--          <span><b><?php /*echo $workplace_item_task_table_dates_text;*/ ?></b></span> -->
            <!--          <span><b><?php /*echo $workplace_item_task_table_lead_time_text;*/ ?></b></span> -->
            <!--          <span><b><?php /*echo $workplace_item_task_table_creator_executor_text;*/ ?></b></span> -->
          </div>

          <?php foreach ($tasks as $task) { ?>
          <div class="task-table table-menu-element">
            <span>
              <?php echo $task[ 'header' ]; ?>
            </span>
            <span>
              <?php echo $task[ 'priority' ]; ?>
            </span>
            <span>
              <?php echo $task[ 'status' ]; ?>
            </span>
            <!--            <span><?php echo $task[ 'create_date' ]; ?><br><?php echo $task['date_start']; ?><br><?php echo $task['deadline']; ?></span> -->
            <!--            <span><?php echo $task[ 'lead_time' ]; ?></span> -->
            <!--            <span><?php echo $task[ 'creator' ]; ?><br><br><?php echo $task['customer']; ?></span> -->
            <div class="table-button-menu" style="display: none;">
              <!--                <?php echo $task['description']; ?> -->
              <a href="<?php echo $task[ 'info_button_href' ]; ?>" title="Show detailed task information."><button
                  type="button">Information</button></a>
            </div>
          </div>

          <!--
            <div id="<?php echo $task['id']; ?>" class="buttons">

              <?php if ( $task['delete_button_enabled'] === true ) { ?>
                <button type="button"
                id="<?php echo $task[ 'id' ]; ?>"
                onMouseDown="File_Form('<?php echo $delete_task_button_href; ?>',[['task_id',event.target.id]])">
                <?php echo $workplace_item_delete_task_button_text; ?>
                </button>
              <?php } ?>

              <?php if ( $task[ 'edit_button_enabled' ] === true ) { ?>
                <a href="<?php echo $task[ 'edit_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_item_edit_task_button_text; ?></button>
                </a>
              <?php } ?>

              <?php if ( $task[ 'confirm_button_enabled' ] === true ) { ?>
                <a href="<?php echo $task[ 'confirm_task_href' ]; ?>">
                  <button type="button" class="green-button"><?php echo $workplace_item_confirm_task_button_text; ?></button>
                </a>
              <?php } ?>

              <?php if ( $task[ 'discard_button_enabled' ] === true ) { ?>
                <a href="<?php echo $task[ 'discard_task_href' ]; ?>">
                  <button type="button" class="red-button"><?php echo $workplace_item_discard_task_button_text; ?></button>
                </a>
              <?php } ?>

              <?php if ( $task[ 'assign_developer_button_enabled' ] === true ) { ?>
                <a href="<?php echo $task[ 'assign_developer_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_item_assign_developer_task_button_text; ?></button>
                </a>
              <?php } ?>

              <?php if ( $task[ 'start_button_enabled' ] === true ) { ?>
                <a href="<?php echo $task[ 'start_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_item_start_task_button_text; ?></button>
                </a>
              <?php } ?>

              <?php if ( $task[ 'reject_button_enabled' ] === true ) { ?>
                <a href="<?php echo $task[ 'reject_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_item_reject_task_button_text; ?></button>
                </a>
              <?php } ?>

              <?php if ( $task[ 'done_button_enabled' ] === true ) { ?>
                <a href="<?php echo $task[ 'done_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_item_done_task_button_text; ?></button>
                </a>
              <?php } ?>

              <?php if ( $task[ 'pause_button_enabled' ] === true ) { ?>
                <a href="<?php echo $task[ 'pause_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_item_pause_button_text; ?></button>
                </a>
              <?php } ?>

              <?php if ( $task[ 'resume_button_enabled' ] === true ) { ?>
                <a href="<?php echo $task[ 'resume_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_item_resume_button_text; ?></button>
                </a>
              <?php } ?>

              <?php if ( $task[ 'assign_verifier_button_enabled' ] === true ) { ?>
                <a href="<?php echo $task[ 'assign_verifier_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_item_assign_verifier_button_text; ?></button>
                </a>
              <?php } ?>

              <?php if ( $task[ 'verify_button_enabled' ] === true ) { ?>
                <a href="<?php echo $task[ 'verify_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_item_verify_button_text; ?></button>
                </a>
              <?php } ?>

              <?php if ( $task[ 'accept_button_enabled' ] === true ) { ?>
                <a href="<?php echo $task[ 'accept_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_item_accept_button_text; ?></button>
                </a>
              <?php } ?>

              <?php if ( $task[ 'reopen_button_enabled' ] === true ) { ?>
                <a href="<?php echo $task[ 'reopen_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_item_reopen_button_text; ?></button>
                </a>
              <?php } ?>

              <?php if ( $task[ 'decline_button_enabled' ] === true ) { ?>
                <a href="<?php echo $task[ 'decline_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_item_decline_button_text; ?></button>
                </a>
              <?php } ?>

              <?php if ( $task[ 'observe_button_enabled' ] === true ) { ?>
                <button type="button" class="inactive-button"><?php echo $workplace_item_observe_task_button_text; ?></button>
              <?php } ?>

              <?php if ( $task[ 'delegate_button_enabled' ] === true ) { ?>
                <button type="button" class="inactive-button"><?php echo $workplace_item_delegate_task_button_text; ?></button>
              <?php } ?>

              <?php if ( $task[ 'move_button_enabled' ] === true ) { ?>
                <button type="button" class="inactive-button"><?php echo $workplace_item_move_task_button_text; ?></button>
              <?php } ?>

              <?php if ( $task[ 'close_button_enabled' ] === true ) { ?>
                <button type="button" class="inactive-button"><?php echo $workplace_item_close_task_button_text; ?></button>
              <?php } ?>

            </div>
-->
          <?php }?>

        </div>
        <?php } ?>
      </div>

      <div class="info-content-block list">
        <h2>Наличие на складах</h2>
        <div class="info-content-block end">
          <a href="<?php echo $purchase_button_href; ?>">
            <button class="small-button" type="button">Закупить</button>
          </a>
        </div>
        <div class="table-menu-style">
          <div class="warehouse-table table-menu-header">
            <span><b>Название склада</b></span>
            <span><b>Дата поступления</b></span>
            <span><b>Лот</b></span>
            <span><b>Количество</b></span>
          </div>
          <?php foreach ( $documents as $document ) { ?>
          <div  id="<?php echo $document[ 'element_href' ]; ?>"  class="warehouse-table table-menu-element">
            <span>
              <?php echo $document[ 'date' ]; ?>
            </span>
            <span>
              <?php echo $document[ 'number' ]; ?>
            </span>
            <span>
              <?php echo $document[ 'version' ]; ?>
            </span>
            <span>
              <?php echo $document[ 'revision' ]; ?>
            </span>
          </div>
          <?php } ?>
        </div>
      </div>

      <div class="info-content-block list">
        <h2>Поставщики</h2>
        <div class="info-content-block end">
          <a href="<?php echo $add_supplier_button_href; ?>">
            <button class="small-button" type="button">Добавить</button>
          </a>
        </div>
        <?php if( count( $suppliers )>0  ) { ?>
        <div class="table-menu-style">
          <div class="supplier-table table-menu-header">
            <span><b>Поставщик</b></span>
            <span><b>Интернет-сайт</b></span>
            <span><b>Адрес электронной почты</b></span>
            <span><b>Телефон</b></span>
          </div>
          <?php foreach ( $suppliers as $supplier ) { ?>
          <div id="<?php echo $supplier[ 'element_href' ]; ?>" class="supplier-table table-menu-element">
            <?php if( strlen( $supplier[ 'company_name' ] ) > 0 ) { ?>
            <span><a href="<?php echo $supplier[ 'supplier_href' ]; ?>">
                <?php echo $supplier[ 'company_name' ]; ?>
              </a></span>
            <?php }else{?>
            <span><a href="<?php echo $supplier[ 'supplier_href' ]; ?>">
                <?php echo $supplier[ 'lastname' ]; ?>
                <?php echo $supplier[ 'name' ]; ?>
              </a></span>
            <?php } ?>
            <span></span>
            <span>
              <?php echo $supplier[ 'email' ]; ?>
            </span>
            <span>
              <?php echo $supplier[ 'phone' ]; ?>
            </span>
            <div class="table-button-menu" style="display: none;">
              <button class="red-button" type="button"
                title="<?php echo $workplace_item_delete_supplier_button_hint; ?>"
                onMouseDown="File_Form('<?php echo $supplier[ 'remove_button_href' ]; ?>',[['item_guid','<?php echo $item[ 'guid' ]; ?>'],['supplier_guid','<?php echo $supplier[ 'supplier_guid' ]; ?>']])">
                <?php echo $workplace_item_delete_supplier_button_text; ?>
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

<script>

  $(document).ready(function () {
    let tasks_buttons = $('.buttons').toArray();
    tasks_buttons.forEach((element) => {
      if ($(element).children().length == 0) {
        $(element).hide();
      }
    });
  });

</script>