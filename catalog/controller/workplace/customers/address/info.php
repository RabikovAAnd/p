<?php
class ControllerWorkplaceCustomersAddressInfo extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'customers_address_info', 'index', $this->language->Get_Language_Code() );

    // Test for address GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID('guid') === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Address GUID parameter not found
      //------------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // Address GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Load data models
      $this->load->model( 'address/address' );
      $this->load->model( 'warehouse/warehouse' );

      // Get group address guid
      $address_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      //------------------------------------------------------------------------
      // address general data
      //------------------------------------------------------------------------

      // Get address information
      $address = $this->model_address_address->Get_Address( $address_guid );
      $country_name = $this->location->Get_Country_Info( $address['country_id'], $this->language->Get_Language_Code() )['description'];
      $zone_name = $this->location->Get_Country_Zone_Info( $address['zone_id'] )['name'];

      $address_text = $address['street'] . ' ' . $address['house'];
      if ($address['building'] != '') {
        $address_text = $address_text . ', ' . $address['building'];
      }
      if ($address['apartment'] != '') {
        $address_text = $address_text . ', ' . $address['apartment'];
      }
      if ($address['postcode'] != '') {
        $address_text = $address_text . ', ' . $address['postcode'];
      }
      if ($address['district'] != '') {
        $address_text = $address_text . ', ' . $address['district'];
      }
      if ($address['city'] != '') {
        $address_text = $address_text . ' ' . $address['city'];
      }
      if ($country_name != '') {
        $address_text = $address_text . ', ' . $country_name;
      }
      $this->data['address'] = array(
        'guid' => $address['guid'],
        'country_name' => $country_name,
        'zone_name' => $zone_name,
        'postcode' => $address['postcode'],
        'district' => $address['district'],
        'city' => $address['city'],
        'street' => $address['street'],
        'house' => $address['house'],
        'building' => $address['building'],
        'apartment' => $address['apartment'],
        'active' => $address['active'],

        'address_text' => $address_text,
      );


      // Get warehouses
      $warehouses =  $this->model_warehouse_warehouse->Get_Address_Warehouses( $address_guid );

      // Process all warehouses
      foreach( $warehouses as $warehouse )
      {

        // Set warehouse data
        $this->data[ 'warehouses' ][] = array(
          'guid' => $warehouse[ 'guid' ],
          'name' => $warehouse[ 'name' ],
          'description' => $warehouse[ 'description' ],
          'code' => $warehouse[ 'code' ],
          'status' => $warehouse[ 'status' ],
          'href' => $this->url->link( 'workplace/customers/address/warehouse/info', 'guid=' . $warehouse[ 'guid' ], 'SSL' ),
          'edit_button_href' => $this->url->link( 'workplace/customers/address/warehouse/edit', 'guid=' . $warehouse[ 'guid' ], 'SSL' ),
          // 'active_button_href' => $this->url->link( 'workplace/units/status/change/Change', 'guid=' . $unit[ 'guid' ] .'&status=active', 'SSL' ),
          // 'inactive_button_href' => $this->url->link( 'workplace/units/status/change/Change', 'guid=' . $unit[ 'guid' ] .'&status=inactive', 'SSL' ),
          // 'remove_button_href' => $this->url->link( 'workplace/units/status/change/Change', 'guid=' . $unit[ 'guid' ] .'&status=deleted', 'SSL' ),

        );

      }

      // Set links
      $this->data[ 'edit_button_href'] = $this->url->link( 'workplace/customers/address/edit', 'guid=' . $address_guid . '&customer_guid=' . $address['customer_guid'], 'SSL' );
      $this->data[ 'add_warehouse_button_href'] = $this->url->link( 'workplace/customers/address/warehouse/add', 'address_guid=' . $address_guid, 'SSL' );

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