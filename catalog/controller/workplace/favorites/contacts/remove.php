<?php
class ControllerWorkplaceFavoritesContactsRemove extends Controller
{


  //----------------------------------------------------------------------------
  // Delete contact
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Remove_From_Favorites()
  {

    // Init json data
    $json = array();

    if (
      ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )||
    ($this->request->Is_GET_Parameter_Boolean('remove') === false)
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
      // Parameter found, continue processing
      //----------------------------------------------------------------------

      // Get contact GUID
      $guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );


      if ( $this->customer->Is_In_Favorites( $this->customer->Get_GUID(), $guid ) === true )
      {

        if ($this->request->Get_GET_Parameter_As_Boolean('remove') === true) {

          // Set redirect link
          $json[ 'delete' ] = 'contact' . $guid;
        } 
        else 
        {
          // Set redirect URL
          $json['redirect_url'] = $this->url->link('workplace/customers/info', 'guid=' .  $guid, 'SSL');
        }

        
        $this->customer->Remove_From_Favorites( $this->customer->Get_GUID(), $guid );

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