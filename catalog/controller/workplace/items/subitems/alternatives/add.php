<?php
class ControllerWorkplaceItemsSubitemsAlternativesAdd extends Controller
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
      // ERROR: Item GUID parameter not found
      //----------------------------------------------------------------------

      //! @todo ANVILEX KM: Redirect to item not found page

    }
    else
    {   
  
      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'items_subitems_alternatives_add', 'index', $this->language->Get_Language_Code() );
      
      // Load data model
      $this->load->model( 'items/items' );
      $this->load->model( 'items/subitems/subitems' );

      // Get subitem index GUID parameter
      $subitem_index_guid = $this->request->Get_GET_Parameter_As_GUID( 'subitem_index_guid' );
      
      $this->data[ 'subitem_index_guid' ] = $subitem_index_guid;

      // Get subitem information by subitem index GUID
      $subitem = $this->model_items_subitems_subitems->Get_Subitem_By_Index_GUID( $subitem_index_guid );
              
      // Get item GUID data
      $subitem_guid = $this->model_items_subitems_subitems->Get_Subitem_GUID( $subitem_index_guid);

      $this->data[ 'subitem_info' ] = $this->model_items_items->Get_Information( $subitem_guid );
      
      // Load item proposal
      $items = $this->model_items_items->Get_List_Of_Items( 30, 1, '', false, true, false, '', $this->language->Get_Language_Code() );

      // Process all proposed items
      foreach ( $items as $item )
      {
        
        // Test for proposed alternative subitem same as actual subitem
        if( $item[ 'guid' ] != $subitem_index_guid )
        {
        
          // Add item to the list
          $this->data[ 'items' ][] = array(
            'guid' => $item[ 'guid' ],
            'key' => $item[ 'guid' ] . '&' . $item[ 'mpn' ] . '&' . $item[ 'manufacturer_name' ],
            'mpn' => $item[ 'mpn' ],
            'name' => $item[ 'name' ],
            'manufacturer_name' => $item[ 'manufacturer_name' ]
          );
        
        }
      }

      // Compose links
      $this->data[ 'add_button_href' ] = $this->url->link( 'workplace/items/subitems/alternatives/add/Add_Alternative', '', 'SSL' );
      $this->data[ 'cancel_button_href' ] =  $this->url->link( 'workplace/items/info', 'guid=' . $subitem[ 'item_guid' ] . '#subitem' .$subitem_index_guid, 'SSL' );

      //------------------------------------------------------------------------
      // Set page data
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
        $items = $this->model_items_items->Get_List_Of_Items( 30, 1, $this->request->Get_POST_Parameter_As_String( 'search' ), false, true, false, '', $this->language->Get_Language_Code());

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
  // Add Alternative
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Add_Alternative()
  {

    // Init json data
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

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'items_subitems_alternatives_add', 'Add_Unit', $this->language->Get_Language_Code() );

      // Load data models
      $this->load->model( 'items/items' );
      $this->load->model( 'items/subitems/alternatives' );
      $this->load->model( 'items/subitems/subitems' );

      // Init unit data
      $data = array();

      // Clear request data valid status
      $request_data_valid = true;

      //------------------------------------------------------------------------
      // Check parameter: Alternative GUID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_GUID( 'alternative_guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR:Alternative GUID parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'alternative_guid' ] = $this->data[ 'workplace_items_subitems_alternatives_add_alternative_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Alternative GUID parameter found
        //----------------------------------------------------------------------

        // Store data
        $data[ 'alternative_guid' ] = $this->request->Get_POST_Parameter_As_GUID( 'alternative_guid' );

        if ( $this->model_items_items->Is_Exists_By_GUID( $data[ 'alternative_guid' ] ) === false )
        {

          //----------------------------------------------------------------------
          // ERROR: Alternative GUID parameter not valid
          //----------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'alternative_guid' ] = $this->data[ 'workplace_items_subitems_alternatives_add_alternative_guid_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //----------------------------------------------------------------------
          // Alternative GUID parameter valid
          //----------------------------------------------------------------------

        }

      }

      //------------------------------------------------------------------------
      // Check parameter: Subitem GUID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'subitem_index_guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Subitem GUID parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'subitem_index_guid' ] = $this->data[ 'workplace_items_subitems_alternatives_add_subitem_index_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Subitem GUID parameter found
        //----------------------------------------------------------------------

        // Store data
        $data[ 'subitem_index_guid' ] = $this->request->Get_POST_Parameter_As_GUID( 'subitem_index_guid' );

        if ( $this->model_items_subitems_subitems->Is_Exists_By_Index_GUID( $data[ 'subitem_index_guid' ] ) === false )
        {

          //----------------------------------------------------------------------
          // ERROR: Subitem GUID parameter not valid
          //----------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'subitem_index_guid' ] = $this->data[ 'workplace_items_subitems_alternatives_add_subitem_index_guid_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //----------------------------------------------------------------------
          // Subitem found
          //----------------------------------------------------------------------

          // Get subitem information by subitem index GUID
          $subitem = $this->model_items_subitems_subitems->Get_Subitem_By_Index_GUID( $data[ 'subitem_index_guid' ] );

        }

      }

      // Is request data valid
      if ( $request_data_valid === true )
      {

        //------------------------------------------------------------------------
        // Check for Alternative subitem already parent item
        //------------------------------------------------------------------------

        if( $subitem ['item_guid'] ==   $data[ 'alternative_guid' ])
        {

          // Set error message text
          $json[ 'error' ][ 'parent_item' ] = $this->data[ 'workplace_items_subitems_alternatives_add_parent_item_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }

        //----------------------------------------------------------------------
        // Check for Alternative subitem already exist
        //----------------------------------------------------------------------

        if ( $this->model_items_subitems_alternatives->Is_Exist_Alternative_Subitem( $data[ 'alternative_guid' ], $data[ 'subitem_index_guid'] ) === true )
        {

          //--------------------------------------------------------------------
          // ERROR: Alternative Subitem  already exists
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'already_exists' ] = $this->data[ 'workplace_items_subitems_alternatives_add_already_exists_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Alternative Subitem not exists
          //--------------------------------------------------------------------

        }

      }

      //------------------------------------------------------------------------
      // Try to add alternative subitem
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
        // Parameters present and valid, add subitem alternative
        //----------------------------------------------------------------------

        // Add new subitem alternative
        $return_code = $this->model_items_subitems_alternatives->Add_Alternative( $data[ 'alternative_guid' ],  $data[ 'subitem_index_guid' ] );

        // Test for error
        if ( $return_code === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Create subitem failed
          //--------------------------------------------------------------------

          // Set error message
          $json[ 'error' ][ 'error' ] = 'Create and add subitem failed.';

          // Set error code
          $json[ 'return_code' ] = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // ERROR: Create subitem failed
          //--------------------------------------------------------------------

          // // Set redirect URL
          $json[ 'redirect_url' ] = $this->url->link( 'workplace/items/info', 'guid=' . $subitem[ 'item_guid' ] , 'SSL' );

          // Set success code
          $json[ 'return_code' ] = true;

        }

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