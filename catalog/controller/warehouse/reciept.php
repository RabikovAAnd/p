<?php
class ControllerWarehouseReciept extends Controller
{

  //----------------------------------------------------------------------------
  // Default page
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for suctomer logged
    if ( $this->customer->Is_Logged() == false )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Redirect
      $this->response->Redirect( $this->url->link( 'account/login', '', 'SSL' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test permission
      if ( $this->customer->Check_Permission( 'wms', 'goods', 'reciept' ) == false )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Access denied
        //----------------------------------------------------------------------
        
        // Redirect
        $this->response->Redirect( $this->url->link( 'error/not_found' ) );

      }
      else
      {
        
        //----------------------------------------------------------------------
        // Access grant, continue processing
        //----------------------------------------------------------------------
        
        // Set documet body strings
        $this->data[ 'heading_title' ] = 'Add item to warehouse ';//$this->language->get( 'ms_website_add_page_heading' );
        $this->data[ 'mpn_add_placeholder_text' ] = 'Enter MPN';//$this->language->get( 'ms_website_add_url_query_placeholder_text' );
        $this->data[ 'manufacturer_add_placeholder_text' ] = 'Enter manufacturer name';//$this->language->get( 'ms_website_add_url_query_placeholder_text' );
        $this->data[ 'quantity_add_placeholder_text' ] = 'Enter quantity';//$this->language->get( 'ms_website_add_url_query_placeholder_text' );
        $this->data[ 'website_add_button_caption' ] = 'Add';//$this->language->get( 'ms_website_add_button_add_caption' );
        $this->data[ 'website_add_result_added_text' ] = 'Added';//$this->language->get( 'ms_website_add_result_added_text' );
        $this->data[ 'website_add_result_error_text' ] = 'Error';//$this->language->get( 'ms_website_add_result_error_text' );
//        $this->data[ 'website_add_result_exists_text' ] = $this->language->get( 'ms_website_add_result_exists_text' );
//        $this->data[ 'website_add_result_unknown_text' ] = $this->language->get( 'ms_website_add_result_unknown_text' );

        // Set document properties
        $this->response->setTitle( $this->language->get( 'ms_website_add_document_title' ) );

        // Add style
        $this->response->addStyle( 'catalog/view/stylesheet/marketing.css' );

        // Set page configuration
        $this->children = array(
        'common/footer',
        'common/header'
        );

      }
    
    }

  }

  //----------------------------------------------------------------------------
  // Add website URL to database
  //----------------------------------------------------------------------------

  public function add()
  {
		
    // Init json data
    $json = array();

    // Test for suctomer logged
    if ( $this->customer->Is_Logged() == false )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Set error code
      $json[ 'error' ] = true;
      $json[ 'return_code' ] = 'forbidden';

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test customer permission
      if ( $this->customer->Check_Permission( 'wms', 'goods', 'reciept' ) == false )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Access denied
        //----------------------------------------------------------------------

        // Set error code
        $json[ 'error' ] = true;
        $json[ 'return_code' ] = 'denied';

      }
      else
      {

        // Test for parameter value setted
		    if ( ( isset( $this->request->post[ 'mpn' ] ) == false ) ||
		    ( isset( $this->request->post[ 'manufacturer' ] ) == false ) ||
		    ( isset( $this->request->post[ 'quantity' ] ) == false ) )
		    {

          //--------------------------------------------------------------------
          // ERROR: Parameter not set
          //--------------------------------------------------------------------

          // Set error code
        	$json[ 'error' ] = true;
          $json[ 'return_code' ] = 'error';

        }
        else
        {

        	// Load model
        	$this->load->model( 'warehouse/warehouse' );
    
    			$data = array(
    				'mpn'=> trim( $this->request->post[ 'mpn' ] ),
    				'manufacturer'=> trim( $this->request->post[ 'manufacturer' ] ),
    				'quantity'=> trim( $this->request->post[ 'quantity' ] ),
    				'customer_id'=> $this->customer->Get_ID()
    			);
/*
          // Test URL validity
          if ( $this->model_warehouse_warehouse->Add( $data ) == false )
          {

            //------------------------------------------------------------------
            // ERROR: Invalid URL format
            //------------------------------------------------------------------

            // Set error code
            $json[ 'error' ] = true;

          }
          else
          {

            //------------------------------------------------------------------
            // URL format valid, continue processing
            //------------------------------------------------------------------

						// Set success code
						$json[ 'error' ] = false;

          }
*/
        }
        
      }
      
    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------
  // Get supplier list
  //----------------------------------------------------------------------------

  public function get_supplier()
  {

    // Init json data
    $json = array();

    $json[ 'customers' ] = array( 1, 2 , 3 );

    // Render page
    $this->response->Set_Json_Output( $json );
    
  }
  
  //----------------------------------------------------------------------------

}
?>