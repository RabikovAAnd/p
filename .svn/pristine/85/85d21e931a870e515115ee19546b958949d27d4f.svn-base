<?php
class ControllerWorkplaceItemsPropertiesAdd extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'add_property', 'index', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'items/properties' );

    //! @todo ANVILEX KM: Test for item exists

    // Get item guid
    $this->data[ 'item_guid' ] = $this->request->Get_GET_Parameter_As_String( 'item_guid' );

    // Get item properties groups
    $this->data[ 'properties_groups' ] = $this->model_items_properties->Get_Properties_Groups( $this->language->Get_Language_Code() );

    // Get item properties
    $this->data[ 'properties' ] = $this->model_items_properties->Get_Properties( $this->language->Get_Language_Code() );

    // Compose links
    $this->data[ 'workplace_add_property_button_href' ] = $this->url->link( 'workplace/items/properties/add/add_property', '', 'SSL' );

    $this->data['cancel_button_href'] = $this->url->link('workplace/items/info', 'guid=' .$this->data[ 'item_guid' ], 'SSL');

    //------------------------------------------------------------------------
    // Render page
    //------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
    $this->response->setKeywords( '' );
    $this->response->setRobots( 'index, follow' );

    // Add styles
    //???
    $this->response->addStyle( 'catalog/view/stylesheet/workplace/add_customer.css' );

    // Set page configuration
    $this->children = array(
      'common/footer',
      'workplace/menu',
      'common/header'
    );

  }

  //----------------------------------------------------------------------------
  //
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Group_Search()
  {

    // Initialise json data
    $json = array();

    // Test for customer not logged
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Custommer not logged in
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

      // Test for search query parameter setted
      if ( $this->request->Is_POST_Parameter_Exists( 'search' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Search query parameter not set
        //----------------------------------------------------------------------

        // Set error return code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Search query parameter set
        //----------------------------------------------------------------------

        // Load data models
        $this->load->model( 'items/properties' );

        // Get item properties groups
        $json[ 'properties_groups' ] = $this->model_items_properties->Search_Properties_Groups( 30, $this->request->Get_POST_Parameter_As_String( 'search' ), $this->language->Get_Language_Code() );

        // Set success return code
        $json[ 'return_code' ] = true;

      }

    }
  }

  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Property_Search()
  {

    // Initialise json data
    $json = array();

    // Test for customer not logged
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Custommer not logged in
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

      // Test for search query parameter setted
      if ( $this->request->Is_POST_Parameter_Exists( 'search' ) === false  || $this->request->Is_POST_Parameter_Exists( 'group_guid' ) === false)
      {

        //----------------------------------------------------------------------
        // ERROR: Search query parameter not set
        //----------------------------------------------------------------------

        // Set error return code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Search query parameter set
        //----------------------------------------------------------------------

        // Load data models
        $this->load->model( 'items/properties' );

        // Get item properties groups
        $json[ 'properties' ] = $this->model_items_properties->Search_Properties( 30,  $this->request->Get_POST_Parameter_As_GUID( 'group_guid' ),$this->request->Get_POST_Parameter_As_String( 'search' ), $this->language->Get_Language_Code() );

        // Set success return code
        $json[ 'return_code' ] = true;

      }

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

  
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Unit_Search()
  {

    // Initialise json data
    $json = array();


      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test for search query parameter setted
      if ( $this->request->Is_POST_Parameter_Exists( 'property_guid' ) === false)
      {

        //----------------------------------------------------------------------
        // ERROR: Search query parameter not set
        //----------------------------------------------------------------------

        // Set error return code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Search query parameter set
        //----------------------------------------------------------------------

        // Load data models
        $this->load->model( 'properties/properties' );

        // Get property info
        $property = $this->model_properties_properties->Get_Property_Information($this->request->Get_POST_Parameter_As_GUID( 'property_guid' ), $this->language->Get_Language_Code() );

        $units = $this->units->Get_Group_Units($property['units_guid']);

        foreach ($units as $unit)
        {

          // Set unit data
          $json[ 'units' ][] = array(
            'guid' => $unit['guid'],
            'name' => $unit['name'],
            'description' =>  $this->units->Get_Unit_Description($unit['guid'], $this->language->Get_Language_Code())['data'],
          );

        }

        // Set success return code
        $json[ 'return_code' ] = true;

      }

    

    // Render page
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------
  // Add item property
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Add_Property()
  {

    // Init json data
    $json = array();

    // Init parameter values
    $item_guid = '';
    $property_guid = '';
    $property_value = '';


      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'add_property', 'Add_Property', $this->language->Get_Language_Code() );

      // Load data models
      $this->load->model( 'items/items' );
      $this->load->model( 'items/properties' );
      $this->load->model( 'properties/properties' );

      // Set request data valid flag
      $request_data_valid = true;

      //------------------------------------------------------------------------
      // Item GUID
      //------------------------------------------------------------------------

      // Test for parameter exists and valid
      if( $this->request->Is_POST_Parameter_GUID( 'item_guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR:  Item guid parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'item_guid' ] = $this->data[ 'workplace_add_property_item_guid_error' ];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Item guid parameter found and valud
        //----------------------------------------------------------------------

        // Get item GUID
        $item_guid = $this->request->Get_POST_Parameter_As_GUID( 'item_guid' );

      }

      //------------------------------------------------------------------------
      // Property group GUID
      //------------------------------------------------------------------------

      // Test for parameter exists and valid
      if( $this->request->Is_POST_Parameter_GUID( 'property_group' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Property name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'property_group' ] = $this->data[ 'workplace_add_property_property_group_error' ];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Property name parameter found and valid
        //----------------------------------------------------------------------

        //------------------------------------------------------------------------
        // Property GUID
        //------------------------------------------------------------------------

        // Test for parameter exists and valid
        if( $this->request->Is_POST_Parameter_GUID( 'property_guid' ) === false )
        {

          //----------------------------------------------------------------------
          // ERROR: Property name parameter not found
          //----------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'property_guid' ] = $this->data[ 'workplace_add_property_property_guid_error' ];

          // Clear request data valid sataus
          $request_data_valid = false;

        }
        else
        {

          // Store property guid
          $property_guid = $this->request->Get_POST_Parameter_As_GUID( 'property_guid' );

          // Get property info
          $property = $this->model_properties_properties->Get_Property_Information($property_guid, $this->language->Get_Language_Code() );

          if( $property['valid'] === false )
          {
  
          //----------------------------------------------------------------------
          // ERROR: Property not found
          //----------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'property_guid' ] = $this->data[ 'workplace_add_property_property_guid_error' ];

          // Clear request data valid sataus
          $request_data_valid = false;

          }else
          {

            //----------------------------------------------------------------------
            // Property name parameter found and valid
            //----------------------------------------------------------------------

          }

        }

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
        $json[ 'error' ][ 'property_value' ] = $this->data[ 'workplace_add_property_property_value_error' ];

        // Clear request data valid sataus
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

          // Set errer message text
          $json[ 'error' ][ 'property_value' ] = $this->data[ 'workplace_add_property_property_value_error' ];

          // Clear request data valid sataus
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
        // ERROR:  Unit guid parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'unit_guid' ] = $this->data[ 'workplace_add_property_unit_guid_error' ];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        // Get unit GUID
        $unit_guid = $this->request->Get_POST_Parameter_As_GUID( 'unit_guid' );

        // Test for parameter exists and valid
        if( $this->units->Is_Unit_Exists( $unit_guid ) === false )
        {

          //----------------------------------------------------------------------
          // ERROR:  Unit guid parameter not found
          //----------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'unit_guid' ] = $this->data[ 'workplace_add_property_unit_guid_error' ];

          // Clear request data valid sataus
          $request_data_valid = false;

        }else
        {

        //----------------------------------------------------------------------
        // Unit guid parameter found and valud
        //----------------------------------------------------------------------

        }

      }

      // Is request data valid
      if ( $request_data_valid === true )
      {

        if ( $this->model_items_properties->Is_Unit_Property_Valid($property_guid, $unit_guid ) === false )
        {

          //----------------------------------------------------------------------
          // ERROR:  Unit guid parameter not valid
          //----------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'unit_guid' ] = $this->data[ 'workplace_add_property_unit_guid_error' ];

        }
        else
        {

          //----------------------------------------------------------------------
          // Request data valid
          //----------------------------------------------------------------------

        }

      }

      //------------------------------------------------------------------------
      // Process data
      //------------------------------------------------------------------------

      // Is request data valid
      if ( $request_data_valid === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Parameters not valid
        //----------------------------------------------------------------------

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        if ( $this->model_items_properties->Is_Item_Property_Exists( $property_guid, $item_guid ) === true )
        {

          // Set error message text
          $json['error']['already_exists'] = $this->data['workplace_add_property_already_exists_error'];

          // Set error code
          $json['return_code'] = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Parameters present and valid, try to add property
          //--------------------------------------------------------------------

          // Try to add item property
          $this->model_items_properties->Add_Item_Property($item_guid, $property_guid, $property_value, $unit_guid );

          // Set redirect URL
          $json['redirect_url'] = $this->url->link('workplace/items/info', 'guid=' . $item_guid, 'SSL');

          // Set success code
          $json['return_code'] = true;

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