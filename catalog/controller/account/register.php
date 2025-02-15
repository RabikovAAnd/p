<?php

class ControllerAccountRegister extends Controller
{

  //----------------------------------------------------------------------------
  // Default page
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for customer already logged
    if ( $this->customer->Is_Logged() === true ) 
    {
     
      //------------------------------------------------------------------------
      // Customer is logged in
      //------------------------------------------------------------------------

      // Retirect to account page     
      $this->response->Redirect( $this->url->link( 'account/account', '', 'SSL' ) );

    } 
    else 
    {

      //------------------------------------------------------------------------
      // Customer is not logged in
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'account', 'register', 'index', $this->language->Get_Language_Code() );

      $this->data[ 'terms_href' ] = $this->url->link( 'company/terms', '', 'SSL' );
      $this->data[ 'conditions_href' ] = $this->url->link( 'company/conditions', '', 'SSL' );
      $this->data[ 'privacy_href' ] = $this->url->link( 'company/privacy', '', 'SSL' );
      $this->data[ 'register_href' ] = $this->url->link( 'account/register/Create', '', 'SSL' );

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
      $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
      $this->response->setKeywords( '' );
      $this->response->setRobots( 'index, follow' );

      // Set page template
      $this->children = array(
        'common/footer',
        'common/header'
      );

    }

  }

  //----------------------------------------------------------------------------
  // Create new customer
  //----------------------------------------------------------------------------

  //! @todo ANVILEX KM: Rewrire code using new JSON responce format.

  public function Create()
  {

    // Init json data
    $json = array();

    // Test for customer already logged
    if ( $this->customer->Is_Logged() === true ) 
    {

      //------------------------------------------------------------------------
      // Customer already logged in
      //------------------------------------------------------------------------

      // Redirect to account page
      $json[ 'redirect_url' ] = $this->url->link( 'account/account', '', 'SSL' );

      // Set error code
      $json[ 'return_code' ] = false;

    } 
    else 
    {

      //------------------------------------------------------------------------
      // Custommer not logged in
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'account', 'register', 'create', $this->language->Get_Language_Code() );

      // Init customer data
      $data = array();

      // Clear request data valid status
      $request_data_valid = true;

      //------------------------------------------------------------------------
      
      //! @todo ANVILEX KM: Rewrite code and optimise!!!
      
      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Boolean( 'legal_entity' ) === false )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Legal entity parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'legal_entity' ] = $this->data[ 'account_register_legal_entity_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Legal entity parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $data[ 'legal_entity' ] = $this->request->Get_POST_Parameter_As_Boolean( 'legal_entity' );

      }

      //------------------------------------------------------------------------
      // First name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'firstname' )  === false)
      {
        
        //----------------------------------------------------------------------
        // ERROR: First name parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $json[ 'error' ][ 'firstname' ] = $this->data[ 'account_register_firstname_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // First name parameter found
        //----------------------------------------------------------------------

        // Test forst name validity
        if ($this->request->Is_POST_Parameter_Certain_Size_String( 'firstname', 1, $this->customer->Get_Customer_Firstname_Maximum_String_Size() ) === false)
        {
          
          //--------------------------------------------------------------------
          // ERROR: First name invalid
          //--------------------------------------------------------------------
         
          // Set error message text
          $json[ 'error' ][ 'firstname' ] = $this->data[ 'account_register_firstname_error' ];

          // Clear request data valid status
          $request_data_valid = false;
 
        }
        else
        {
          
          //--------------------------------------------------------------------
          // First name valid
          //--------------------------------------------------------------------
      
          // Store customer data
          $data[ 'firstname' ] = trim( $this->request->Get_POST_Parameter_As_String( 'firstname' ) );
        }
        
      }

      //------------------------------------------------------------------------
      // Last name
      //------------------------------------------------------------------------
      
      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'lastname' ) === false)
      {
        
        //----------------------------------------------------------------------
        // ERROR: Last name parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $json[ 'error' ][ 'lastname' ] = $this->data[ 'account_register_lastname_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Last name parameter found
        //----------------------------------------------------------------------

        // Test last name validity
        if ($this->request->Is_POST_Parameter_Certain_Size_String( 'lastname', 1, $this->customer->Get_Customer_Lastname_Maximum_String_Size() ) === false)
        {
          
          //--------------------------------------------------------------------
          // ERROR: Last name invalid
          //--------------------------------------------------------------------
         
          // Set error message text
          $json[ 'error' ][ 'lastname' ] = $this->data[ 'account_register_lastname_error' ];

          // Clear request data valid status
          $request_data_valid = false;
 
        }
        else
        {
          
          //--------------------------------------------------------------------
          // Last name valid
          //--------------------------------------------------------------------

          // Store customer data
          $data[ 'lastname' ] = trim( $this->request->Get_POST_Parameter_As_String( 'lastname' ) );

        }
        
      }

      //------------------------------------------------------------------------
      // Middle name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'middlename' ) === false)
      {
        
        //----------------------------------------------------------------------
        // ERROR: Middle name parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $json[ 'error' ][ 'middlename' ] = $this->data[ 'account_register_middlename_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Middle name parameter found
        //----------------------------------------------------------------------

        // Test middle name validity
        if  ($this->request->Is_POST_Parameter_Certain_Size_String( 'middlename', 0, $this->customer->Get_Customer_Middlename_Maximum_String_Size() ) === false)
        {
          
          //--------------------------------------------------------------------
          // ERROR: Middle name invalid
          //--------------------------------------------------------------------
         
          // Set error message text
          $json[ 'error' ][ 'middlename' ] = $this->data[ 'account_register_middlename_error' ];

          // Clear request data valid status
          $request_data_valid = false;
 
        }
        else
        {
          
          //--------------------------------------------------------------------
          // Middle name valid
          //--------------------------------------------------------------------

          // Store customer data
          $data[ 'middlename' ] = trim( $this->request->Get_POST_Parameter_As_String( 'middlename' ) );

        }
        
      }
      
      //------------------------------------------------------------------------
      // Email address
      //------------------------------------------------------------------------
      
      // Test for parameter exists
      if($this->request->Is_POST_Parameter_Exists( 'email' ) === false)
      {
        
        //----------------------------------------------------------------------
        // ERROR: First name parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $json[ 'error' ][ 'email' ] = $this->data[ 'account_register_email_not_exist_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Email parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $data[ 'email' ] = trim( $this->request->Get_POST_Parameter_As_String( 'email' ) );

        $mail = new Mail();
        
        // Test email format
        if ( $mail->Is_Email_Valid( $data[ 'email' ] ) === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Email is invalid
          //--------------------------------------------------------------------
          
          // Set error message text
          $json[ 'error' ][ 'email' ] = $this->data[ 'account_register_' . $this->request->Post_Parameter_Is_Mail('email')['response'] ];
          
          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {
          
          //--------------------------------------------------------------------
          // Email valid
          //--------------------------------------------------------------------

          // Check for customer already registered
          if ( $this->customer->Is_Exists( $data[ 'email' ] ) === true )
          {

            //------------------------------------------------------------------
            // ERROR: User already registered
            //------------------------------------------------------------------

            // Set error message text
            $json[ 'error' ][ 'email' ] = $this->data[ 'account_register_email_exists_error' ];

            // Clear request data valid status
            $request_data_valid = false;

          }
          else
          {
          
            //------------------------------------------------------------------
            // Customer email not registered
            //------------------------------------------------------------------


          }

        }

      }
      
      //------------------------------------------------------------------------
      // Phone
      //------------------------------------------------------------------------
      
      // Test for parameter exists
      if($this->request->Is_POST_Parameter_Exists( 'telephone' ) === false)
      {

        //----------------------------------------------------------------------
        // ERROR: Phone number parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $json[ 'error' ][ 'telephone' ] = $this->data[ 'account_register_telephone_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Phone number parameter found
        //----------------------------------------------------------------------

        // Test phone number validity
        if ($this->request->Is_POST_Parameter_Certain_Size_String( 'telephone', 0, $this->customer->Get_Customer_Telephone_Maximum_String_Size() ) === false)
        {
          
          //--------------------------------------------------------------------
          // ERROR: Phone number invalid
          //--------------------------------------------------------------------
         
          // Set error message text
          $json[ 'error' ][ 'telephone' ] = $this->data[ 'account_register_telephone_error' ];

          // Clear request data valid status
          $request_data_valid = false;
 
        }
        else
        {
          
          //--------------------------------------------------------------------
          // Phone number valid
          //--------------------------------------------------------------------
       
          // Store customer data
          $data[ 'telephone' ] = trim( $this->request->Get_POST_Parameter_As_String( 'telephone' ) );
        }
        
      }

      //------------------------------------------------------------------------
      // Company name
      //------------------------------------------------------------------------
      
      if ( $data[ 'legal_entity' ] === false )
      {

        //----------------------------------------------------------------------
        // Private customer
        //----------------------------------------------------------------------

        // Clear company name
        $data[ 'company_name' ] = '';

        // Set request data valid status
        $request_data_valid = $request_data_valid && true;

      }
      else
      {
        
        //----------------------------------------------------------------------
        // Legal entity customer
        //----------------------------------------------------------------------

        // Test for parameter exists
        if($this->request->Is_POST_Parameter_Exists( 'company_name' ) === false)
        {
  
          //----------------------------------------------------------------------
          // ERROR: Company name parameter not found
          //----------------------------------------------------------------------
          
          // Set error message text
          $json[ 'error' ][ 'company_name' ] = $this->data[ 'account_register_company_name_error' ];
  
          // Clear request data valid status
          $request_data_valid = false;
  
        }
        else
        {
  
          //----------------------------------------------------------------------
          // Company name parameter found
          //----------------------------------------------------------------------
  
          // Test company name validity
          if ($this->request->Is_POST_Parameter_Certain_Size_String( 'company_name', 0, $this->customer->Get_Customer_Company_Name_Maximum_String_Size() ) === false)
          {
            
            //--------------------------------------------------------------------
            // ERROR: Company name invalid
            //--------------------------------------------------------------------
           
            // Set error message text
            $json[ 'error' ][ 'company_name' ] = $this->data[ 'account_register_company_name_error' ];
  
            // Clear request data valid status
            $request_data_valid = false;
   
          }
          else
          {
            
            //--------------------------------------------------------------------
            // Company name valid
            //--------------------------------------------------------------------
          
            // Store customer data
            $data[ 'company_name' ] = trim( $this->request->Get_POST_Parameter_As_String( 'company_name' ) );
  
          }
          
        }
  
      }
      
      //------------------------------------------------------------------------
      // Company register ID
      //------------------------------------------------------------------------

      // Entity decoder
      if ( $data[ 'legal_entity' ] === false )
      {

        //----------------------------------------------------------------------
        // Private customer
        //----------------------------------------------------------------------

        // Clear company register ID
        $data[ 'company_register_id' ] = '';


      }
      else
      {
        
        //----------------------------------------------------------------------
        // Legal entity customer
        //----------------------------------------------------------------------

        // Test for parameter exists
        if($this->request->Is_POST_Parameter_Exists( 'company_register_id' ) === false)
        {
  
          //----------------------------------------------------------------------
          // ERROR: Company name parameter not found
          //----------------------------------------------------------------------
          
          // Set error message text
          $json[ 'error' ][ 'company_register_id' ] = $this->data[ 'account_register_company_register_id_error' ];
  
          // Clear request data valid status
          $request_data_valid = false;
  
        }
        else
        {
  
          //----------------------------------------------------------------------
          // Company register ID parameter found
          //----------------------------------------------------------------------
  
          // Test company register ID validity
          if ($this->request->Is_POST_Parameter_Certain_Size_String( 'company_register_id', 1, $this->customer->Get_Customer_Company_Register_ID_Maximum_String_Size() ) === false)
          {
            
            //--------------------------------------------------------------------
            // ERROR: Company register ID invalid
            //--------------------------------------------------------------------
           
            // Set error message text
            $json[ 'error' ][ 'company_register_id' ] = $this->data[ 'account_register_company_register_id_error' ];
  
            // Clear request data valid status
            $request_data_valid = false;
   
          }
          else
          {
            
            //--------------------------------------------------------------------
            // Company register ID valid
            //--------------------------------------------------------------------
       
            // Store customer data
            $data[ 'company_register_id' ] = trim( $this->request->Get_POST_Parameter_As_String( 'company_register_id' ) );
          }
          
        }
  
      }

      //------------------------------------------------------------------------
      // Company tax ID
      //------------------------------------------------------------------------

      // Entity decoder
      if ( $data[ 'legal_entity' ] === false )
      {

        //----------------------------------------------------------------------
        // Private customer
        //----------------------------------------------------------------------

        // Clear company tax ID
        $data[ 'company_tax_id' ] = '';

        // Set request data valid status
        $request_data_valid = $request_data_valid && true;

      }
      else
      {
        
        //----------------------------------------------------------------------
        // Legal entity customer
        //----------------------------------------------------------------------

        // Test for parameter exists
        if($this->request->Is_POST_Parameter_Exists( 'company_tax_id' ) === false)
        {
  
          //----------------------------------------------------------------------
          // ERROR: Company tax ID parameter not found
          //----------------------------------------------------------------------
          
          // Set error message text
          $json[ 'error' ][ 'company_tax_id' ] = $this->data[ 'account_register_company_tax_id_error' ];
  
          // Clear request data valid status
          $request_data_valid = false;
  
        }
        else
        {
  
          //----------------------------------------------------------------------
          // Company tax ID parameter found
          //----------------------------------------------------------------------
  
          // Test company tax ID validity
          if ($this->request->Is_POST_Parameter_Certain_Size_String( 'company_tax_id', 1, $this->customer->Get_Customer_Company_Tax_ID_Maximum_String_Size() ) === false)
          {
            
            //--------------------------------------------------------------------
            // ERROR: Company tax ID invalid
            //--------------------------------------------------------------------
           
            // Set error message text
            $json[ 'error' ][ 'company_tax_id' ] = $this->data[ 'account_register_company_tax_id_error' ];
  
            // Clear request data valid status
            $request_data_valid = false;
   
          }
          else
          {
            
            //--------------------------------------------------------------------
            // Company tax ID valid
            //--------------------------------------------------------------------

            // Store customer data
            $data[ 'company_tax_id' ] = trim( $this->request->Get_POST_Parameter_As_String( 'company_tax_id' ) );
          }
          
        }
  
      }

//        $this->data['tax_id'] = (!isset($this->request->post['tax_id'])) ? '' :  trim($this->request->post['tax_id']);

/*
            $this->load->model('localisation/country');

            $country_info = $this->model_localisation_country->getCountry($this->data['country_id']);

            if ($country_info) 
            {
                // VAT Validation
                $this->load->helper('vat');

                if ($this->config->get('config_vat') && $this->request->Get_POST_Parameter_As_String('tax_id')
                    && (vat_validation($country_info['iso_code_2'], $this->request->Get_POST_Parameter_As_String('tax_id')) == 'invalid')) 
                {
                    $json[ 'error' ]['tax_id'] = $this->data['account_register_vat_error'];
                }
            }

            if (($this->request->Get_POST_Parameter_As_String('tax_id') == '')
                || ( !is_numeric($this->request->Get_POST_Parameter_As_String('tax_id')))) 
            {
                $json[ 'error' ]['tax_id'] = $this->data['account_register_tax_id_error'];
            }
*/

      //------------------------------------------------------------------------
      // Company VAT ID
      //------------------------------------------------------------------------
/*
      // Entity decoder
      if ( $data[ 'legal_entity' ] === false )
      {

        //----------------------------------------------------------------------
        // Private customer
        //----------------------------------------------------------------------

        // Clear company VAT ID
        $data[ 'company_vat_id' ] = '';

      }
      else
      {
        
        //----------------------------------------------------------------------
        // Legal entity customer
        //----------------------------------------------------------------------

        // Test for parameter exists
        if( ! $this->request->Is_POST_Parameter_Exists( 'company_vat_id' ) )
        {
  
          //----------------------------------------------------------------------
          // ERROR: Company VAT ID parameter not found
          //----------------------------------------------------------------------
          
          // Set error message text
          $json[ 'error' ][ 'company_vat_id' ] = $this->data[ 'account_register_company_vat_id_error' ];
  
          // Clear request data valid status
          $request_data_valid = false;
  
        }
        else
        {
  
          //----------------------------------------------------------------------
          // Company VAT ID parameter found
          //----------------------------------------------------------------------
  
          // Store customer data
          $data[ 'company_vat_id' ] = trim( $this->request->Get_POST_Parameter_As_String( 'company_vat_id' ) );
  
          // Test company VAT ID validity
          if ( utf8_strlen( $data[ 'company_vat_id' ] ) > 32 )
          {
            
            //--------------------------------------------------------------------
            // ERROR: Company VAT ID invalid
            //--------------------------------------------------------------------
           
            // Set error message text
            $json[ 'error' ][ 'company_vat_id' ] = $this->data[ 'account_register_company_vat_id_error' ];
  
            // Clear request data valid status
            $request_data_valid = false;
   
          }
          else
          {
            
            //--------------------------------------------------------------------
            // Company VAT ID valid
            //--------------------------------------------------------------------
          
            $json[ 'error' ][ 'company_vat_id' ] = $data[ 'company_vat_id' ];
          
            // Set request data valid status
            $request_data_valid = true;
  
          }
          
        }
  
      }
*/
      //------------------------------------------------------------------------
      // Password
      //------------------------------------------------------------------------

      // Test for parameter exists
      if($this->request->Is_POST_Parameter_Exists( 'password' ) === false)
      {

        //----------------------------------------------------------------------
        // ERROR: Password parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $json[ 'error' ][ 'password' ] = $this->data[ 'account_register_password_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Password parameter found
        //----------------------------------------------------------------------


        // Test password validity
        if ($this->request->Is_POST_Parameter_Password( 'password', 8, $this->customer->Get_Customer_Password_Maximum_String_Size() ) === false)
        {
          
          //--------------------------------------------------------------------
          // ERROR: Password invalid
          //--------------------------------------------------------------------
         
          // Set error message text
          $json[ 'error' ][ 'password' ] = $this->data[ 'account_register_password_error' ];

          // Clear request data valid status
          $request_data_valid = false;
 
        }
        else
        {
          
          //--------------------------------------------------------------------
          // Password valid
          //--------------------------------------------------------------------
        
          // Store customer data
          $data[ 'password' ] = trim( $this->request->Get_POST_Parameter_As_String( 'password' ) );

        }
        
      }

      //------------------------------------------------------------------------
      // Confirm password
      //------------------------------------------------------------------------
      
      // Test for parameter exists
      if($this->request->Is_POST_Parameter_Exists( 'confirm' ) === false)
      {

        //----------------------------------------------------------------------
        // ERROR: Password confirm parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $json[ 'error' ][ 'confirm' ] = $this->data[ 'account_register_confirm_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Password confirm parameter found
        //----------------------------------------------------------------------

        // Get password confirm
        $password_confirm = trim( $this->request->Get_POST_Parameter_As_String( 'confirm' ) );

        // Test password validity
        if ( $data[ 'password' ] != $password_confirm )
        {

          //--------------------------------------------------------------------
          // ERROR: Password confirm invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'confirm' ] = $this->data[ 'account_register_confirm_error' ];

          // Clear request data valid status
          $request_data_valid = false;
 
        }
        else
        {

          //--------------------------------------------------------------------
          // Password valid
          //--------------------------------------------------------------------

          $data[ 'confirm' ] = $password_confirm;
        }

      }

      //------------------------------------------------------------------------
      // Newsletter subscription
      //------------------------------------------------------------------------
      
      // Test for parameter exists
      if($this->request->Is_POST_Parameter_Exists( 'newsletter' ) === false)
      {
        
        //----------------------------------------------------------------------
        // ERROR: Newsletter subscription parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'newsletter' ] = $this->data[ 'newsletter' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Newsletter subscription parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $newsletter = $this->request->Get_POST_Parameter_As_Boolean( 'newsletter' );
        
        $data[ 'newsletter' ] = $newsletter;

      }

      //------------------------------------------------------------------------

      // Test for parameter exists
      if($this->request->Is_POST_Parameter_Exists( 'terms' ) === false)
      {
        
        //----------------------------------------------------------------------
        // ERROR: Terms of use parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'terms' ] = $this->data[ 'account_register_terms_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Terms of use parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $terms_of_use = $this->request->Get_POST_Parameter_As_Boolean( 'terms' ); 
        
        // Test for terms of use accepted
        if ( $terms_of_use === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Terms of use not accepted
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'terms' ] = $this->data[ 'account_register_terms_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {
        
          //--------------------------------------------------------------------
          // Terms of use accepted
          //--------------------------------------------------------------------
         
          $data[ 'terms_of_use' ] = $terms_of_use;
        }
        
      }

      //------------------------------------------------------------------------
      // Privacy
      //------------------------------------------------------------------------

      // Test for parameter exists
      if($this->request->Is_POST_Parameter_Exists( 'privacy' ) === false)
      {
        
        //----------------------------------------------------------------------
        // ERROR: Privacy parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'privacy' ] = $this->data[ 'account_register_privacy_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Privacy parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $privacy = $this->request->Get_POST_Parameter_As_Boolean( 'privacy' ); 

        // Test for privacy accepted
        if ($privacy === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Privacy not accepted
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'privacy' ] = $this->data[ 'account_register_privacy_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Privacy accepted
          //--------------------------------------------------------------------

          $data[ 'privacy' ]= $privacy;
        
        }
        
      }

      //------------------------------------------------------------------------
      
      // Is request data valid
      if ( $request_data_valid === false )
      {

        //------------------------------------------------------------------------
        // ERROR: Parameters not valid
        //------------------------------------------------------------------------

        // Set error code
        $json[ 'return_code' ] = false;
       

      }
      else
      {

        //--------------------------------------------------------------------
        // Parameters present and valid
        //--------------------------------------------------------------------
        
        $this->session->data['register_success'] = 'success';
        
        // Generate customer GUID
        $guid = UUID_V4_T1();

        // Add new customer
       $this->customer->Create( $guid, $data );

        // Login using email and password
        $this->customer->login( $data[ 'email' ], $data[ 'password' ] );
        
        // Store customer GUID in session
        $this->session->data[ 'customer_guid' ] = $guid;
        
        //! @todo ANVILEX KM: Check for login successed and after that create cart.

        // Create customer cart
        $this->cart->Create();

        // Set success code
        $json[ 'return_code' ] = true;

        // Set redirect URL
        $json[ 'redirect_url' ] = $this->url->link( 'account/register_success', '', 'SSL' );
      }

    }

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>