<?php
class ControllerWorkplaceFavoritesContactsAdd extends Controller
{

//----------------------------------------------------------------------------
  // Add contact to favorites list
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Add_To_Favorites()
  {

    // Init json data
    $json = array();

   
    // Test for contact GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
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

      // Get contact GUID
      $contact_guid =  $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      // Add contact to customer favorites list
      $this->customer->Add_To_Favorites( $this->customer->Get_GUID(), $contact_guid );
      
      // Set redirect URL
      $json[ 'redirect_url' ] =  $this->url->link( 'workplace/customers/info', 'guid=' . $contact_guid, 'SSL' );
      
      // Set success code
      $json[ 'return_code' ] = true;

    }

    

    // Render page
    $this->response->Set_Json_Output( $json );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>