<?php
class ControllerWorkplaceItemsPropertiesRemove extends Controller
{

  //----------------------------------------------------------------------------
  // Remove item property
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Remove()
  {

    // Init json data
    $json = array();
/*
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
*/
      if (
        ( $this->request->Is_POST_Parameter_GUID( 'item_guid' ) === false ) ||
        ( $this->request->Is_POST_Parameter_GUID( 'property_guid' ) === false )
      )
      {

        //----------------------------------------------------------------------
        // ERROR: Passed parameters not valid
        //----------------------------------------------------------------------

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Passed parameters valid
        //----------------------------------------------------------------------

        // Load data model
        $this->load->model( 'items/properties' );

        // Get item GUID 
        // Note: This GUID needed to redirect to parent item after deletion processed.
        $item_guid = $this->request->Get_POST_Parameter_As_GUID( 'item_guid' );

        // Get subitem index GUID
        $property_guid = $this->request->Get_POST_Parameter_As_GUID( 'property_guid' );

        // Try to delete item subitem
        if ( $this->model_items_properties->Remove_Property( $property_guid, $item_guid) === false )
        {

          //------------------------------------------------------------------
          // ERROR: Item property deletion failed
          //------------------------------------------------------------------

          // Set error code
          $json[ 'return_code' ] = false;

        }
        else
        {

          //------------------------------------------------------------------
          // Item property successfully deleted
          //------------------------------------------------------------------

          // Set delete link
          $json[ 'delete' ] = 'property' . $property_guid;

          // Set success code
          $json[ 'return_code' ] = true;

        }

          // $json['redirect_url'] = $this->url->link('workplace/items/info', 'guid=' . $item_guid, 'SSL');

      }
/*
    }
*/
    // Render page
    $this->response->Set_Json_Output( $json );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>