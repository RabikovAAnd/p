<?php
class ControllerWorkplaceCustomersInteractionsItemsRemove extends Controller
{
  //----------------------------------------------------------------------------
  // Delete Project
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Remove()
  {

    // Init json data
    $json = array();

    if(($this->request->Is_GET_Parameter_ID('line_id') === false))
    {
      //----------------------------------------------------------------------
      // ERROR: Parameter not found
      //----------------------------------------------------------------------

      // Set error code
      $json['return_code'] = false;

    } else
    {

      //----------------------------------------------------------------------
      // Parameter found, continue processing
      //----------------------------------------------------------------------

      
      // Get line ID
      $line_id = $this->request->Get_GET_Parameter_As_ID('line_id');

      // Load data model
      $this->load->model('orders/orders');

      $json[ 'delete' ] = 'line' . $line_id;

      $this->model_orders_orders->Remove_Order_Line($line_id);
      
      // Set success code
      $json['return_code'] = true;

    }


    // Render page
    $this->response->Set_Json_Output($json);

  }


}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>