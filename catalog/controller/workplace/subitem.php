<?php
class ControllerWorkplaceSubitem extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for customer logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $this->response->Redirect( $this->url->link( 'account/login', '', 'SSL' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test for item GUID parameter exists
      if ( $this->request->Is_GET_Parameter_Exists( 'subitem_guid' ) === false )
      {

        //----------------------------------------------------------------------
        // Item GUID not found
        //----------------------------------------------------------------------

      }
      else
      {

        //------------------------------------------------------------------------
        // Set page data
        //------------------------------------------------------------------------

        // Load messages
        $this->messages->Load( $this->data, 'workplace', 'item', 'index', $this->language->Get_Language_Code() );

        // Get item guid
        $item_guid = $this->request->Get_GET_Parameter_As_String( 'guid' );

        //----------------------------------------------------------------------
        // Item general data
        //----------------------------------------------------------------------

      }
     
      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle( $this->data[ 'item' ][ 'product_mpn' ] );
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

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>