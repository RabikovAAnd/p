<?php
class ControllerWorkplaceCustomersCorporateEdit extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for item GUID parameter exists
    if ($this->request->Is_GET_Parameter_GUID('guid') === false)
    {

      //----------------------------------------------------------------------
      // ERROR: Item GUID parameter not found
      //----------------------------------------------------------------------

      //! @todo ANVILEX KM: Redirect to item not found page

    } 
    else 
    {

      // Load messages
      $this->messages->Load($this->data, 'workplace', 'customers_edit_corporate', 'index', $this->language->Get_Language_Code());

      // Get list of countries
      $this->data['countries'] = $this->location->Get_Countries($this->language->Get_Language_Code());
      $this->data['customer_guid'] = $this->request->Get_GET_Parameter_As_GUID( 'guid' );


      // Try to get customer information
      $customer = $this->customer->Get_Contact_Information( $this->request->Get_GET_Parameter_As_GUID( 'guid' ) );

      if ( $customer['valid'] === false )
      {

        // Redirect to login page
        $this->response->Redirect( $this->url->link( 'workplace/customers/list', '', 'SSL' ) );

      }
      else
      {

        // Assign customer data
        $this->data[ 'customer' ] = $customer;
        $this->data[ 'customer' ][ 'country' ] = $this->location->Get_Country_By_ISO2( $customer[ 'registration_country' ], $this->language->Get_Language_Code() );

        // Set links
        $this->data['workplace_edit_corporate_edit_button_href'] = $this->url->link('workplace/customers/corporate/edit/Edit', '', 'SSL');
        $this->data['cancel_button_href'] = $this->url->link('workplace/customers/info', 'guid=' . $this->data['customer_guid'], 'SSL');

        //------------------------------------------------------------------------
        // Render page
        //------------------------------------------------------------------------

        // Set document properties
        $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
        $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
        $this->response->setKeywords( '' );
        $this->response->setRobots( 'index, follow' );

        // Set page configuration
        $this->children = array(
          'common/footer',
          'workplace/menu',
          'common/header'
        );

      }

    }

  }

  //----------------------------------------------------------------------------
  // Create new customer
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Edit()
  {

    // Init json data
    $json = array();

    // Test for customer not logged in
    if ($this->customer->Is_Logged() === false) 
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Set redirect link
      $json['redirect_url'] = $this->url->link( 'account/login', '', 'SSL' );

      // Set error code
      $json['return_code'] = false;

    } 
    else 
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load($this->data, 'workplace', 'customers_edit_corporate', 'Edit', $this->language->Get_Language_Code());

      // Init customer data
      $customer_data = array();

      // Clear request data valid status
      $request_data_valid = true;

      //------------------------------------------------------------------------
      // Company name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ($this->request->Is_POST_Parameter_Exists('company_name') === false) 
      {

        //----------------------------------------------------------------------
        // ERROR: Company name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['company_name'] = $this->data['workplace_customers_edit_corporate_company_name_error'];

        // Clear request data valid status
        $request_data_valid = false;

      } 
      else 
      {

        //----------------------------------------------------------------------
        // Company name parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data['company_name'] = trim($this->request->Get_POST_Parameter_As_String('company_name'));

        // Test company name validity
        if (
          ( $customer_data[ 'company_name' ] == "" ) ||
          ( utf8_strlen( $customer_data[ 'company_name' ] ) > $this->customer->Get_Customer_Company_Name_Maximum_String_Size() )
        )
        {

          //--------------------------------------------------------------------
          // ERROR: Company name invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'company_name' ] = $this->data[ 'workplace_customers_edit_corporate_company_name_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        } 
        else 
        {

          //--------------------------------------------------------------------
          // Company name valid
          //--------------------------------------------------------------------

        }

      }

      //------------------------------------------------------------------------
      // Short company name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ($this->request->Is_POST_Parameter_Exists('short_company_name') === false) 
      {

        //----------------------------------------------------------------------
        // ERROR: Short company name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['company_short_name'] = $this->data['workplace_customers_edit_corporate_short_company_name_error'];

        // Clear request data valid status
        $request_data_valid = false;

      } 
      else 
      {

        //----------------------------------------------------------------------
        // Short company name parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data['company_short_name'] = trim($this->request->Get_POST_Parameter_As_String('short_company_name'));

        // Test Short company name validity
        if ( utf8_strlen( $customer_data[ 'company_short_name' ] ) > $this->customer->Get_Customer_Company_Short_Name_Maximum_String_Size() )
        {

          //--------------------------------------------------------------------
          // ERROR: Short company name invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'short_company_name' ] = $this->data[ 'workplace_customers_edit_corporate_short_company_name_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        } 
        else 
        {

          //--------------------------------------------------------------------
          // Short company name valid
          //--------------------------------------------------------------------

        }

      }

      //------------------------------------------------------------------------
      // Customer GUID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ( $this->request->Is_POST_Parameter_GUID( 'customer_guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Customer GUID not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'customer_guid' ] = $this->data[ 'workplace_customers_edit_corporate_guid_not_exist_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Customer GUID parameter found
        //----------------------------------------------------------------------

        $customer_data[ 'customer_guid' ] = trim( $this->request->Get_POST_Parameter_As_GUID( 'customer_guid' ) );

      }

      //------------------------------------------------------------------------
      // Registration country
      //------------------------------------------------------------------------

      // Test for parameter exists
      //! @bug ANVILEX KM: ??? Rework
      if ( $this->request->Get_POST_Parameter_As_String( 'registration_country' ) === false ) 
      {

        //----------------------------------------------------------------------
        // ERROR: Registration country parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'registration_country' ] = $this->data[ 'workplace_customers_edit_corporate_registration_country_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Registration country parameter found
        //----------------------------------------------------------------------

        if ( $this->location->Get_Country_By_ISO2($this->request->Get_POST_Parameter_As_String( 'registration_country'), $this->language->Get_Language_Code() )[ 'valid' ] === false )
        {

          //----------------------------------------------------------------------
          // ERROR: ISO2 Code parameter not found
          //----------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'registration_country' ] = $this->data[ 'workplace_customers_edit_corporate_registration_country_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }

        // Store customer data
        $customer_data['registration_country'] = $this->request->Get_POST_Parameter_As_String('registration_country');

      }

      //------------------------------------------------------------------------
      // First name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'firstname', 0, $this->customer->Get_Customer_Firstname_Maximum_String_Size() ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: First name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'firstname' ] = $this->data[ 'workplace_customers_edit_corporate_firstname_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // First name parameter found and valid
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data[ 'firstname' ] = trim( $this->request->Get_POST_Parameter_As_String( 'firstname' ) );

      }

      //------------------------------------------------------------------------
      // Last name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'lastname', 0, $this->customer->Get_Customer_Lastname_Maximum_String_Size() ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Last name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'lastname' ] = $this->data[ 'workplace_customers_edit_corporate_lastname_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      } 
      else 
      {

        //----------------------------------------------------------------------
        // Last name parameter found and valid
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data[ 'lastname' ] = trim( $this->request->Get_POST_Parameter_As_String( 'lastname' ) );

      }

      //------------------------------------------------------------------------
      // Middle name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'middlename', 0, $this->customer->Get_Customer_Middlename_Maximum_String_Size() ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Middle name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['middlename'] = $this->data['workplace_customers_edit_corporate_middlename_error'];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Middle name parameter found and valid
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data[ 'middlename' ] = trim( $this->request->Get_POST_Parameter_As_String( 'middlename' ) );

      }

      //------------------------------------------------------------------------
      // Consumer role
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ( $this->request->Is_POST_Parameter_Boolean( 'consumer_role' ) === false ) 
      {

        //----------------------------------------------------------------------
        // ERROR: Consumer role parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['consumer_role'] = $this->data[ 'workplace_customers_edit_corporate_consumer_role_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      } 
      else 
      {

        //----------------------------------------------------------------------
        // Consumer role parameter found
        //----------------------------------------------------------------------

        // Store customer role
        $customer_data[ 'consumer_role' ] = $this->request->Get_POST_Parameter_As_Boolean( 'consumer_role' );

      }

      //------------------------------------------------------------------------
      // Manufacturer role
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ($this->request->Is_POST_Parameter_Boolean('manufacturer_role') === false) 
      {

        //----------------------------------------------------------------------
        // ERROR: Manufacturer role parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['manufacturer_role'] = $this->data['workplace_customers_edit_corporate_manufacturer_role_error'];

        // Clear request data valid status
        $request_data_valid = false;

      } 
      else 
      {

        //----------------------------------------------------------------------
        // Manufacturer role parameter found
        //----------------------------------------------------------------------

        // Store manufacturer role
        $customer_data['manufacturer_role'] = $this->request->Get_POST_Parameter_As_Boolean('manufacturer_role');

      }

      //------------------------------------------------------------------------
      // Supplier role
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ($this->request->Is_POST_Parameter_Boolean('supplier_role') === false) 
      {

        //----------------------------------------------------------------------
        // ERROR: Supplier role parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['supplier_role'] = $this->data['workplace_customers_edit_corporate_supplier_role_error'];

        // Clear request data valid status
        $request_data_valid = false;

      } 
      else 
      {

        //----------------------------------------------------------------------
        // Supplier role parameter found
        //----------------------------------------------------------------------

        // Store manufacturer role
        $customer_data['supplier_role'] = $this->request->Get_POST_Parameter_As_Boolean('supplier_role');

      }

      //------------------------------------------------------------------------
      // Process data
      //------------------------------------------------------------------------

      // Is request data valid
      if ( $request_data_valid === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Parameters not valid
        //----------------------------------------------------------------------

        // Set error code
        $json['return_code'] = false;

      } 
      else 
      {

        //----------------------------------------------------------------------
        // Parameters present and valid
        //----------------------------------------------------------------------

        $customer_data[ 'newsletter' ] = false;
        $customer_data[ 'legal_entity' ] = true;

        // Create new customer
        $this->customer->Edit( $customer_data[ 'customer_guid' ], $customer_data);

        // Set redirect URL
        $json['redirect_url'] = $this->url->link('workplace/customers/info', 'guid=' . $customer_data[ 'customer_guid' ], 'SSL');

        // Set success code
        $json['return_code'] = true;

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