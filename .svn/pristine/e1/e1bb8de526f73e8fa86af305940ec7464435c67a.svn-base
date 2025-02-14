<?php
class ControllerWorkplaceFavoritesItemsRemove extends Controller
{


  //----------------------------------------------------------------------------
  // Delete item
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Remove_From_Favorites()
  {

    // Init json data
    $json = array();

    if (
      ($this->request->Is_POST_Parameter_GUID('item_guid') === false) ||
      ($this->request->Is_POST_Parameter_Boolean('remove') === false)
    ) {
      //----------------------------------------------------------------------
      // ERROR: Parameter not found
      //----------------------------------------------------------------------

      // Set error code
      $json['return_code'] = false;

    } else {

      //----------------------------------------------------------------------
      // Parameter found, continue processing
      //----------------------------------------------------------------------

      // Get item GUID
      $item_guid = $this->request->Get_POST_Parameter_As_GUID('item_guid');

      // Load data model
      $this->load->model('items/items');

      if ($this->model_items_items->Is_In_Favorites($this->customer->Get_GUID(), $item_guid) === true) {


        if ($this->request->Get_POST_Parameter_As_Boolean('remove') === true) {
          // Set redirect link
          $json['delete'] = 'item' . $item_guid;
        } else {
          // Set redirect URL
          $json['redirect_url'] = $this->url->link('workplace/items/info', 'guid=' . $item_guid, 'SSL');
        }


        //! @bug ANVILEX KM: 'return_code' redefinition
        $json['return_code'] = $this->model_items_items->Remove_From_Favorites($this->customer->Get_GUID(), $item_guid);

        // Set success code
        $json['return_code'] = true;

      }

    }


    // Render page
    $this->response->Set_Json_Output($json);

  }


}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>