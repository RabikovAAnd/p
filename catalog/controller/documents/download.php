<?php
class ControllerDocumentsDownload extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for customer not logged in
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

      // Test for document GUID parameter exists
      if ( $this->request->Is_GET_Parameter_GUID( 'document_guid' ) === false )
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
        $this->load->model( 'documents/documents' );

        // Get document GUID
        $document_guid = $this->request->Get_GET_Parameter_As_GUID( 'document_guid' );

        // Get document content
        $document_content = $this->model_documents_documents->Get_Document_Content( $document_guid );

        // Tes return code for any error
        if ( $document_content[ 'return_code' ] === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Get document content failed
          //--------------------------------------------------------------------

          //! @todo ANVILEX KM: Redirect to error page

        }
        else
        {

          //--------------------------------------------------------------------
          // Document content getted
          //--------------------------------------------------------------------

          // Set headers
          $this->response->Add_Header( 'Content-Disposition: attachment; filename="' . $document_content[ 'data' ][ 'filename' ] . '"' );
          $this->response->Add_Header( 'Content-Type: ' . $document_content[ 'data' ][ 'mime' ] );
          $this->response->Add_Header( 'Content-Length: ' . $document_content[ 'data' ][ 'size' ] );

          // Render page
          $this->response->Set_File_Output( $document_content[ 'data' ][ 'data' ] );

        }

      }

    }

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>