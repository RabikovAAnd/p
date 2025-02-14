<?php
class ControllerWorkplaceCustomersIndividualEdit extends Controller
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
      $this->messages->Load( $this->data, 'workplace', 'customers_individual_edit', 'index', $this->language->Get_Language_Code() );

      // Set links
      $this->data[ 'workplace_individual_edit_button_href' ] = $this->url->link( 'workplace/customers/individual/edit/edit', '', 'SSL' );

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

        $this->data['cancel_button_href'] = $this->url->link('workplace/customers/info', 'guid=' .  $this->data['customer_guid'], 'SSL');

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
  // Edit customer
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
      $this->messages->Load($this->data, 'workplace', 'customers_individual_edit', 'Edit', $this->language->Get_Language_Code());

      // Init customer data
      $customer_data = array();

      // Clear request data valid sataus
      $request_data_valid = true;

      

      //------------------------------------------------------------------------
      // Customer GUID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_GUID( 'customer_guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Customer GUID not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'customer_guid' ] = $this->data[ 'workplace_customers_individual_edit_guid_not_exist_error' ];

        // Clear request data valid sataus
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
      if ($this->request->Get_POST_Parameter_As_String('registration_country') === false) 
      {

        //----------------------------------------------------------------------
        // ERROR: Registration country parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['registration_country'] = $this->data['workplace_customers_individual_edit_registration_country_error'];

        // Clear request data valid sataus
        $request_data_valid = false;

      } 
      else 
      {

        //----------------------------------------------------------------------
        // Registration country parameter found
        //----------------------------------------------------------------------
        
        if ($this->location->Get_Country_By_ISO2($this->request->Get_POST_Parameter_As_String('registration_country'), $this->language->Get_Language_Code())['valid'] === false) {

          //----------------------------------------------------------------------
          // ERROR: ISO2 Code parameter not found
          //----------------------------------------------------------------------

          // Set error message text
          $json['error']['registration_country'] = $this->data['workplace_customers_individual_edit_registration_country_error'];

          // Clear request data valid sataus
          $request_data_valid = false;
        }
        
        // Store customer data
        $customer_data['registration_country'] = $this->request->Get_POST_Parameter_As_String('registration_country');
      
      }

      //------------------------------------------------------------------------
      // First name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ($this->request->Is_POST_Parameter_Exists('firstname') === false) 
      {

        //----------------------------------------------------------------------
        // ERROR: First name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['firstname'] = $this->data['workplace_customers_individual_edit_firstname_error'];

        // Clear request data valid sataus
        $request_data_valid = false;

      } 
      else
      {

        //----------------------------------------------------------------------
        // First name parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data['firstname'] = trim($this->request->Get_POST_Parameter_As_String('firstname'));

        // Test forst name validity
        if (( utf8_strlen($customer_data['firstname']) > $this->customer->Get_Customer_Firstname_Maximum_String_Size() ) ||
        (utf8_strlen($customer_data['firstname']) < 1))
        {

          //--------------------------------------------------------------------
          // ERROR: First name invalid
          //--------------------------------------------------------------------

          // Set errer message text
          $json['error']['firstname'] = $this->data['workplace_customers_individual_edit_firstname_error'];

          // Clear request data valid sataus
          $request_data_valid = false;

        } 
        else
        {

          //--------------------------------------------------------------------
          // First name valid
          //--------------------------------------------------------------------

        }

      }

      //------------------------------------------------------------------------
      // Last name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ($this->request->Is_POST_Parameter_Exists('lastname') === false) 
      {

        //----------------------------------------------------------------------
        // ERROR: Last name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['lastname'] = $this->data['workplace_customers_individual_edit_lastname_error'];

        // Clear request data valid sataus
        $request_data_valid = false;

      } 
      else
      {

        //----------------------------------------------------------------------
        // Last name parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data['lastname'] = trim($this->request->Get_POST_Parameter_As_String('lastname'));

        // Test last name validity
        if (( utf8_strlen($customer_data['lastname']) > $this->customer->Get_Customer_Lastname_Maximum_String_Size() ) ||
        (utf8_strlen($customer_data['lastname']) < 1) )
        {

          //--------------------------------------------------------------------
          // ERROR: Last name invalid
          //--------------------------------------------------------------------

          // Set errer message text
          $json['error']['lastname'] = $this->data['workplace_customers_individual_edit_lastname_error'];

          // Clear request data valid sataus
          $request_data_valid = false;

        } 
        else
        {

          //--------------------------------------------------------------------
          // Last name valid
          //--------------------------------------------------------------------

        }

      }

      //------------------------------------------------------------------------
      // Middle name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if ($this->request->Is_POST_Parameter_Exists('middlename') === false) 
      {

        //----------------------------------------------------------------------
        // ERROR: Middle name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json['error']['middlename'] = $this->data['workplace_customers_individual_edit_middlename_error'];

        // Clear request data valid sataus
        $request_data_valid = false;

      } 
      else
      {

        //----------------------------------------------------------------------
        // Middle name parameter found
        //----------------------------------------------------------------------

        // Store customer data
        $customer_data['middlename'] = trim($this->request->Get_POST_Parameter_As_String('middlename'));

        // Test middle name validity
        if (utf8_strlen($customer_data['middlename']) > $this->customer->Get_Customer_Middlename_Maximum_String_Size()) 
        {

          //--------------------------------------------------------------------
          // ERROR: Middle name invalid
          //--------------------------------------------------------------------

          // Set errer message text
          $json['error']['middlename'] = $this->data['workplace_customers_individual_edit_middlename_error'];

          // Clear request data valid sataus
          $request_data_valid = false;

        } 
        else 
        {

          //--------------------------------------------------------------------
          // Middle name valid
          //--------------------------------------------------------------------

        }

      }

      //------------------------------------------------------------------------
      // Process data
      //------------------------------------------------------------------------

      // Is request data valid
      if ($request_data_valid === false) 
      {

        //------------------------------------------------------------------------
        // ERROR: Parameters not valid
        //------------------------------------------------------------------------

        // Set error code
        $json['return_code'] = false;

      } 
      else 
      {

        //--------------------------------------------------------------------
        // Parameters present and valid
        //--------------------------------------------------------------------

        $customer_data['newsletter'] = false;
        $customer_data['legal_entity'] = false;

        // Create new customer
        $this->customer->Edit( $customer_data[ 'customer_guid' ], $customer_data);

        // Set redirect URL
        $json['redirect_url'] = $this->url->link('workplace/customers/info', 'guid=' .  $customer_data[ 'customer_guid' ], 'SSL');

        // Set success code
        $json['return_code'] = true;

      }

    }

    // Encode and send json data
    $this->response->Set_Json_Output($json);

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>