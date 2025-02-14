<?php
class ControllerWorkplaceItemsSubitemsDownload extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for item GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Item GUID not found
      //----------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // Set page data
      //------------------------------------------------------------------------

      // Load data model
      $this->load->model( 'items/items' );
      $this->load->model( 'items/subitems/subitems' );
      $this->load->model( 'items/subitems/properties' );

      // Get item GUID
      $item_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      // Get item data by item GUID
      $item_data = $this->model_items_items->Get_Information( $item_guid );

      //! @ todo ANVILEX KM:  Test for item data valid

      // Get item subitems
      $item_subitems = $this->model_items_subitems_subitems->Get_Item_Subitems( $item_guid );

      // Tes return code for any error
      if ( $item_subitems[ 'return_code' ] === false )
      {

        //--------------------------------------------------------------------
        // ERROR: Get item subitems failed
        //--------------------------------------------------------------------

        //! @todo ANVILEX KM: Redirect to error page

      }
      else
      {

        //--------------------------------------------------------------------
        // Item subitems getted
        //--------------------------------------------------------------------

        // Initialise file content
        $file_content = "Designator\tItem\tX\tY\tRotation\tSide" . PHP_EOL;

        // Process item subitems
        foreach ( $item_subitems[ 'data' ] as $item_subitem )
        {

          // Get item subitem data
          $item_subitem_info = $this->model_items_items->Get_Information( $item_subitem[ 'subitem_guid' ] );

          // Test for item subitem information valid
          if( $item_subitem_info[ 'valid' ] === true )
          {

            // Get item subitem properties data
            $item_subitem_properties = $this->model_items_subitems_properties->Get_Subitem_Properties( $item_subitem[ 'subitem_index_guid' ] );

            // Test for item subitem properties successfully getted
            if( $item_subitem_properties[ 'return_code' ] === false )
            {

              $this->log->Log_Debug( 'ERROR: Get item subitem properties failed.' );

            }
            else
            {

              // Iterate over all properties
              foreach ( $item_subitem_properties[ 'data' ] as $item_subitem_property )
              {

                if( $item_subitem_property[ 'property_name' ] === 'x_position' )
                {
                  $subitem_content[ 'X' ] = $item_subitem_property[ 'property_value' ];
                }

                if( $item_subitem_property[ 'property_name' ] ==='y_position' )
                {
                  $subitem_content[ 'Y' ] = $item_subitem_property[ 'property_value' ];
                }

                if( $item_subitem_property[ 'property_name' ] === 'z_rotation' )
                {
                  $subitem_content[ 'Rotation' ] = $item_subitem_property[ 'property_value' ];
                }

                if( $item_subitem_property[ 'property_name' ] === 'top_side' )
                {
                  $subitem_content[ 'Side' ] = ( $item_subitem_property[ 'property_value' ] === '1' || $item_subitem_property[ 'property_value' ] === 'oben' ) ? 'T' : 'B';
                }

              }

              // Define symbols to replace in MPN
              $mpn_filter = array( " ", "-", "+", ".", ",", "#" );

              // Set subitem content
              $file_content = $file_content .
                $item_subitem[ 'designator' ] . "\t" .
                'ID' . $item_subitem_info[ 'item_id' ] . "_" . str_replace( $mpn_filter, '_', $item_subitem_info[ 'mpn' ] ) . "\t" .
                $subitem_content[ 'X' ] . "\t" .
                $subitem_content[ 'Y' ] . "\t" .
                $subitem_content[ 'Rotation' ] . "\t" .
                $subitem_content[ 'Side' ] . PHP_EOL;

            }

          }

        }

      }

      // Set headers
      $this->response->Add_Header( 'Content-Disposition: attachment; filename="ID' . $item_data[ 'item_id' ] . "_" . $item_data[ 'product_mpn' ] . '.csv' .'"' );
      $this->response->Add_Header( 'Content-Type: text/csv' );
      $this->response->Add_Header( 'Content-Length: ' . strlen( $file_content ) );

      // Render page
      $this->response->Set_File_Output( $file_content );

    }

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>