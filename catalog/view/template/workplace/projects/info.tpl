<?php echo $common_header; ?>
<div id="content">
  <h1><?php echo $project[ 'designator' ] . " - " . $project[ 'name' ]; ?></h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">

      <div class="info-content-block list">
        <h2>
          <?php echo $workplace_project_general_data_header; ?>
        </h2>
        <div class="info-content-block end">
          <a href="<?php echo $edit_project_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_project_edit_button_text; ?>
            </button>
          </a>
          <a href="<?php echo $clone_project_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_project_clone_button_text; ?>
            </button>
          </a>
          <?php if( $project[ 'favorite' ] === true ){ ?>
          <button class="small-button" type="button" id="remove_item_from_favorites"
            onMouseDown="File_Form('<?php echo $remove_project_from_favorites_button_href; ?>',[['guid','<?php echo $project[ 'guid' ]; ?>'],['remove',false]])">
            <?php echo $workplace_project_remove_project_from_favorites_button_text; ?>
          </button>
          <?php } else { ?>
          <button class="small-button" id="add_item_to_favorites"
            onMouseDown="File_Form('<?php echo $add_project_to_favorites_button_href; ?>',[['guid','<?php echo $project[ 'guid' ]; ?>']])">
            <?php echo $workplace_project_add_project_to_favorites_button_text; ?>
          </button>
          <?php } ?>
        </div>
        <div class="general-info">
          <div>
            <span>
              <?php echo $workplace_project_general_data_guid_text; ?>:
              <?php echo $project[ 'guid' ]; ?>
            </span>
            <span>
              <?php echo $workplace_project_general_data_number_text; ?>:
              <?php echo $project[ 'designator' ]; ?>
            </span>
            <span>
              <?php echo $workplace_project_general_data_create_date_text; ?>:
              <?php echo $project[ 'create_date' ]; ?>
            </span>
            <span>
              <?php echo $workplace_project_general_data_name_text; ?>:
              <?php echo $project[ 'name' ]; ?>
            </span>
            <span>
              <?php echo $workplace_project_general_data_description_text; ?>:
              <?php echo $project[ 'description' ]; ?>
            </span>
          </div>
        </div>
      </div>


      <div class="list info-content-block">
        <h2>
          <?php echo $workplace_project_projects_header; ?>
        </h2>
        <div class="end info-content-block">
          <a href="<?php echo $add_project_href; ?>">
            <button type="button" class="small-button">
              <?php echo $workplace_project_add_project_button_text; ?>
            </button>
          </a>
        </div>
        <?php if( isset( $projects ) ){ ?>
        <div class="table-menu-style">
          <div class="projects-table table-menu-header">
            <span><b>
                <?php echo $workplace_project_projects_table_designator_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_project_projects_table_name_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_project_projects_table_status_text; ?>
              </b></span>
          </div>
          <?php foreach ( $projects as $project ){ ?>
          <div id="<?php echo $project[ 'element_href' ]; ?>" class="projects-table table-menu-element">
            <span>
              <?php echo $project[ 'designator' ]; ?>
            </span>
            <span><a href="<?php echo $project[ 'href' ]; ?>">
                <?php echo $project[ 'name' ]; ?>
              </a></span>
            <span>
              <?php echo $project[ 'status' ]; ?>
            </span>
            <div class="table-button-menu" style="display: none;">
              <button class="red-button"
                onMouseDown="File_Form('<?php echo $project['remove_href']; ?>')">
                <?php echo $workplace_project_project_delete_button_text; ?>
              </button>
            </div>
          </div>
          <?php } ?>
        </div>
        <?php } ?>
      </div>

      <div class="list info-content-block">
        <h2>
          <?php echo $workplace_project_items_header; ?>
        </h2>
        <div class="end info-content-block">
          <a href="<?php echo $add_item_href; ?>">
            <button type="button" class="small-button">
              <?php echo $workplace_project_add_item_button_text; ?>
            </button>
          </a>
        </div>
        <?php if( count( $items ) > 0 ){ ?>
        <div class="table-menu-style">
          <div class="items-table table-menu-header">
            <span><b>
                <?php echo $workplace_project_items_table_id_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_project_items_table_mpn_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_project_items_table_mfg_text; ?>
              </b></span>
          </div>
          <?php foreach ( $items as $item ){ ?>
          <div id="<?php echo $item[ 'element_href' ]; ?>" class="items-table table-menu-element">
            <span>
              <?php echo $item[ 'item_id' ]; ?>
            </span>
            <span><a href="<?php echo $item[ 'item_href' ]; ?>">
                <?php echo $item[ 'mpn' ]; ?>
              </a></span>
            <span>
              <?php echo $item[ 'mfg' ]; ?>
            </span>
            <div class="table-button-menu" style="display: none;">
              <button class="red-button"
                onMouseDown="File_Form('<?php echo $item[ 'remove_href' ]; ?>')">
                <?php echo $workplace_project_item_delete_button_text; ?>
              </button>
            </div>
          </div>
          <?php } ?>
        </div>
        <?php } ?>
      </div>

      <div class="info-content-block list">
        <h2>
          <?php echo $workplace_project_documents_header; ?>
        </h2>
        <div class="end info-content-block">
          <button type="button" class="small-button">
            <?php echo $workplace_project_add_document_button_text; ?>
          </button>
        </div>

        <?php if( count( $documents ) > 0 ) { ?>
        <div class="table-menu-style">
          <div class="documents-table table-menu-header">
            <span><b>
                <?php echo $workplace_project_documents_table_name_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_project_documents_table_date_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_project_documents_table_number_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_project_documents_table_version_text; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_project_documents_table_revision_text; ?>
              </b></span>
          </div>

          <?php foreach ( $documents as $document ) { ?>
          <div class="documents-table table-menu-element">
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
          </div>
          <?php } ?>
        </div>
        <?php } ?>

      </div>

    </div>
  </div>
</div>
<?php echo $common_footer; ?>