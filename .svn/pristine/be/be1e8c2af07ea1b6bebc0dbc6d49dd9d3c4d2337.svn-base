<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_documents_types_header; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="list">
        <div class="info-content-block end">
          <a href="<?php echo $add_button_href; ?>">
            <button class="small-button" type="button">
              <?php echo $workplace_documents_types_add_type_button_text; ?>
            </button>
          </a>
        </div>
        <?php if( isset( $types ) ){ ?>
        <div class="table-menu-style">
          <div class="types-table table-menu-header">
            <span><b>
                <?php echo $workplace_documents_types_types_table_name; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_documents_types_types_table_status; ?>
              </b></span>
          </div>

          <?php foreach (  $types as $type ){ ?>
          <div id="<?php echo $type[ 'element_href' ]; ?>" class="types-table table-menu-element">
            <span><a href="<?php echo $type[ 'href' ]; ?>">
                <?php echo $type[ 'name' ]; ?>
              </a>
            </span>
            <span>
              <?php echo $type[ 'status' ]; ?>
            </span>
            <div class="table-button-menu" style="display: none;">
              <a href="<?php echo $type[ 'edit_button_href' ]; ?>"
                title="<?php echo $workplace_documents_types_edit_button_hint; ?>">
                <button type="button">
                  <?php echo $workplace_documents_types_edit_button_text; ?>
                </button></a>

              <button type="button" onMouseDown="File_Form('<?php echo $type[ 'active_button_href' ]; ?>')">
                <?php echo $workplace_documents_types_active_button_text; ?>
              </button>
              <button type="button" onMouseDown="File_Form('<?php echo $type[ 'inactive_button_href' ]; ?>')">
                <?php echo $workplace_documents_types_inactive_button_text; ?>
              </button>
              <button class="red-button" type="button"
                onMouseDown="File_Form('<?php echo $type[ 'remove_button_href' ]; ?>')">
                <?php echo $workplace_documents_types_remove_button_text; ?>
              </button>

              </button>
            </div>
          </div>
          <?php } ?>

        </div>
      </div>
      <?php } ?>

    </div>

  </div>

</div>
<?php echo $common_footer; ?>