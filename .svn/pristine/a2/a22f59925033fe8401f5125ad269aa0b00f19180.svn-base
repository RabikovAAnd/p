<?php
class ControllerWorkplaceFavoritesItemsAdd extends Controller
{

  //----------------------------------------------------------------------------
  // Add item to favorites list
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Add_To_Favorites()
  {

    // Init json data
    $json = array();

    // Test for customer logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // Customer not logged in
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

      // Test for item GUID parameter exists
      if ( $this->request->Is_POST_Parameter_GUID( 'item_guid' ) === false )
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
        // Parameter found
        //----------------------------------------------------------------------

        // Load data model
        $this->load->model( 'items/items' );

        // Get item GUID
        $item_guid =  $this->request->Get_POST_Parameter_As_GUID( 'item_guid' );

        //! @todo ANVILEX KM: Check for item exists to prevent showing empty page.

        // Add item to customer favorites list
        $this->model_items_items->Add_To_Favorites( $this->customer->Get_GUID(), $item_guid );

        // Set redirect URL
        $json[ 'redirect_url' ] =  $this->url->link( 'workplace/items/info', 'guid=' . $item_guid, 'SSL' );

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