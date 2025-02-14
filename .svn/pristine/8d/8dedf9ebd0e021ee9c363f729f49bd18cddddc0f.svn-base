<?php

class ControllerAccountRegister extends Controller
{

  private $error = array();

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

      $this->data[ 'action' ] = $this->url->link( 'account/register', '', 'SSL' );

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
      $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
      $this->response->setKeywords( '' );
      $this->response->setRobots( 'index, follow' );

      // Add styles
      $this->response->addStyle( 'catalog/view/stylesheet/account/register.css' );

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
      $customer_data = array();

      // Clear request data valid sataus
      $request_data_valid = true;

      //------------------------------------------------------------------------
      
      //! @todo ANVILEX KM: Rewrite code and optimise!!!
      
      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'legal_entity' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Legal entity parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'legal_entity' ] = $this->data[ 'legal_entity' ];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Legal entity parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data[ 'legal_entity' ] = $this->request->Get_POST_Parameter_As_Boolean( 'legal_entity' );

        $this->data[ 'legal_entity' ] = $customer_data[ 'legal_entity' ];

        // Set request data valid sataus
        $request_data_valid = $request_data_valid && true;

      }

      //------------------------------------------------------------------------
      // First name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'firstname' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR: First name parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'firstname' ] = $this->data[ 'account_register_firstname_error' ];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // First name parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data[ 'firstname' ] = trim( $this->request->Get_POST_Parameter_As_String( 'firstname' ) );

        // Test forst name validity
        if (
          ( utf8_strlen( $customer_data[ 'firstname' ] ) < 1 ) || 
          ( utf8_strlen( $customer_data[ 'firstname' ] ) > 32 )
        )
        {
          
          //--------------------------------------------------------------------
          // ERROR: First name invalid
          //--------------------------------------------------------------------
         
          // Set errer message text
          $this->error[ 'firstname' ] = $this->data[ 'account_register_firstname_error' ];

          // Clear request data valid sataus
          $request_data_valid = false;
 
        }
        else
        {
          
          //--------------------------------------------------------------------
          // First name valid
          //--------------------------------------------------------------------
        
//          $this->error[ 'firstname' ] = $customer_data[ 'firstname' ];
        
          // Set request data valid sataus
          $request_data_valid = $request_data_valid && true;

        }
        
      }

      //------------------------------------------------------------------------
      // Last name
      //------------------------------------------------------------------------
      
      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'lastname' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Last name parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'lastname' ] = $this->data[ 'account_register_lastname_error' ];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Last name parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data[ 'lastname' ] = trim( $this->request->Get_POST_Parameter_As_String( 'lastname' ) );

        // Test last name validity
        if (
          ( utf8_strlen( $customer_data[ 'lastname' ] ) < 1 ) || 
          ( utf8_strlen( $customer_data[ 'lastname' ] ) > 32 )
        )
        {
          
          //--------------------------------------------------------------------
          // ERROR: Last name invalid
          //--------------------------------------------------------------------
         
          // Set errer message text
          $this->error[ 'lastname' ] = $this->data[ 'account_register_lastname_error' ];

          // Clear request data valid sataus
          $request_data_valid = false;
 
        }
        else
        {
          
          //--------------------------------------------------------------------
          // Last name valid
          //--------------------------------------------------------------------
        
//          $this->error[ 'lastname' ] = $customer_data[ 'lastname' ];
        
          // Set request data valid sataus
          $request_data_valid = $request_data_valid && true;

        }
        
      }

      //------------------------------------------------------------------------
      // Middle name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'middlename' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Middle name parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'middlename' ] = $this->data[ 'account_register_middlename_error' ];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Middle name parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data[ 'middlename' ] = trim( $this->request->Get_POST_Parameter_As_String( 'middlename' ) );

        // Test middle name validity
        if ( utf8_strlen( $customer_data[ 'middlename' ] ) > 32 )
        {
          
          //--------------------------------------------------------------------
          // ERROR: Middle name invalid
          //--------------------------------------------------------------------
         
          // Set errer message text
          $this->error[ 'middlename' ] = $this->data[ 'account_register_middlename_error' ];

          // Clear request data valid sataus
          $request_data_valid = false;
 
        }
        else
        {
          
          //--------------------------------------------------------------------
          // Middle name valid
          //--------------------------------------------------------------------
        
//          $this->error[ 'middlename' ] = $customer_data[ 'middlename' ];
        
          // Set request data valid sataus
          $request_data_valid = $request_data_valid && true;

        }
        
      }
      
      //------------------------------------------------------------------------
      // Email address
      //------------------------------------------------------------------------
      
      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'email' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR: First name parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'email' ] = $this->data[ 'account_register_email_not_exist_error' ];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Email parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data[ 'email' ] = trim( $this->request->Get_POST_Parameter_As_String( 'email' ) );

        $mail = new Mail();
        
        // Test email format
        if ( $mail->Is_Email_Valid( $customer_data[ 'email' ] ) === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Email is invalid
          //--------------------------------------------------------------------
          
          // Set error message text
          $this->error[ 'email' ] = $this->data[ 'account_register_' . $this->request->Post_Parameter_Is_Mail('email')['response'] ];
          
          // Clear request data valid sataus
          $request_data_valid = false;

        }
        else
        {
          
          //--------------------------------------------------------------------
          // Email valid
          //--------------------------------------------------------------------

          // Check for customer already registered
          if ( $this->customer->Is_Exists( $customer_data[ 'email' ] ) === true )
          {

            //------------------------------------------------------------------
            // ERROR: User already registered
            //------------------------------------------------------------------

            // Set error message text
            $this->error[ 'email' ] = $this->data[ 'account_register_email_exists_error' ];

            // Clear request data valid sataus
            $request_data_valid = false;

          }
          else
          {
          
            //------------------------------------------------------------------
            // Customer email not registered
            //------------------------------------------------------------------

//            $this->error[ 'email' ] = $customer_data[ 'email' ];

            // Set request data valid sataus
            $request_data_valid = $request_data_valid && true;

          }

        }

      }
      
      //------------------------------------------------------------------------
      // Phone
      //------------------------------------------------------------------------
      
      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'telephone' ) )
      {

        //----------------------------------------------------------------------
        // ERROR: Phone number parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'telephone' ] = $this->data[ 'account_register_telephone_error' ];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Phone number parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data[ 'telephone' ] = trim( $this->request->Get_POST_Parameter_As_String( 'telephone' ) );

        // Test phone number validity
        if ( utf8_strlen( $customer_data[ 'telephone' ] ) > 32 )
        {
          
          //--------------------------------------------------------------------
          // ERROR: Phone number invalid
          //--------------------------------------------------------------------
         
          // Set errer message text
          $this->error[ 'telephone' ] = $this->data[ 'account_register_telephone_error' ];

          // Clear request data valid sataus
          $request_data_valid = false;
 
        }
        else
        {
          
          //--------------------------------------------------------------------
          // Phone number valid
          //--------------------------------------------------------------------
        
//          $this->error[ 'telephone' ] = $customer_data[ 'telephone' ];
        
          // Set request data valid sataus
          $request_data_valid = $request_data_valid && true;

        }
        
      }

      //------------------------------------------------------------------------
      // Company name
      //------------------------------------------------------------------------
      
      if ( $customer_data[ 'legal_entity' ] === false )
      {

        //----------------------------------------------------------------------
        // Private customer
        //----------------------------------------------------------------------

        // Clear company name
        $customer_data[ 'company_name' ] = '';

        // Set request data valid sataus
        $request_data_valid = $request_data_valid && true;

      }
      else
      {
        
        //----------------------------------------------------------------------
        // Legal entity customer
        //----------------------------------------------------------------------

        // Test for parameter exists
        if( ! $this->request->Is_POST_Parameter_Exists( 'company_name' ) )
        {
  
          //----------------------------------------------------------------------
          // ERROR: Company name parameter not found
          //----------------------------------------------------------------------
          
          // Set error message text
          $this->error[ 'company_name' ] = $this->data[ 'account_register_company_name_error' ];
  
          // Clear request data valid sataus
          $request_data_valid = false;
  
        }
        else
        {
  
          //----------------------------------------------------------------------
          // Company name parameter found
          //----------------------------------------------------------------------
  
          // Store customer data
          $customer_data[ 'company_name' ] = trim( $this->request->Get_POST_Parameter_As_String( 'company_name' ) );
  
          // Test company name validity
          if ( utf8_strlen( $customer_data[ 'company_name' ] ) > 32 )
          {
            
            //--------------------------------------------------------------------
            // ERROR: Company name invalid
            //--------------------------------------------------------------------
           
            // Set errer message text
            $this->error[ 'company_name' ] = $this->data[ 'account_register_company_name_error' ];
  
            // Clear request data valid sataus
            $request_data_valid = false;
   
          }
          else
          {
            
            //--------------------------------------------------------------------
            // Company name valid
            //--------------------------------------------------------------------
          
//            $this->error[ 'company_name' ] = $customer_data[ 'company_name' ];
          
            // Set request data valid sataus
            $request_data_valid = $request_data_valid && true;
  
          }
          
        }
  
      }
      
      //------------------------------------------------------------------------
      // Company register ID
      //------------------------------------------------------------------------

      // Entity decoder
      if ( $customer_data[ 'legal_entity' ] === false )
      {

        //----------------------------------------------------------------------
        // Private customer
        //----------------------------------------------------------------------

        // Clear company register ID
        $customer_data[ 'company_register_id' ] = '';

        // Set request data valid sataus
        $request_data_valid = $request_data_valid && true;

      }
      else
      {
        
        //----------------------------------------------------------------------
        // Legal entity customer
        //----------------------------------------------------------------------

        // Test for parameter exists
        if( ! $this->request->Is_POST_Parameter_Exists( 'company_register_id' ) )
        {
  
          //----------------------------------------------------------------------
          // ERROR: Company name parameter not found
          //----------------------------------------------------------------------
          
          // Set error message text
          $this->error[ 'company_register_id' ] = $this->data[ 'account_register_company_register_id_error' ];
  
          // Clear request data valid sataus
          $request_data_valid = false;
  
        }
        else
        {
  
          //----------------------------------------------------------------------
          // Company register ID parameter found
          //----------------------------------------------------------------------
  
          // Store customer data
          $customer_data[ 'company_register_id' ] = trim( $this->request->Get_POST_Parameter_As_String( 'company_register_id' ) );
  
          // Test company register ID validity
          if ( utf8_strlen( $customer_data[ 'company_register_id' ] ) > 32 )
          {
            
            //--------------------------------------------------------------------
            // ERROR: Company register ID invalid
            //--------------------------------------------------------------------
           
            // Set errer message text
            $this->error[ 'company_register_id' ] = $this->data[ 'account_register_company_register_id_error' ];
  
            // Clear request data valid sataus
            $request_data_valid = false;
   
          }
          else
          {
            
            //--------------------------------------------------------------------
            // Company register ID valid
            //--------------------------------------------------------------------
          
//            $this->error[ 'company_register_id' ] = $customer_data[ 'company_register_id' ];
          
            // Set request data valid sataus
            $request_data_valid = $request_data_valid && true;
  
          }
          
        }
  
      }

      //------------------------------------------------------------------------
      // Company tax ID
      //------------------------------------------------------------------------

      // Entity decoder
      if ( $customer_data[ 'legal_entity' ] === false )
      {

        //----------------------------------------------------------------------
        // Private customer
        //----------------------------------------------------------------------

        // Clear company tax ID
        $customer_data[ 'company_tax_id' ] = '';

        // Set request data valid sataus
        $request_data_valid = $request_data_valid && true;

      }
      else
      {
        
        //----------------------------------------------------------------------
        // Legal entity customer
        //----------------------------------------------------------------------

        // Test for parameter exists
        if( ! $this->request->Is_POST_Parameter_Exists( 'company_tax_id' ) )
        {
  
          //----------------------------------------------------------------------
          // ERROR: Company tax ID parameter not found
          //----------------------------------------------------------------------
          
          // Set error message text
          $this->error[ 'company_tax_id' ] = $this->data[ 'account_register_company_tax_id_error' ];
  
          // Clear request data valid sataus
          $request_data_valid = false;
  
        }
        else
        {
  
          //----------------------------------------------------------------------
          // Company tax ID parameter found
          //----------------------------------------------------------------------
  
          // Store customer data
          $customer_data[ 'company_tax_id' ] = trim( $this->request->Get_POST_Parameter_As_String( 'company_tax_id' ) );
  
          // Test company tax ID validity
          if ( utf8_strlen( $customer_data[ 'company_tax_id' ] ) > 32 )
          {
            
            //--------------------------------------------------------------------
            // ERROR: Company tax ID invalid
            //--------------------------------------------------------------------
           
            // Set errer message text
            $this->error[ 'company_tax_id' ] = $this->data[ 'account_register_company_tax_id_error' ];
  
            // Clear request data valid sataus
            $request_data_valid = false;
   
          }
          else
          {
            
            //--------------------------------------------------------------------
            // Company tax ID valid
            //--------------------------------------------------------------------
          
//            $this->error[ 'company_tax_id' ] = $customer_data[ 'company_tax_id' ];
          
            // Set request data valid sataus
            $request_data_valid = $request_data_valid && true;
  
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
                    $this->error['tax_id'] = $this->data['account_register_vat_error'];
                }
            }

            if (($this->request->Get_POST_Parameter_As_String('tax_id') == '')
                || ( !is_numeric($this->request->Get_POST_Parameter_As_String('tax_id')))) 
            {
                $this->error['tax_id'] = $this->data['account_register_tax_id_error'];
            }
*/

      //------------------------------------------------------------------------
      // Company VAT ID
      //------------------------------------------------------------------------
/*
      // Entity decoder
      if ( $customer_data[ 'legal_entity' ] === false )
      {

        //----------------------------------------------------------------------
        // Private customer
        //----------------------------------------------------------------------

        // Clear company VAT ID
        $customer_data[ 'company_vat_id' ] = '';

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
          $this->error[ 'company_vat_id' ] = $this->data[ 'account_register_company_vat_id_error' ];
  
          // Clear request data valid sataus
          $request_data_valid = false;
  
        }
        else
        {
  
          //----------------------------------------------------------------------
          // Company VAT ID parameter found
          //----------------------------------------------------------------------
  
          // Store customer data
          $customer_data[ 'company_vat_id' ] = trim( $this->request->Get_POST_Parameter_As_String( 'company_vat_id' ) );
  
          // Test company VAT ID validity
          if ( utf8_strlen( $customer_data[ 'company_vat_id' ] ) > 32 )
          {
            
            //--------------------------------------------------------------------
            // ERROR: Company VAT ID invalid
            //--------------------------------------------------------------------
           
            // Set errer message text
            $this->error[ 'company_vat_id' ] = $this->data[ 'account_register_company_vat_id_error' ];
  
            // Clear request data valid sataus
            $request_data_valid = false;
   
          }
          else
          {
            
            //--------------------------------------------------------------------
            // Company VAT ID valid
            //--------------------------------------------------------------------
          
            $this->error[ 'company_vat_id' ] = $customer_data[ 'company_vat_id' ];
          
            // Set request data valid sataus
            $request_data_valid = true;
  
          }
          
        }
  
      }
*/
      //------------------------------------------------------------------------
      // Password
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'password' ) )
      {

        //----------------------------------------------------------------------
        // ERROR: Password parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'password' ] = $this->data[ 'account_register_password_error' ];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Password parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data[ 'password' ] = trim( $this->request->Get_POST_Parameter_As_String( 'password' ) );

        // Test password validity
        if (
          ( utf8_strlen( $customer_data[ 'password' ] ) < 8 ) ||
          ( utf8_strlen( $customer_data[ 'password' ] ) > 20 )
        )
        {
          
          //--------------------------------------------------------------------
          // ERROR: Password invalid
          //--------------------------------------------------------------------
         
          // Set errer message text
          $this->error[ 'password' ] = $this->data[ 'account_register_password_error' ];

          // Clear request data valid sataus
          $request_data_valid = false;
 
        }
        else
        {
          
          //--------------------------------------------------------------------
          // Password valid
          //--------------------------------------------------------------------
        
//          $this->error[ 'password' ] = $customer_data[ 'password' ];
        
          // Set request data valid sataus
          $request_data_valid = $request_data_valid && true;

        }
        
      }

      //------------------------------------------------------------------------
      // Confirm password
      //------------------------------------------------------------------------
      
      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'confirm' ) )
      {

        //----------------------------------------------------------------------
        // ERROR: Password confirm parameter not found
        //----------------------------------------------------------------------
        
        // Set error message text
        $this->error[ 'confirm' ] = $this->data[ 'account_register_confirm_error' ];

        // Clear request data valid sataus
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
        if ( $customer_data[ 'password' ] != $password_confirm )
        {

          //--------------------------------------------------------------------
          // ERROR: Password confirm invalid
          //--------------------------------------------------------------------

          // Set errer message text
          $this->error[ 'confirm' ] = $this->data[ 'account_register_confirm_error' ];

          // Clear request data valid sataus
          $request_data_valid = false;
 
        }
        else
        {

          //--------------------------------------------------------------------
          // Password valid
          //--------------------------------------------------------------------

//          $this->error[ 'confirm' ] = $password_confirm;

          // Set request data valid sataus
          $request_data_valid = $request_data_valid && true;

        }

      }

      //------------------------------------------------------------------------
      // Newsletter subscription
      //------------------------------------------------------------------------
      
      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'newsletter' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Newsletter subscription parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'newsletter' ] = $this->data[ 'newsletter' ];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Newsletter subscription parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data[ 'newsletter' ] = $this->request->Get_POST_Parameter_As_Boolean( 'newsletter' );
        
        $this->data[ 'newsletter' ] = $customer_data[ 'newsletter' ];

        // Set request data valid sataus
        $request_data_valid = $request_data_valid && true;

      }

      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'terms' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Terms of use parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'terms' ] = $this->data[ 'account_register_terms_error' ];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Terms of use parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data[ 'terms_of_use' ] = $this->request->Get_POST_Parameter_As_Boolean( 'terms' ); 
        
        // Test for terms of use accepted
        if ( $customer_data[ 'terms_of_use' ] === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Terms of use not accepted
          //--------------------------------------------------------------------

          // Set errer message text
          $this->error[ 'terms' ] = $this->data[ 'account_register_terms_error' ];

          // Clear request data valid sataus
          $request_data_valid = false;

        }
        else
        {
        
          //--------------------------------------------------------------------
          // Terms of use accepted
          //--------------------------------------------------------------------
          
//          $this->data[ 'terms' ] = $customer_data[ 'terms_of_use' ];
        
          // Set request data valid sataus
          $request_data_valid = $request_data_valid && true;

        }
        
      }

      //------------------------------------------------------------------------
      // Privacy
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( ! $this->request->Is_POST_Parameter_Exists( 'privacy' ) )
      {
        
        //----------------------------------------------------------------------
        // ERROR: Privacy parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $this->error[ 'privacy' ] = $this->data[ 'account_register_privacy_error' ];

        // Clear request data valid sataus
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Privacy parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data[ 'privacy' ] = $this->request->Get_POST_Parameter_As_Boolean( 'privacy' ); 

        // Test for privacy accepted
        if ( $customer_data[ 'privacy' ] === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Privacy not accepted
          //--------------------------------------------------------------------

          // Set errer message text
          $this->error[ 'privacy' ] = $this->data[ 'account_register_privacy_error' ];

          // Clear request data valid sataus
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Privacy accepted
          //--------------------------------------------------------------------

//          $this->data[ 'privacy' ] = $customer_data[ 'privacy' ];
        
          // Set request data valid sataus
          $request_data_valid = $request_data_valid && true;

        }
        
      }

      //------------------------------------------------------------------------
      
      // Is request data valid
      if ( $request_data_valid === false )
      {

        //------------------------------------------------------------------------
        // ERROR: Parameters not valid
        //------------------------------------------------------------------------

        $json[ 'error' ] = $this->error;

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
        $this->customer->Create( $guid, $customer_data );

        // Login using email and password
        $this->customer->login( $customer_data[ 'email' ], $customer_data[ 'password' ] );
        
        // Store customer GUID in session
        $this->session->data[ 'customer_guid' ] = $guid;
        
        //! @todo ANVILEX KM: Check for login successed and after that create cart.

        // Create customer cart
        $this->cart->Create();
        $json[ 'redirect_url' ] =  $this->url->link( 'account/login', '', 'SSL' );
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