<?php
class ControllerWorkplaceItemsSubitemsReplace extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for item GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'subitem_index_guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Subitem index GUID parameter not found
      //----------------------------------------------------------------------

      //! @todo ANVILEX KM: Redirect to subitem not found page

    }
    else
    {

      //----------------------------------------------------------------------
      // Item GUID parameter found, continue processing
      //----------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'items_subitems_edit', 'index', $this->language->Get_Language_Code() );

      // Load data model
      $this->load->model( 'items/items' );
      $this->load->model( 'items/subitems/subitems' );
      $this->load->model( 'manufacturers/manufacturers' );

      // Get item GUID parameter
      $subitem_index_guid = $this->request->Get_GET_Parameter_As_GUID( 'subitem_index_guid' );

      if ($this->model_items_subitems_subitems->Is_Exists_By_Index_GUID($subitem_index_guid) === false) {
        
        //----------------------------------------------------------------------
        // ERROR: Subitem index GUID parameter not found
        //----------------------------------------------------------------------

        //! @todo ANVILEX KM: Redirect to subitem not found page

      } else {

        $this->data['subitem_index_guid'] = $subitem_index_guid;

        // Get subitem GUID data
        $subitem_guid = $this->model_items_subitems_subitems->Get_Subitem_GUID( $subitem_index_guid );

        // Get subitem information by subitem index GUID
        $subitem = $this->model_items_subitems_subitems->Get_Subitem_By_Index_GUID( $subitem_index_guid );

        $this->data[ 'subitem' ][ 'subitem_info' ] = $subitem;

        // Load parent item information
        $this->data[ 'subitem' ][ 'item_info' ] = $this->model_items_items->Get_Information( $subitem_guid );

        // Load proposed items
        $items = $this->model_items_items->Get_List_Of_Items( 30, 1, '', false, true, false, '', $this->language->Get_Language_Code() );

        // Process all proposed items
        foreach ( $items as $item )
        {

          // Add proposed item to the list
          $this->data[ 'items' ][] = array(
            'guid' => $item[ 'guid' ],
            'key' => $item[ 'guid' ] . '&' . $item[ 'mpn' ] . '&' . $item[ 'manufacturer_name' ],
            'mpn' => $item[ 'mpn' ],
            'name' => $item[ 'name' ],
            'manufacturer_name' => $item[ 'manufacturer_name' ]
          );

        }

        // Compose links
        $this->data['save_button_href'] = $this->url->link('workplace/items/subitems/replace/Replace', '', 'SSL');
        $this->data['cancel_button_href'] = $this->url->link('workplace/items/info', 'guid=' . $subitem['item_guid'] . '#subitem' . $subitem_index_guid, 'SSL');

        //--------------------------------------------------------------------
        // Set page data
        //--------------------------------------------------------------------

        // Set document properties
        $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
        $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
        $this->response->setKeywords( '' );
        $this->response->setRobots( 'index, follow' );

        // Add styles
        $this->response->addStyle( 'catalog/view/stylesheet/workplace/add_assembly_unit.css' );

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
  // Search query
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Search()
  {

    // Initialise json data
    $json = array();

    // Test for customer not logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Set redirect link
      $json[ 'redirect_url' ] = $this->url->link( 'account/login', '', 'SSL' );

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Custommer logged in
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ( $this->request->Is_POST_Parameter_Exists( 'search' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: 'search' parameter not found
        //----------------------------------------------------------------------

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Parameter found, continue processing
        //----------------------------------------------------------------------

        // Load data models
        $this->load->model( 'items/items' );

        // Get proposed items
        $items = $this->model_items_items->Get_List_Of_Items( 30, 1, $this->request->Get_POST_Parameter_As_String( 'search' ), false, true, false, '', $this->language->Get_Language_Code() );

        // Process all item
        foreach ( $items as $item )
        {

          // Set item data as subitem proposal
          $json[ 'items' ][] = array(
            'guid' => $item[ 'guid' ],
            'mpn' => $item[ 'mpn' ],
            'name' => $item[ 'name' ],
            'manufacturer_name' => $item[ 'manufacturer_name' ]
          );

        }

        // Set success code
        $json[ 'return_code' ] = true;

      }

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------
  // Replace subitem
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Replace()
  {

    // Init json data
    $json = array();

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'add_assembly_unit', 'Add_Unit', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'items/items' );
    $this->load->model( 'items/subitems/subitems' );
    $this->load->model( 'items/subitems/alternatives' );

    // Init unit data
    $data = array();

    // Set request data valid status
    $request_data_valid = true;

    //------------------------------------------------------------------------
    // Clear alternatives
    //------------------------------------------------------------------------

    // Test for parameter exists
    if( $this->request->Is_POST_Parameter_Boolean( 'clear_alternatives' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Clear alternatives parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'clear_alternatives' ] = $this->data[ 'workplace_add_item_clear_alternatives_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {
      
      //----------------------------------------------------------------------
      // Clear alternatives parameter found
      //----------------------------------------------------------------------

      // Store customer data
      $data[ 'clear_alternatives' ] = $this->request->Get_POST_Parameter_As_Boolean( 'clear_alternatives' );

    }


    //------------------------------------------------------------------------
    // Check parameter: Subitem GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if( $this->request->Is_POST_Parameter_Exists( 'mpn' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Mpn parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'mpn' ] = $this->data[ 'workplace_add_assembly_unit_assembly_unit_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Mpn parameter found
      //----------------------------------------------------------------------

      $subitem_guid = $this->request->Get_POST_Parameter_As_String( 'mpn' );

      if ( $this->model_items_items->Is_Exists_By_GUID( $subitem_guid ) === true )
      {

        //----------------------------------------------------------------------
        // Assembly unit parameter valid
        //----------------------------------------------------------------------

        // Store unit data
        $data[ 'subitem_guid' ] = $subitem_guid;

      }
      else
      {

        //----------------------------------------------------------------------
        // ERROR: Assembly unit parameter not valid
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'subitem_guid' ] = $this->data[ 'workplace_add_assembly_unit_assembly_unit_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }

    }

    //------------------------------------------------------------------------
    // Check parameter: Subitem index GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if( $this->request->Is_POST_Parameter_Exists( 'subitem_index_guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Subitem index GUID parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'subitem_index_guid' ] = $this->data[ 'workplace_add_assembly_unit_item_guid_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Subitem index GUID parameter found
      //----------------------------------------------------------------------

      // Get subitem index GUID
      $subitem_index_guid = $this->request->Get_POST_Parameter_As_String( 'subitem_index_guid' );

      // Test for information invalid
      if( $this->model_items_subitems_subitems->Is_Exists_By_Index_GUID( $subitem_index_guid ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Subitem not valid
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'subitem_index_guid' ] = $this->data[ 'workplace_add_assembly_unit_item_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Subitem found
        //--------------------------------------------------------------------

        $subitem = $this->model_items_subitems_subitems->Get_Subitem_By_Index_GUID( $subitem_index_guid );

        // Store subitem index guid
        $data[ 'subitem_index_guid' ] = $subitem_index_guid;

      }

    }

    //------------------------------------------------------------------------
    // Try to replace subitem
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

      //----------------------------------------------------------------------
      // Parameters present and valid, add subitem
      //----------------------------------------------------------------------

      // Update subitem
      $return_data = $this->model_items_subitems_subitems->Replace($data);

      // Test for error
      if ( $return_data[ 'return_code' ] === false )
      {

        //--------------------------------------------------------------------
        // ERROR: Save changes failed
        //--------------------------------------------------------------------

        // Set error message
        $json[ 'error' ][ 'error' ] = 'Create and add subitem failed.';

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Save changes successful
        //--------------------------------------------------------------------

        // Check for clear alternatives
        if (   $data[ 'clear_alternatives' ] === true )
        {
          $this->model_items_subitems_alternatives->Delete_Alternatives( $data[ 'subitem_index_guid' ] );
        }

        // Set redirect URL
        $json[ 'redirect_url' ] = $this->url->link( 'workplace/items/info', 'guid=' . $subitem[ 'item_guid' ] , 'SSL' );

        // Set success code
        $json[ 'return_code' ] = true;

      }

    }

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>