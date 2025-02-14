<?php echo $common_header; ?>
<div id="content">
  <?php if($category_guid != '00000000000000000000000000000000'){ ?>
  <h1>
    <?php echo $category[ 'name' ]; ?>
  </h1>
  <?php } else {?>
  <h1>
    <?php echo $workplace_categories_info_header; ?>
  </h1>
  <?php } ?>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">
      <div class="list">
        <?php if($category_guid != '00000000000000000000000000000000'){ ?>
        <div class="info-content-block list">
          <h2>
            <?php echo $workplace_categories_info_general_data_header; ?>
          </h2>
          <div class="info-content-block end">
            <a href="<?php echo $edit_button_href; ?>">
              <button class="small-button" type="button">
                <?php echo $workplace_categories_info_edit_button_text; ?>
              </button>
            </a>
          </div>
          <div>
            <span>
              <?php echo $workplace_categories_info_general_data_name_text; ?>:
              <?php echo $category[ 'name' ]; ?>
            </span>
            </br>
            <span>
              <?php echo $workplace_categories_info_general_data_status_text; ?>:
              <?php echo $category[ 'status' ]; ?>
            </span>
            </br>
            <span>
              <?php echo $workplace_categories_info_general_data_create_date_text; ?>:
              <?php echo $category[ 'date_added' ]; ?>
            </span>
            </br>
            <span>
              <?php echo $workplace_categories_info_general_data_guid_text; ?>:
              <?php echo $category[ 'guid' ]; ?>
            </span>

          </div>

        </div>
        <?php } ?>
        <?php if($category_guid != '00000000000000000000000000000000'){ ?>
        <div class="info-content-block list">
          <h2>
            <?php echo $workplace_categories_info_tree_header; ?>
          </h2>
          <div class="row">
            <?php if( isset( $tree_categories ) ) { ?>
            <?php foreach (   array_reverse($tree_categories) as $tree_category ){ ?>
            <a href="<?php echo $tree_category[ 'href' ]; ?>">
              <?php echo $tree_category[ 'name' ]; ?>
            </a>>
            <?php } ?>
            <?php } ?>
          </div>

        </div>
        <?php } ?>
        <div class="info-content-block list">
          <h2>
            <?php echo $workplace_categories_info_subcategories_header; ?>
          </h2>
          <div class="info-content-block end">
            <a href="<?php echo $add_button_href; ?>">
              <button class="small-button" type="button">
                <?php echo $workplace_categories_info_add_subcategory_button_text; ?>
              </button>
            </a>
          </div>
          <?php if( isset( $subcategories ) ){ ?>
          <div class="table-menu-style">
            <div class="subcategories-table table-menu-header">
              <span><b>
                  <?php echo $workplace_categories_info_subcategories_table_name; ?>
                </b></span>
              <span><b>
                  <?php echo $workplace_categories_info_subcategories_table_status; ?>
                </b></span>
            </div>

            <?php foreach (  $subcategories as $subcategory ){ ?>
            <div id="<?php echo $subcategory[ 'element_href' ]; ?>" class="subcategories-table table-menu-element">
              <span><a href="<?php echo $subcategory[ 'href' ]; ?>">
                  <?php echo $subcategory[ 'name' ]; ?>
                </a>
              </span>
              <span>
                <?php echo $subcategory[ 'status' ]; ?>
              </span>
              <div class="table-button-menu" style="display: none;">
                <a href="<?php echo $subcategory[ 'move_button_href' ]; ?>"
                  title="<?php echo $workplace_categories_info_move_button_hint; ?>">
                  <button type="button">
                    <?php echo $workplace_categories_info_move_button_text; ?>
                  </button></a>

                <button type="button" onMouseDown="File_Form('<?php echo $subcategory[ 'active_button_href' ]; ?>')">
                  <?php echo $workplace_categories_info_active_button_text; ?>
                </button>
                <button type="button" onMouseDown="File_Form('<?php echo $subcategory[ 'inactive_button_href' ]; ?>')">
                  <?php echo $workplace_categories_info_inactive_button_text; ?>
                </button>
                <button class="red-button" type="button"
                  onMouseDown="File_Form('<?php echo $subcategory[ 'remove_button_href' ]; ?>')">
                  <?php echo $workplace_categories_info_remove_button_text; ?>
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

</div>
<?php echo $common_footer; ?>