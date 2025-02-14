<?php
class ControllerMarketingEmails extends Controller
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
      if ( $this->customer->Check_Permission( 'ms', 'emails', 'add' ) == false )
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
        $this->data[ 'heading_title' ] = $this->language->get( 'ms_email_add_page_heading' );
        $this->data[ 'email_add_email_placeholder_text' ] = $this->language->get( 'ms_email_add_email_input_placeholder_text' );
        $this->data[ 'email_add_company_placeholder_text' ] = $this->language->get( 'ms_email_add_company_input_placeholder_text' );
        $this->data[ 'email_add_firstname_placeholder_text' ] = $this->language->get( 'ms_email_add_firstname_input_placeholder_text' );
        $this->data[ 'email_add_lastname_placeholder_text' ] = $this->language->get( 'ms_email_add_lastname_input_placeholder_text' );
        $this->data[ 'email_add_button_caption' ] = $this->language->get( 'ms_email_add_button_add_caption' );
        $this->data[ 'email_add_result_added_text' ] = $this->language->get( 'ms_email_add_result_added_text' );
        $this->data[ 'email_add_result_error_text' ] = $this->language->get( 'ms_email_add_result_error_text' );
        $this->data[ 'email_add_result_exists_text' ] = $this->language->get( 'ms_email_add_result_exists_text' );
        $this->data[ 'email_add_result_unknown_text' ] = $this->language->get( 'ms_email_add_result_unknown_text' );

        // Add style
        $this->response->addStyle( 'catalog/view/stylesheet/marketing.css' );

        // Set document properties
        $this->response->setTitle( $this->language->get( 'ms_email_add_document_title' ) );

        // Set page configuration
        $this->children = array(
        'common/footer',
        'common/header'
        );

        // Render page
//        $this->response->Set_HTTP_Output( $this->Render( 'marketing/email_add.tpl' ) );

      }
    
    }

  }

  //----------------------------------------------------------------------------
  // Add email address to database
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
      $json[ 'email' ] = '-';
      $json[ 'return_code' ] = 'forbidden';

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Test customer permission
      if ( $this->customer->Check_Permission( 'ms', 'emails', 'add' ) == false )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Access denied
        //----------------------------------------------------------------------

        // Set error code
        $json[ 'email' ] = '-';
        $json[ 'return_code' ] = 'denied';

      }
      else
      {

        // Load model
        $this->load->model( 'marketing/emails' );

        // Test for parameter value setted
		    if ( isset( $this->request->post[ 'email' ] ) == false )
		    {

          //--------------------------------------------------------------------
          // ERROR: Parameter not set
          //--------------------------------------------------------------------

          // Set error code
          $json[ 'email' ] = '-';
          $json[ 'return_code' ] = 'error';

        }
        else
        {

          // Get parameters
          $email = trim( $this->request->post[ 'email' ] );
          $company = ( isset( $this->request->post[ 'company' ] ) == false ) ? '' : trim( $this->request->post[ 'company' ] );
          $firstname = ( isset( $this->request->post[ 'firstname' ] ) == false ) ? '' : trim( $this->request->post[ 'firstname' ] );
          $lastname = ( isset( $this->request->post[ 'lastname' ] ) == false ) ? '' : trim( $this->request->post[ 'lastname' ] );
          
          // Test email address validity
          if ( $this->model_marketing_emails->Is_Email_Address_Valid( $email ) == false )
          {

            //------------------------------------------------------------------
            // ERROR: Invalid email format
            //------------------------------------------------------------------

            // Set error code
            $json[ 'email' ] = $email;
            $json[ 'return_code' ] = 'error';

          }
          else
          {

            //------------------------------------------------------------------
            // Email format valid, continue processing
            //------------------------------------------------------------------
          
            // Test for email address already exists in database
            if ( $this->model_marketing_emails->Is_Exists( $email ) == true )
            {
            
              //----------------------------------------------------------------
              // ERROR: URL already exists
              //----------------------------------------------------------------

              // Set error code
              $json[ 'email' ] = $email;
              $json[ 'return_code' ] = 'exists';
            
            }
            else
            {
            
              // Add email address to database
              if ( $this->model_marketing_emails->Add( $email, $company, $firstname, $lastname ) == false )
              {

                //--------------------------------------------------------------
                // ERROR: Adding failed
                //--------------------------------------------------------------

                // Set error code
                $json[ 'email' ] = $email;
                $json[ 'return_code' ] = 'error';

              }
              else
              {

                //----------------------------------------------------------------
                // Email address added successfull
                //----------------------------------------------------------------

                // Set success code
                $json[ 'email' ] = $email;
                $json[ 'return_code' ] = 'success';

              }
          
            }

          }

        }
        
      }
      
    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------

}
?>