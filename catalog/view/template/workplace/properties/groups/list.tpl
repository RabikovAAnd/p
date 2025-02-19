<?php echo $common_header; ?>
<div id="content">
  <h1>
    <?php echo $workplace_properties_header; ?>
  </h1>
  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div class="main-area">


      <div class=" list">

        <div class="info-content-block end">
          <a href="<?php echo $add_group_button_href; ?>">
            <button class="small-button">
              <?php echo $workplace_properties_add_property_button_text; ?>
            </button>
          </a>
        </div>
        <?php if( count( $groups )>0 ){ ?>



        <div class="table-menu-style">
          <div class="properties-table table-menu-header">
            <span><b>
                <?php echo $workplace_properties_table_group_name; ?>
              </b></span>
            <span><b>
                <?php echo $workplace_properties_table_group_status; ?>
              </b></span>
          </div>

          <?php foreach (  $groups as $group ){ ?>
          <div id="<?php echo $group[ 'element_href' ]; ?>" class="properties-table table-menu-element">
            <span><a href="<?php echo $group[ 'href' ]; ?>">
                <?php echo $group[ 'name' ]; ?>
              </a>
            </span>
            <span class="property_value">
              <?php echo $group[ 'status' ]; ?>
            </span>
            <div class="table-button-menu" style="display: none;">
              <a href="<?php echo $group[ 'clone_button_href' ]; ?>"
                title="<?php echo $workplace_properties_clone_button_hint; ?>">
                <button type="button">
                  <?php echo $workplace_properties_clone_button_text; ?>
                </button></a>
                <button onMouseDown="File_Form('<?php echo $group[ 'activate_button_href' ]; ?>')" type="button">
                  <?php echo $workplace_properties_activate_button_text; ?>
                </button>
                <button onMouseDown="File_Form('<?php echo $group[ 'deactivate_button_href' ]; ?>')" type="button">
                  <?php echo $workplace_properties_deactivate_button_text; ?>
                </button>
              <a href="<?php echo $group[ 'edit_button_href' ]; ?>"
                title="<?php echo $workplace_properties_edit_button_hint; ?>">
                <button type="button">
                  <?php echo $workplace_properties_edit_button_text; ?>
                </button></a>

              <button class="red-button" type="button"
                onMouseDown="File_Form('<?php echo $group[ 'remove_button_href' ]; ?>')">
                <?php echo $workplace_properties_remove_button_text; ?>
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