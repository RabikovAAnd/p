<?php
class ControllerWorkplaceMenu extends Controller
{

  //----------------------------------------------------------------------------
  // Default method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'workplace_menu', 'index', $this->language->Get_Language_Code() );

    // Account
    $this->data[ 'account_href' ] = $this->url->link( 'account/account', '', 'SSL' );

    // Workplace
    $this->data[ 'workplace_href' ] = $this->url->link( 'workplace/front', '', 'SSL' );

    // Projects
    $this->data[ 'projects_href' ] = $this->url->link( 'workplace/projects/list', '', 'SSL' );
    $this->data[ 'create_project_href' ] = $this->url->link( 'workplace/projects/create', '', 'SSL' );

    // Customers
    $this->data[ 'customers_href' ] = $this->url->link( 'workplace/customers/list', '', 'SSL' );
    $this->data[ 'create_individual_href' ] = $this->url->link( 'workplace/customers/individual/create', '', 'SSL' );
    $this->data[ 'create_corporate_href' ] = $this->url->link( 'workplace/customers/corporate/create', '', 'SSL' );

    // Items
    $this->data[ 'items_href' ] = $this->url->link( 'workplace/items/list', '', 'SSL' );
    $this->data[ 'create_item_href' ] = $this->url->link( 'workplace/items/create', '', 'SSL' );

    // Tasks
    $this->data[ 'tasks_href' ] = $this->url->link( 'workplace/tasks/list', '', 'SSL' );

    // Library - Deprecated
    $this->data[ 'library_href' ] = $this->url->link( 'workplace/library', '', 'SSL' );

    // Procurement - Deprecated
    $this->data[ 'procurement_href' ] = $this->url->link( 'workplace/procurement', '', 'SSL' );

    // Settings
    $this->data[ 'categories_href' ] = $this->url->link( 'workplace/categories/info', 'guid=00000000000000000000000000000000', 'SSL' );
    $this->data[ 'properties_href' ] = $this->url->link( 'workplace/properties/groups/list', '', 'SSL' );
    $this->data[ 'document_types_href' ] = $this->url->link( 'workplace/documents/types', '', 'SSL' );
    $this->data[ 'units_href' ] = $this->url->link( 'workplace/units/groups/list', '', 'SSL' );
    $this->data[ 'processes_href' ] = $this->url->link( 'workplace/processes/groups/list', '', 'SSL' );

    // Documents
    $this->data[ 'documents_href' ] = $this->url->link( 'workplace/documents/list', '', 'SSL' );

    // VDC database
    $this->data[ 'vdc_database_parameters_href' ] = $this->url->link( 'workplace/vdc/database/parameters/list', '', 'SSL' );
    $this->data[ 'vdc_database_events_href' ] = $this->url->link( 'workplace/vdc/database/events/list', '', 'SSL' );
    $this->data[ 'vdc_database_blocks_href' ] = $this->url->link( 'workplace/vdc/database/blocks/list', '', 'SSL' );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>