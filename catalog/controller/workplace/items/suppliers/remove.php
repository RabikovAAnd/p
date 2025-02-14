<?php
class ControllerWorkplaceItemsSuppliersRemove extends Controller
{

  //----------------------------------------------------------------------------
  // Remove item supplier
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function index()
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
        ( $this->request->Is_POST_Parameter_GUID( 'supplier_guid' ) === false )
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
        $this->load->model( 'customers/suppliers' );

        // Get item GUID 
        // Note: This GUID needed to redirect to parent item after deletion processed.
        $item_guid = $this->request->Get_POST_Parameter_As_GUID( 'item_guid' );

        // Get supplier GUID
        $supplier_guid = $this->request->Get_POST_Parameter_As_GUID( 'supplier_guid' );

        // Try to delete item subitem
        if ( $this->model_customers_suppliers->Delete_Item_Supplier( $item_guid, $supplier_guid ) === false )
        {
        
          //------------------------------------------------------------------
          // ERROR: Item supplier deletion failed
          //------------------------------------------------------------------
        
          // Set error code
          $json[ 'return_code' ] = false;
        
        }
        else
        {
        
          //------------------------------------------------------------------
          // Item supplier successfully deleted
          //------------------------------------------------------------------
        

          // Set delete element
          $json[ 'delete' ] = 'supplier'.$supplier_guid;
        
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