<?php
class ControllerWorkplaceItemsList extends Controller
{

  public $page_length = 30;
  public $current_page = 1;

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'items', 'index', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'items/items' );
    
    // Get item count
    $this->data[ 'item_count' ] = $this->model_items_items->Search_Items_Count();
    
    // Calculate page count
    $this->data[ 'page_count' ] = intdiv( $this->data[ 'item_count' ], $this->page_length );

    // Get items
    $items = $this->model_items_items->Get_List_Of_Items(
      $this->page_length,
      1,
      '',
      false,
      true,
      false,
      '',
      $this->language->Get_Language_Code()
    );

    // Iterate over all items
    foreach ( $items as $item )
    {

      // Set item data
      $this->data[ 'items' ][] = array(
        'guid' => $item[ 'guid' ],
        'id' => $item[ 'id' ],
        'item_href' => $this->url->link( 'workplace/items/info', 'guid=' . $item[ 'guid' ], 'SSL' ),
        'mpn' => $item[ 'mpn' ],
        'status' => $item[ 'status' ],
        'manufacturer_name' => $item[ 'manufacturer_name' ]
      );

    }

    // Set link
    $this->data[ 'add_item_href' ] = $this->url->link( 'workplace/items/create', '', 'SSL' );

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

  //----------------------------------------------------------------------------
  // Search query
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function search()
  {

    // Initialise json data
    $json = array();

    // Test for customer logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Set redirect link to login page
      $json[ 'redirect_url' ] = $this->url->link( 'account/login', '', 'SSL' );

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test for parameters not valid
      if ( 
        ( $this->request->Is_POST_Parameter_Exists( 'search' ) === false ) ||
        ( $this->request->Is_POST_Parameter_Boolean( 'id' ) === false ) ||
        ( $this->request->Is_POST_Parameter_Boolean( 'mpn' ) === false ) ||
        ( $this->request->Is_POST_Parameter_Boolean( 'description' ) === false ) || 
        ( $this->request->Is_POST_Parameter_Exists( 'manufacturer' ) === false ) ||
        ( $this->request->Is_POST_Parameter_Positive_Integer( 'page' ) === false ) 
      )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Parameter not found
        //----------------------------------------------------------------------

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // All parameters found, continue processing
        //----------------------------------------------------------------------

        // Load data models
        $this->load->model( 'items/items' );

        // Get item count
        $this->data[ 'item_count' ] = $this->model_items_items->Search_Items_Count(
          $this->request->Get_POST_Parameter_As_String( 'search' ),
          $this->request->Get_POST_Parameter_As_Boolean( 'id' ),
          $this->request->Get_POST_Parameter_As_Boolean( 'mpn' ),
          $this->request->Get_POST_Parameter_As_Boolean( 'description' ),
          $this->request->Get_POST_Parameter_As_String( 'manufacturer' ),
          $this->language->Get_Language_Code() 
        );

        $json[ 'item_count' ] = $this->data[ 'item_count' ];
        $json[ 'page_count' ] = intdiv( $this->data[ 'item_count' ], $this->page_length );

        // Get list of items
        $items =  $this->model_items_items->Get_List_Of_Items(
          $this->page_length,
          $this->request->Get_POST_Parameter_As_Integer( 'page' ),
          $this->request->Get_POST_Parameter_As_String( 'search' ),
          $this->request->Get_POST_Parameter_As_Boolean( 'id' ),
          $this->request->Get_POST_Parameter_As_Boolean( 'mpn' ),
          $this->request->Get_POST_Parameter_As_Boolean( 'description' ),
          $this->request->Get_POST_Parameter_As_String( 'manufacturer' ),
          $this->language->Get_Language_Code()
        );

        // Process each item in the list
        foreach ( $items as $item )
        {

          // Add item information
          $json[ 'items' ][] = array(
            'guid' => $item[ 'guid' ],
            'item_href' => $this->url->link( 'workplace/items/info', 'guid=' . $item[ 'guid' ], 'SSL' ),
            'mpn' => $item[ 'mpn' ],
            'description' => $item[ 'description' ],
            'manufacturer_name' => $item[ 'manufacturer_name' ],
            'id' => $item[ 'id' ],
            'status' => $item[ 'status' ]
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
  //
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------
  // Note: Method not used !!!

  public function Set_Page()
  {

    // Initialise json data
    $json = array();

    // Test for customer logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Set redirect link to login page
      $json[ 'redirect_url' ] = $this->url->link( 'account/login', '', 'SSL' );

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      $json[ 'return_code' ] = false;

      if (
        ( $this->request->Is_GET_Parameter_Exists( 'search' ) === true ) && 
        ( $this->request->Is_GET_Parameter_Exists( 'page_id' ) === true )
      )
      {

        // Load data models
        $this->load->model( 'items/items' );

        // Get items
        $search_items_count = $this->model_items_items->Search_Items_Count( $this->request->Get_GET_Parameter_As_String( 'search' ) );

        // Test for item count not a zero
        if( $search_items_count > 0 )
        {

          // Set page count
          $json[ 'page_count' ] = intdiv( $search_items_count, $this->page_length );

          // Get list of items
          $items = $this->model_items_items->Get_List_Of_Items(
            $this->page_length, 
            $this->request->Get_GET_Parameter_As_String( 'search' ), 
            $this->request->Get_GET_Parameter_As_String( 'page_id' )
          );

          // Process each item
          foreach ( $items as $item )
          {

            // Add item information
            $json[ 'items' ][] = array(
              'guid' => $item[ 'guid' ],
              'item_href' => $this->url->link( 'workplace/items/info', 'guid=' . $item[ 'guid' ], 'SSL' ),
              'mpn' => $item[ 'mpn' ],
              'manufacturer_name' => $item[ 'manufacturer_name' ]
            );

          }

          // Set success code
          $json[ 'return_code' ] = true;

        }

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