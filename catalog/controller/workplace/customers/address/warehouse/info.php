<?php
class ControllerWorkplaceCustomersAddressWarehouseInfo extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'customers_address_warehouse_info', 'index', $this->language->Get_Language_Code() );

    // Test for warehouse GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID('guid') === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Warehouse GUID parameter not found
      //------------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // Warehouse GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Load data models
      $this->load->model( 'address/address' );
      $this->load->model( 'warehouse/warehouse' );

      // Get warehouse guid
      $warehouse_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      //------------------------------------------------------------------------
      // Warehouse general data
      //------------------------------------------------------------------------

      // Get warehouse
      $warehouse =  $this->model_warehouse_warehouse->Get_Warehouse( $warehouse_guid );

      // Set warehouse data
      $this->data[ 'warehouse' ] = array(
        'guid' => $warehouse[ 'guid' ],
        'name' => $warehouse[ 'name' ],
        'description' => $warehouse[ 'description' ],
        'code' => $warehouse[ 'code' ],
        'creation_date' => $warehouse[ 'creation_date' ],
        'status' => $warehouse[ 'status' ],
        'href' => $this->url->link( 'workplace/customers/address/warehouse/info', 'guid=' . $warehouse[ 'guid' ], 'SSL' ),
        // 'edit_button_href' => $this->url->link( 'workplace/units/edit', 'guid=' . $unit[ 'guid' ]  . '&group_guid=' . $group_unit_guid, 'SSL' ),
        // 'active_button_href' => $this->url->link( 'workplace/units/status/change/Change', 'guid=' . $unit[ 'guid' ] .'&status=active', 'SSL' ),
        // 'inactive_button_href' => $this->url->link( 'workplace/units/status/change/Change', 'guid=' . $unit[ 'guid' ] .'&status=inactive', 'SSL' ),
        // 'remove_button_href' => $this->url->link( 'workplace/units/status/change/Change', 'guid=' . $unit[ 'guid' ] .'&status=deleted', 'SSL' ),

      );

      
      // Get warehouse bins
      $bins =  $this->model_warehouse_warehouse->Get_Warehouse_Bins($warehouse[ 'guid' ]);

      // Process all warehouses
      foreach( $bins as $bin )
      {

        // Set warehouse data
        $this->data[ 'bins' ][] = array(
          'guid' => $bin[ 'guid' ],
          'code' => $bin[ 'code' ],
          'status' => $bin[ 'status' ],
          'href' => $this->url->link( 'workplace/customers/address/warehouse/info', 'guid=' . $warehouse[ 'guid' ], 'SSL' ),
          'edit_button_href' => $this->url->link( 'workplace/customers/address/warehouse/bin/edit', 'guid=' . $bin[ 'guid' ], 'SSL' ),
          // 'active_button_href' => $this->url->link( 'workplace/units/status/change/Change', 'guid=' . $unit[ 'guid' ] .'&status=active', 'SSL' ),
          // 'inactive_button_href' => $this->url->link( 'workplace/units/status/change/Change', 'guid=' . $unit[ 'guid' ] .'&status=inactive', 'SSL' ),
          // 'remove_button_href' => $this->url->link( 'workplace/units/status/change/Change', 'guid=' . $unit[ 'guid' ] .'&status=deleted', 'SSL' ),

        );

      }

      // Set links
      $this->data[ 'edit_button_href'] = $this->url->link( 'workplace/customers/address/warehouse/edit', 'guid=' . $warehouse[ 'guid' ], 'SSL' );
      $this->data[ 'add_bin_button_href'] = $this->url->link( 'workplace/customers/address/warehouse/bin/add', 'warehouse_guid=' . $warehouse[ 'guid' ], 'SSL' );

    }

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
    $this->response->setRobots( 'index, follow' );

    // Set page configuration
    $this->children = array(
      'common/footer',
      'workplace/menu',
      'common/header'
    );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>