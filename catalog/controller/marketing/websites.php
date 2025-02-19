<?php
class ControllerMarketingWebsites extends Controller
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
      if ( $this->customer->Check_Permission( 'ms', 'websites', 'add' ) == false )
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
        
        // Add style
        $this->response->addStyle( 'catalog/view/stylesheet/marketing.css' );

        // Set document properties
        $this->response->setTitle( $this->language->get( 'ms_website_add_document_title' ) );

        // Set documet body strings
        $this->data[ 'heading_title' ] = $this->language->get( 'ms_website_add_page_heading' );
        $this->data[ 'website_add_placeholder_text' ] = $this->language->get( 'ms_website_add_url_query_placeholder_text' );
        $this->data[ 'website_add_button_caption' ] = $this->language->get( 'ms_website_add_button_add_caption' );
        $this->data[ 'website_add_result_added_text' ] = $this->language->get( 'ms_website_add_result_added_text' );
        $this->data[ 'website_add_result_error_text' ] = $this->language->get( 'ms_website_add_result_error_text' );
        $this->data[ 'website_add_result_exists_text' ] = $this->language->get( 'ms_website_add_result_exists_text' );
        $this->data[ 'website_add_result_unknown_text' ] = $this->language->get( 'ms_website_add_result_unknown_text' );

        // Set page configuration
        $this->children = array(
        'common/footer',
        'common/header'
        );

        // Render page
//        $this->response->Set_HTTP_Output( $this->Render( 'marketing/website_add.tpl' ) );

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
      $json[ 'url' ] = '-';
      $json[ 'return_code' ] = 'forbidden';

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test customer permission
      if ( $this->customer->Check_Permission( 'ms', 'websites', 'add' ) == false )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Access denied
        //----------------------------------------------------------------------

        // Set error code
        $json[ 'url' ] = '-';
        $json[ 'return_code' ] = 'denied';

      }
      else
      {

        //----------------------------------------------------------------------
        // Access grant
        //----------------------------------------------------------------------
        
        // Load model
        $this->load->model( 'marketing/websites' );

        // Test for parameter value setted
		    if ( isset( $this->request->post[ 'url' ] ) == false )
		    {

          //--------------------------------------------------------------------
          // ERROR: Parameter not set
          //--------------------------------------------------------------------

          // Set error code
          $json[ 'url' ] = '-';
          $json[ 'return_code' ] = 'error';
          $json[ 'error_code' ] = '-';
          $json[ 'error_message' ] = 'Parameter not set.';
          
        }
        else
        {

          //--------------------------------------------------------------------
          // Parameter present
          //--------------------------------------------------------------------
          
          // Get parameter
          $url = trim( $this->request->post[ 'url' ] );

          // Test URL validity
          $url_status = $this->model_marketing_websites->Is_Domain_Name_Valid( $url );
          
          if ( $url_status[ 'return_code' ] == false )
          {

            //------------------------------------------------------------------
            // ERROR: Invalid URL format
            //------------------------------------------------------------------

            // Set error code
            $json[ 'url' ] = $url;
            $json[ 'return_code' ] = 'error';
            $json[ 'error_code' ] = $url_status[ 'error_code' ];
            $json[ 'error_message' ] = 'Invalid URL format: ' . $url . ' - ' . $url_status[ 'error_code' ];

          }
          else
          {

            //------------------------------------------------------------------
            // URL format valid, continue processing
            //------------------------------------------------------------------
          
            // Test for URL already in database
            if ( $this->model_marketing_websites->Is_Exists( $url ) == true )
            {
            
              //----------------------------------------------------------------
              // ERROR: URL already exists
              //----------------------------------------------------------------

              // Set error code
              $json[ 'url' ] = $url;
              $json[ 'return_code' ] = 'exists';
            
            }
            else
            {
            
              //----------------------------------------------------------------
              // URL not exists in database
              //----------------------------------------------------------------
              
              // Try to add URL to database
              if ( $this->model_marketing_websites->Add( $url ) == false )
              {

                //----------------------------------------------------------------
                // ERROR: Database error
                //----------------------------------------------------------------

                // Set error code
                $json[ 'url' ] = $url;
                $json[ 'return_code' ] = 'error';
                $json[ 'error_code' ] = '-';
                $json[ 'error_message' ] = 'Database error.';

              }
              else
              {

                //----------------------------------------------------------------
                // Website added successfull
                //----------------------------------------------------------------

                // Set success code
                $json[ 'url' ] = $url;
                $json[ 'return_code' ] = 'success';

              }
          
            }

          }

        }
        
      }
      
    }

    // Render json responce
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------
  // End of file
  //----------------------------------------------------------------------------

}
?>