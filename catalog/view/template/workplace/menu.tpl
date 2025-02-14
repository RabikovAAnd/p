<div class="menu">
  <a href="<?php echo $workplace_href; ?>" class="menu__link unselectable-text-element"><?php echo $workplace_workplace_menu_workplace_button_text; ?></a>
 
  <div class="submenu list info-content-block">
    <h2><?php echo $workplace_workplace_menu_projects_button_text; ?></h2>
    <a href="<?php echo $projects_href; ?>" class="submenu__link unselectable-text-element"><?php echo $workplace_workplace_menu_projects_list_button_text; ?></a>
    <a href="<?php echo $create_project_href; ?>"  class="submenu__link unselectable-text-element"><?php echo $workplace_workplace_menu_submenu_projects_create_project_button_text; ?></a>
  </div>
  
  <div class="submenu list info-content-block">
    <h2><?php echo $workplace_workplace_menu_items_button_text; ?></h2>
    <a href="<?php echo $items_href; ?>" class="submenu__link unselectable-text-element"><?php echo $workplace_workplace_menu_items_list_button_text; ?></a>
    <a href="<?php echo $create_item_href; ?>"  class="submenu__link unselectable-text-element"><?php echo $workplace_workplace_menu_submenu_customers_create_item_button_text; ?></a>
  </div>
  
  <div class="submenu list  info-content-block">
    <h2><?php echo $workplace_workplace_menu_customers_button_text; ?></h2>
    <a href="<?php echo $customers_href; ?>" class="submenu__link unselectable-text-element"><?php echo $workplace_workplace_menu_customers_list_button_text; ?></a>
    <a href="<?php echo $create_individual_href; ?>" class="submenu__link unselectable-text-element"><?php echo $workplace_workplace_menu_submenu_customers_create_individual_button_text; ?></a>
    <a href="<?php echo $create_corporate_href; ?>" class="submenu__link unselectable-text-element"><?php echo $workplace_workplace_menu_submenu_customers_create_corporate_button_text; ?></a>
  </div>

  <a href="<?php echo $tasks_href; ?>"  class="menu__link unselectable-text-element"><?php echo $workplace_workplace_menu_tasks_button_text; ?></a>
  <a href="<?php echo $library_href; ?>" class="menu__link unselectable-text-element"><?php echo $workplace_workplace_menu_library_button_text; ?></a>
  <a href="<?php echo $procurement_href; ?>" class="menu__link unselectable-text-element"><?php echo $workplace_workplace_menu_procurement_button_text; ?></a>
  
  <div class="submenu list info-content-block">
    <h2><?php echo $workplace_workplace_menu_settings_button_text; ?></h2>
    <a href="<?php echo $categories_href; ?>" class="submenu__link unselectable-text-element"><?php echo $workplace_workplace_menu_categories_button_text; ?></a>
    <a href="<?php echo $properties_href; ?>" class="submenu__link unselectable-text-element"><?php echo $workplace_workplace_menu_properties_button_text; ?></a>
    <a href="<?php echo $document_types_href; ?>" class="submenu__link unselectable-text-element"><?php echo $workplace_workplace_menu_document_types_button_text; ?></a>
    <a href="<?php echo $units_href; ?>" class="submenu__link unselectable-text-element"><?php echo $workplace_workplace_menu_units_button_text; ?></a>
    <a href="<?php echo $processes_href; ?>" class="submenu__link unselectable-text-element"><?php echo $workplace_workplace_menu_processes_button_text; ?></a>
  </div>

  <div class="submenu list info-content-block">
    <h2><?php echo $workplace_workplace_menu_documents_button_text; ?></h2>
    <a href="<?php echo $documents_href; ?>" class="submenu__link unselectable-text-element"><?php echo  $workplace_workplace_menu_documents_button_text; ?></a>
  </div>

  <div class="submenu list info-content-block">
    <h2><?php echo 'VDC database'; ?></h2>
    <a href="<?php echo $vdc_database_parameters_href; ?>" class="submenu__link unselectable-text-element"><?php echo 'Parameters'; ?></a>
    <a href="<?php echo $vdc_database_events_href; ?>" class="submenu__link unselectable-text-element"><?php echo 'Events'; ?></a>
    <a href="<?php echo $vdc_database_blocks_href; ?>" class="submenu__link unselectable-text-element"><?php echo 'Blocks'; ?></a>
  </div>

</div>
<script>
  $(document).ready(function() {
    let links = $('a');
    for (let link of links){
      if($(link).attr('href') === window.location.href){
        $(link).addClass('menu__link_selected')
        $(link).closest('.submenu').addClass('submenu_selected')
      }
    }
  });
</script>