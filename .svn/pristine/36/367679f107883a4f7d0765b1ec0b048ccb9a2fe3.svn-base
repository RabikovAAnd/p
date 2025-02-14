<?php
class ControllerWorkplaceCategoriesStatusChange extends Controller
{

  //----------------------------------------------------------------------------
  // Change Category Status
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Change()
  {

    // Init json data
    $json = array();

    if (
      ($this->request->Is_GET_Parameter_GUID('guid') === false) ||
      ($this->request->Is_GET_Parameter_GUID('parent_guid') === false) ||
      ($this->request->Is_GET_Parameter_Exists('status') === false)
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

      // Get category info
      $parent_guid = $this->request->Get_GET_Parameter_As_GUID('parent_guid');
      $category_guid = $this->request->Get_GET_Parameter_As_GUID('guid');
      $status = $this->request->Get_GET_Parameter_As_String('status');

      // Load data model
      $this->load->model('categories/categories');

      if (
        ($status != 'inactive') &&
        ($status != 'active') &&
        ($status != 'deleted')
      ){
        
      } else
      {

        //! @bug ANVILEX KM: 'return_code' redefinition
        $this->model_categories_categories->Change_Category_Status($category_guid, $status);

        $json['redirect_url'] = $this->url->link('workplace/categories/info', 'guid=' . $parent_guid, 'SSL');
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