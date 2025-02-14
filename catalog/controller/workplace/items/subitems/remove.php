<?php
class ControllerWorkplaceItemsSubitemsRemove extends Controller
{

  //----------------------------------------------------------------------------
  // Remove item subitem
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function index()
  {

    // Init json data
    $json = array();


    if ($this->request->Is_POST_Parameter_GUID('subitem_index_guid') === false)
     {

      //----------------------------------------------------------------------
      // ERROR: Passed parameters not valid
      //----------------------------------------------------------------------

      // Set error code
      $json['return_code'] = false;

    } else 
    {

      //----------------------------------------------------------------------
      // Passed parameters valid
      //----------------------------------------------------------------------

      // Load data model
      $this->load->model('items/subitems/subitems');

      // Get item GUID 


      // Get subitem index GUID
      $subitem_index_guid = $this->request->Get_POST_Parameter_As_String('subitem_index_guid');


      // Try to delete item subitem
      if ($this->model_items_subitems_subitems->Delete_Item_Subitem($subitem_index_guid) === false) {

        //------------------------------------------------------------------
        // ERROR: Item subitem deletion failed
        //------------------------------------------------------------------

        // Set error code
        $json['return_code'] = false;

      } else {

        //------------------------------------------------------------------
        // Item subitem successfully deleted
        //------------------------------------------------------------------

        // Set delete element
        $json['delete'] = 'subitem' . $subitem_index_guid;

        // Set success code
        $json['return_code'] = true;

      }

    }
    $this->log->Log_Debug( 'delete  ' . $json['delete']);


    // Render page
    $this->response->Set_Json_Output( $json );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>