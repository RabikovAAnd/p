<?php
class ControllerWorkplaceItemsDocumentsRemove extends Controller
{

  //----------------------------------------------------------------------------
  // Remove item document
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Remove()
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

      if (
        ( $this->request->Is_POST_Parameter_GUID( 'item_guid' ) === false ) ||
        ( $this->request->Is_POST_Parameter_GUID( 'document_guid' ) === false )
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
        $this->load->model( 'documents/documents' );

        // Get item GUID 
        $item_guid = $this->request->Get_POST_Parameter_As_GUID( 'item_guid' );

        // Get subitem index GUID
        $document_guid = $this->request->Get_POST_Parameter_As_GUID( 'document_guid' );


        // Try to delete item subitem
        if ( $this->model_documents_documents->Remove_Document( $document_guid, $item_guid ) === false )
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

          // Set delete element
          $json[ 'delete' ] = 'document'.$document_guid;

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