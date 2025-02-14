<?php
class ControllerWorkplaceItemsSubitemsImport extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for item GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'item_guid' ) === false )
    {

      //----------------------------------------------------------------------
      // Item GUID not found
      //----------------------------------------------------------------------

      // Redirect to login page
      //! @bug ANVILEX KM: ???
      $this->response->Redirect( $this->url->link( 'account/login', '', 'SSL' ) );

    }
    else
    {

      //----------------------------------------------------------------------
      // Set page data
      //----------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'import_subitem', 'index', $this->language->Get_Language_Code() );

      // Load data models
      $this->load->model( 'items/items' );

      //----------------------------------------------------------------------
      // Item general data
      //----------------------------------------------------------------------

      // Get item guid from parameter
      $item_guid = $this->request->Get_GET_Parameter_As_String( 'item_guid' );

      // Get item data referenced by GUID
      $item = $this->model_items_items->Get_Information( $item_guid, $this->language->Get_Language_Code() );

      //! @todo ANVILEX KM: Check data validity!!!

      //! @todo ANVILEX KM: May be better to make direct assignment: $this->data[ 'item' ] = $item;
      $this->data[ 'item_guid' ] = $item[ 'guid' ];
      $this->data[ 'item_mpn' ] = $item[ 'mpn' ];

      $this->data[ 'item' ] = $item;

      // Compose button links
      $this->data[ 'get_file_button_href' ] = $this->url->link( 'workplace/items/subitems/import/Get_File','', 'SSL' );
      $this->data[ 'import_file_button_href' ] = $this->url->link( 'workplace/items/subitems/import/Import_File','', 'SSL' );

      //----------------------------------------------------------------------
      // Render page
      //----------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle( $item[ 'mpn' ] );
      $this->response->setDescription( $this->data[ 'workplace_import_subitem_header' ] . ' ' . $this->data[ 'item_mpn' ] );
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
  // Get subitem file
  //----------------------------------------------------------------------------

  public function Get_File()
  {

    // Init json data
    $json = array();

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

      // Test for all parameters present
      if (
        ( $this->request->Is_POST_Parameter_GUID( 'item_guid' ) === false ) ||
        ( isset( $_FILES[ 'file_data' ] ) === false ) )
      {

        //----------------------------------------------------------------------
        // ERROR: No file found
        //----------------------------------------------------------------------

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Parameters present
        //----------------------------------------------------------------------

        // Load data models
        $this->load->model( 'items/items' );
        $this->load->model( 'items/subitems/subitems' );

        // Get item GUID
        $item_guid = $this->request->Get_POST_Parameter_As_GUID( 'item_guid' );

        // Load CSV file
        $file = file( $_FILES[ 'file_data' ][ 'tmp_name' ] );

        // Create subitems data array
        $json[ 'subitems' ] = array();
        
        // Process each line of the CSV file
        foreach ( $file as $line )
        {

          // Test for not empty line
          if ( $line != '' )
          {

            // Parse CSV line
            // 0 - Pos
            // 1 - Designator
            // 2 - X
            // 3 - Y
            // 4 - Side
            // 5 - Rotation
            // 6 - ID
            // 7 - Quantity (optional)
            $fields = str_getcsv( $line );
  
            // Test for data row, skip import header line
            if( $fields[ '0' ] != "Pos" )
            {
  
              // Test for item referenced by ID exists
              if ( $this->model_items_items->Is_Exists_By_ID( $fields[ '6' ] ) === false )
              {
                
                //----------------------------------------------------------------
                // ERROR: Item not found
                //----------------------------------------------------------------
                
                // Add subitem to the list
                $json[ 'subitems' ][] = array(
                  'designator' => strtoupper( $fields[ '1' ] ),
                  'item_id' => $fields[ '6' ],
                  'guid' => '', // ANVILEX KM: Not needed
                  'item_href' => '',
                  'mpn' => '-',
                  'manufacturer_name' => '-',
                  'status_id' => '-', // ANVILEX KM: Not needed ???
                  'quantity' => $fields[ '7' ] == '' ? '1' : $fields[ '7' ],
                  'found' => false,
                  'exists' => false,
                  'valid' => false
                );
  
              }
              else
              {
              
                //----------------------------------------------------------------
                // Item found, get item information
                //----------------------------------------------------------------
                
                // Get item data
                $subitem = $this->model_items_items->Get_Information_by_ID( $fields[ '6' ] );

                // Add subitem to the list
                $json[ 'subitems' ][] = array(
                  'designator' => strtoupper( $fields[ '1' ] ),
                  'item_id' => $fields[ '6' ],
                  'guid' => $subitem[ 'guid' ], // ANVILEX KM: Not needed
                  'item_href' => $this->url->link( 'workplace/items/info', 'guid=' . $subitem[ 'guid' ], 'SSL' ),
                  'mpn' => $subitem[ 'product_mpn' ],
                  'manufacturer_name' => $subitem[ 'manufacturer_name' ],
                  'status_id' => $subitem[ 'status_id' ],
                  'quantity' => $fields[ '7' ] == '' ? '1' : $fields[ '7' ],
                  'found' => true,
                  'exists' => false,
                  'valid' => ( $this->model_items_subitems_subitems->Is_Exist_Item_Subitem( $item_guid, $subitem[ 'guid' ], strtoupper( $fields[ '1' ] ) ) ) ? false : $subitem[ 'valid' ]
                );
                
              }
            
            }

          }

        }

        // Set success code
        $json[ 'return_code' ] = true;

      }

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------
  // Get subitem file
  //----------------------------------------------------------------------------

  public function Import_File()
  {

    // Init json data
    $json = array();

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

      // Test for all parameters present
      if (
        ( $this->request->Is_POST_Parameter_GUID( 'item_guid' ) === false ) ||
        ( isset( $_FILES[ 'file_data' ] ) === false ) )
      {

        //----------------------------------------------------------------------
        // ERROR: Parameters not found
        //----------------------------------------------------------------------

        // Set error message
        $json[ 'error' ] = 'Error: Bad request, parameter not found. (Make this message multilingual)';
     
        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Parameters present
        //----------------------------------------------------------------------

        // Load data models
        $this->load->model( 'items/items' );
        $this->load->model( 'items/subitems/properties' );
        $this->load->model( 'items/subitems/subitems' );

        // Get item guid
        $item_guid = $this->request->Get_POST_Parameter_As_String( 'item_guid' );

        // Load CSV file
        $file = file( $_FILES[ 'file_data' ][ 'tmp_name' ] );

        // Create subitems data array
        $json[ 'subitems' ] = array();

        // Init import error status
        $import_error = false;
        
        // Process each line of the CSV file
        foreach ( $file as $line )
        {

          // Test for not empty line
          if ( $line != '' )
          {

            // Parse CSV line
            // 0 - Pos
            // 1 - Designator
            // 2 - X
            // 3 - Y
            // 4 - Side
            // 5 - Rotation
            // 6 - ID
            // 7 - Quantity (optional)
            $fields = str_getcsv( $line );

            //! @bug ANVILEX KM: Data checkung in fields requered.

            // Test for data row, skip import header line
            if ( $fields[ '0' ] != "Pos" )
            {

              // Test for item referenced by ID exists
              if ( $this->model_items_items->Is_Exists_By_ID( $fields[ '6' ] ) === false )
              {
                
                //----------------------------------------------------------------
                // ERROR: Item not found
                //----------------------------------------------------------------

                // Set import error status
                $import_error = true;

                // Terminate import
                break;
                
              }
              else
              {
              
                //----------------------------------------------------------------
                // Item found, get item information
                //----------------------------------------------------------------
                
                // Get item data referenced by ID
                $subitem = $this->model_items_items->Get_Information_by_ID( $fields[ '6' ] );

                // Check item data validity
                if ( $subitem[ 'valid' ] === false )
                {

                  //----------------------------------------------------------------
                  // ERROR: Item data invalid, reject line import
                  //----------------------------------------------------------------

                  // Set import error status
                  $import_error = true;

                  // Terminate import
                  break;

                }
                else
                {

                  //----------------------------------------------------------------
                  // Item data valid, import line
                  //----------------------------------------------------------------

                  // Compose subitem data
                  $subitem_info = array(
                    'designator' => strtoupper( $fields[ '1' ] ),
                    'item_id' => $fields[ '6' ],
                    'item_guid' => $item_guid,
                    'subitem_guid' => $subitem[ 'guid' ],
                    'mpn' => $subitem[ 'product_mpn' ],
                    'quantity' => ! isset( $fields[ '7' ] ) ? $fields[ '7' ] : 1
                  );

                  // Check for subitem already exists
                  if ( $this->model_items_subitems_subitems->Is_Exist_Item_Subitem( $item_guid, $subitem_info[ 'subitem_guid' ],  $subitem_info[ 'designator' ] ) === true )
                  {

                    //----------------------------------------------------------
                    // Subitem exist, try to update it
                    //----------------------------------------------------------

                    //! @todo ANVILEX KM: Implement updating item 
                  
                  }
                  else
                  {

                    //----------------------------------------------------------
                    // Subitem not exist, create it
                    //----------------------------------------------------------

                    // Add subitem
                    $return_data = $this->model_items_subitems_subitems->Add_Subitem( $subitem_info );

                    // Test for create subitem failed
                    if ( $return_data[ 'return_code' ] === false )
                    {
                      
                      //--------------------------------------------------------
                      // ERROR: Subitem not created
                      //--------------------------------------------------------
                      
                      // Set import error status
                      $import_error = true;

                    }
                    else
                    {
                      
                      //--------------------------------------------------------
                      // Subitem created
                      //--------------------------------------------------------
                      
                      //----------------------------------------------------------
                      // Coordinate X
                      //----------------------------------------------------------
                      
                      $subitem_property_data = array(
                        'subitem_guid' => $return_data[ 'subitem_guid' ],               
                        'property_guid' => '00000000000000000000000000000000',
                        'property_name' => 'x_position',
                        'property_value' => $fields[ '2' ] 
                      );
                      
                      // Add subitem properties
                      $this->model_items_subitems_properties->Create( $subitem_property_data );
                      
                      //----------------------------------------------------------
                      // Coordinate Y
                      //----------------------------------------------------------
                      
                      $subitem_property_data = array(
                        'subitem_guid' => $return_data[ 'subitem_guid' ],               
                        'property_guid' => '00000000000000000000000000000000',
                        'property_name' => 'y_position',
                        'property_value' => $fields[ '3' ]
                      );
                      
                      // Add subitem properties
                      $this->model_items_subitems_properties->Create( $subitem_property_data );
                      
                      //----------------------------------------------------------
                      // Coordinate Z
                      //----------------------------------------------------------
                      
                      $subitem_property_data = array(
                        'subitem_guid' => $return_data[ 'subitem_guid' ],               
                        'property_guid' => '00000000000000000000000000000000',
                        'property_name' => 'z_position',
                        'property_value' => '0'
                      );

                      // Add subitem properties
                      $this->model_items_subitems_properties->Create( $subitem_property_data );
                      
                      //----------------------------------------------------------
                      // Rotation Z
                      //----------------------------------------------------------
                      
                      $subitem_property_data = array(
                        'subitem_guid' => $return_data[ 'subitem_guid' ],               
                        'property_guid' => '00000000000000000000000000000000',
                        'property_name' => 'z_rotation',
                        'property_value' => trim( $fields[ '5' ], "\n\r\t\v\x00\xB0" )
                      );

                      // Add subitem properties
                      $this->model_items_subitems_properties->Create( $subitem_property_data );
                      
                      //----------------------------------------------------------
                      // Side
                      //----------------------------------------------------------
                      
                      $subitem_property_data = array(
                        'subitem_guid' => $return_data[ 'subitem_guid' ],               
                        'property_guid' => '00000000000000000000000000000000',
                        'property_name' => 'top_side',
                        'property_value' => ( ( $fields[ '4' ] == 'oben' ) || ( $fields[ '4' ] == 'top' ) ) ? '1' : '0'
                      );
                      
                      // Add subitem properties
                      $this->model_items_subitems_properties->Create( $subitem_property_data );

                    }

                  }

                }
                
              }

            }

          }

        }

        //----------------------------------------------------------------------
        // Check results
        //----------------------------------------------------------------------
        
        // Test for import error present
        if ( $import_error === true )
        {
          
          //--------------------------------------------------------------------
          // Import failed, try to rollback database
          //--------------------------------------------------------------------

          // Set error message
          $json[ 'error' ] = 'Error: Import failed. (Make this message multilingual)';

          // Set error code
          $json[ 'return_code' ] = false;

        }
        else
        {
          
          //--------------------------------------------------------------------
          // Import successed
          //--------------------------------------------------------------------

          // Set redirect link
          $json[ 'redirect_url' ] = $this->url->link( 'workplace/items/info', 'guid=' . $item_guid, 'SSL' );

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