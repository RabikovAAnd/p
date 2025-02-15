<?php
class ControllerWorkplaceItemsPropertiesEdit extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for item GUID parameter exists
    if ( 
      ( $this->request->Is_GET_Parameter_GUID( 'property_guid' ) === false ) ||
      ( $this->request->Is_GET_Parameter_GUID( 'item_guid' ) === false )
    )
    {

      //----------------------------------------------------------------------
      // ERROR: Item GUID parameter not found
      //----------------------------------------------------------------------

      //! @todo ANVILEX KM: Redirect to item not found page
      $this->response->Redirect( $this->url->link( 'workspace/items/list', '', 'SSL' ) );

    }
    else
    {

      // Load data models
      $this->load->model( 'items/items' );
      $this->load->model( 'items/properties' );
      $this->load->model( 'properties/properties' );

      if (
        $this->model_items_properties->Is_Property_Exists( $this->request->Get_GET_Parameter_As_GUID( 'property_guid' ) ) === false ||
        $this->model_items_items->Is_Exists_By_GUID( $this->request->Get_GET_Parameter_As_GUID( 'item_guid' ) ) === false)
      {

        $this->response->Redirect( $this->url->link( 'workspace/items/list', '', 'SSL' ) );

      }
      else
      {

        // Load messages
        $this->messages->Load( $this->data, 'workplace', 'edit_property', 'index', $this->language->Get_Language_Code() );

        // Get property guid
        $this->data[ 'property_guid' ] = $this->request->Get_GET_Parameter_As_GUID( 'property_guid' );

        // Get item guid
        $this->data[ 'item_guid' ] = $this->request->Get_GET_Parameter_As_GUID( 'item_guid' );


        // Get item properties groups
        $this->data[ 'property' ] = $this->model_properties_properties->Get_Property_Information($this->data[ 'property_guid' ], $this->language->Get_Language_Code() );

        $this->data[ 'property_value' ] = $this->model_items_properties->Get_Property_Value($this->data[ 'property_guid' ],$this->data[ 'item_guid' ])[ 'value' ];

        $this->data[ 'property_unit' ]['guid'] = $this->model_items_properties->Get_Item_Property_Unit($this->data[ 'property_guid' ],$this->data[ 'item_guid' ])[ 'unit_guid' ];

        $this->data[ 'property_unit' ] =  $this->units->Get_Unit_Info_By_GUID( $this->data[ 'property_unit' ]['guid'], $this->language->Get_Language_Code())['data'];

        // Get list of units
        $units = $this->units->Get_Group_Units($this->data[ 'property' ]['units_guid']);

        foreach ($units as $unit)
        {

          $unit_info = $this->units->Get_Unit_Info_By_GUID($unit['guid'], $this->language->Get_Language_Code());
          if($unit_info[ 'return_code' ] == true){
             // Set unit dataproperty_unit
            $this->data[ 'units' ][] = array(
              'guid' => $unit['guid'],
              'name' => $unit_info['data']['name'],
              'symbol' => $unit_info['data']['symbol'],
            );

          }

        }

        // Compose links
        $this->data[ 'workplace_edit_property_button_href' ] = $this->url->link( 'workplace/items/properties/edit/Edit_Property', 'item_guid='.$this->data[ 'item_guid' ].'&property_guid='.$this->data[ 'property_guid' ] , 'SSL' );

        $this->data['cancel_button_href'] = $this->url->link( 'workplace/items/info', 'guid=' .$this->data[ 'item_guid' ] . '#property' . $this->data[ 'property_guid' ], 'SSL' );

        //------------------------------------------------------------------------
        // Render page
        //------------------------------------------------------------------------

        // Set document properties
        $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
        $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
        $this->response->setKeywords( '' );
        $this->response->setRobots( 'index, follow' );

        // Set page configuration
        $this->children = array(
          'common/footer',
          'workplace/menu',
          'common/header'
        );

      }

    }

  }

  //----------------------------------------------------------------------------
  // Edit item property
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Edit_Property()
  {

    // Init json data
    $json = array();

    // Init parameter values
    $item_guid = '';
    $property_guid = '';
    $property_value = '';

    // Test for customer logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Set redirect link
      $json[ 'redirect_url' ] = $this->url->link( 'account/login', '', 'SSL' );

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'edit_property', 'Edit_Property', $this->language->Get_Language_Code() );

      // Load data models
      $this->load->model( 'items/properties' );

      // Set request data valid flag
      $request_data_valid = true;

      //------------------------------------------------------------------------
      // Item GUID
      //------------------------------------------------------------------------

      // Test for parameter exists and valid
      if( $this->request->Is_GET_Parameter_GUID( 'item_guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR:  Item guid parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'item_guid' ] = $this->data[ 'workplace_edit_property_item_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {
        
        //----------------------------------------------------------------------
        // Item guid parameter found and valud
        //----------------------------------------------------------------------

        // Get item GUID
        $item_guid = $this->request->Get_GET_Parameter_As_GUID( 'item_guid' );

      }

      //------------------------------------------------------------------------
      // Property GUID
      //------------------------------------------------------------------------

      // Test for parameter exists and valid
      if( $this->request->Is_GET_Parameter_GUID( 'property_guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Property name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'property_guid' ] = $this->data[ 'workplace_edit_property_property_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Property name parameter found and valid
        //----------------------------------------------------------------------

        // Store property guid
        $property_guid = $this->request->Get_GET_Parameter_As_GUID( 'property_guid' );

      }

      //------------------------------------------------------------------------
      // Property value
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'property_value' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Property value parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'property_value' ] = $this->data[ 'workplace_edit_property_property_value_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Property value parameter found
        //----------------------------------------------------------------------

        // Store item data
        $property_value = trim( $this->request->Get_POST_Parameter_As_String( 'property_value' ) );

        // Test property value validity
        if ( utf8_strlen( $property_value ) > 255 )
        {

          //--------------------------------------------------------------------
          // ERROR: Property value invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'property_value' ] = $this->data[ 'workplace_edit_property_property_value_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Property value valid
          //--------------------------------------------------------------------

        }

      }

      //------------------------------------------------------------------------
      // Unit GUID
      //------------------------------------------------------------------------

      // Test for parameter exists and valid
      if( $this->request->Is_POST_Parameter_GUID( 'unit_guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Unit GUID parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'unit_guid' ] = $this->data[ 'workplace_edit_property_unit_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        // Store property guid
        $unit_guid = $this->request->Get_POST_Parameter_As_GUID( 'unit_guid' );

        if( $this->units->Is_Unit_Exists( $unit_guid  ) === false )
        {

          //----------------------------------------------------------------------
          // ERROR: Unit GUID parameter not found
          //----------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'unit_guid' ] = $this->data[ 'workplace_edit_property_unit_guid_error' ];

        }
        else
        {

          //----------------------------------------------------------------------
          // Unit GUID parameter found and valid
          //----------------------------------------------------------------------

        }

      }

      //------------------------------------------------------------------------
      // Process data
      //------------------------------------------------------------------------

      // Is request data valid
      if ( $request_data_valid === false )
      {

        //------------------------------------------------------------------------
        // ERROR: Parameters not valid
        //------------------------------------------------------------------------

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Parameters present and valid, try to add property
        //--------------------------------------------------------------------

        // Try to add item property
        $this->model_items_properties->Edit_Item_Property( $item_guid, $property_guid, $property_value, $unit_guid );

        // Set redirect URL
        $json[ 'redirect_url' ] = $this->url->link( 'workplace/items/info', 'guid=' . $item_guid, 'SSL' );

        // Set success code
        $json[ 'return_code' ] = true;

      }

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>