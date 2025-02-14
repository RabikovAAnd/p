<?php
class ControllerWorkplaceCustomersAttributesAdd extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------
  // Caller: HTTP
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for category GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

    //--------------------------------------------------------------------------
    // ERROR: Category GUID parameter not found
    //--------------------------------------------------------------------------

    //! @todo ANVILEX KM: Redirect to category error page

  }
  else
  {
    
    //--------------------------------------------------------------------------
    // Category GUID parameter found, continue processing
    //--------------------------------------------------------------------------

    // Load messages
    $this->messages->Load($this->data, 'workplace', 'customers_attributes_add', 'index', $this->language->Get_Language_Code());

    // Load model
    $this->load->model('customers/customers');

    // Get customer guid
    $customer_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );


    // Get attributes 
    $this->data[ 'attributes' ] = $this->model_customers_customers->Get_Attributes( $this->language->Get_Language_Code());

    // Set links
    $this->data[ 'add_button_href' ] = $this->url->link( 'workplace/customers/attributes/add/Add', 'guid=' . $customer_guid, 'SSL' );
    $this->data[ 'cancel_button_href' ] = $this->url->link( 'workplace/customers/info', 'guid=' . $customer_guid, 'SSL' );

    //------------------------------------------------------------------------
    // Render page
    //------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
    $this->response->setRobots( 'index, follow' );

    // Set page configuration
    $this->children = array(
      'common/footer',
      'workplace/menu',
      'common/header'
    );
  
  }

}

  //----------------------------------------------------------------------------
  // Add attribute to customer
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Add()
  {

    //------------------------------------------------------------------------
    // Customer logged in
    //------------------------------------------------------------------------

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'customers_attributes_add', 'Add', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'customers/customers' );

    // Init json data
    $json = array();

    $json[ 'return_code' ] = false;

    // Init unit data
    $data = array();


    // Clear request data valid status
    $request_data_valid = true;


    //------------------------------------------------------------------------
    // Check parameter: Customer GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Customer GUID parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'guid' ] = $this->data[ 'workplace_customers_attributes_add_guid_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      // Get customer information
      $customer = $this->customer->Get_Contact_Information( $this->request->Get_GET_Parameter_As_GUID( 'guid' ));

      // Test for information invalid
      if( $customer[ 'return_code' ] === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Customer GUID parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'guid' ] = $this->data[ 'workplace_customers_attributes_add_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Customer are valid
        //----------------------------------------------------------------------

        $data['customer_guid'] = $customer[ 'guid' ];

        // Set request data valid status
        $request_data_valid = $request_data_valid && true;

      }

    }

    //------------------------------------------------------------------------
    // Check parameter: Attribute GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if( $this->request->Is_POST_Parameter_GUID( 'attribute_guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Attribute parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'attribute_guid' ] = $this->data[ 'workplace_customers_attributes_add_attribute_guid_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Attribute parameter found
      //----------------------------------------------------------------------

      // Get attribute information
      $attribute = $this->model_customers_customers->Get_Attribute( $this->request->Get_POST_Parameter_As_GUID( 'attribute_guid' ), $this->language->Get_Language_Code() );

      // Test for information invalid
      if( $attribute[ 'return_code' ] === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Attribute not valid
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'attribute_guid' ] = $this->data[ 'workplace_customers_attributes_add_attribute_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Attribute valid
        //--------------------------------------------------------------------

        $data[ 'attribute' ] = $attribute;

        // Set request data valid status
        $request_data_valid = $request_data_valid && true;

      }

    }

    //------------------------------------------------------------------------
    // Check for Customer's attribute already exist
    //------------------------------------------------------------------------

    if ( $request_data_valid === true )
    {

      if ( $data[ 'attribute' ]['multiple'] == '0')
      {

        if ( $this->model_customers_customers->Get_Customer_Attribute( $data['customer_guid'], $data[ 'attribute' ]['guid'])['valid'] === true)
        {

          //----------------------------------------------------------------------
          // ERROR: Customer's attribute already exists
          //----------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'attribute_exists' ] = $this->data[ 'workplace_customers_attributes_add_attribute_exists_error' ];
    
          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //----------------------------------------------------------------------
          // Customer's attribute not exists
          //----------------------------------------------------------------------

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }

      }

    }
      
    //------------------------------------------------------------------------
    // Value
    //------------------------------------------------------------------------

    // Test for parameter exists
    if( $this->request->Is_POST_Parameter_Exists( 'value' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Value parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'value' ] = $this->data[ 'workplace_customers_attributes_add_value_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Value parameter found
      //----------------------------------------------------------------------

      // Store Value
      $data[ 'value' ] = trim( $this->request->Get_POST_Parameter_As_String( 'value' ) );

      // Test Value validity
      if (
        ( utf8_strlen( $data[ 'value' ] ) < 1 ) ||
        ( utf8_strlen( $data[ 'value' ] ) > $this->model_customers_customers->Get_Customer_Attribute_Value_Maximum_String_Size() )
      )
      {

        //--------------------------------------------------------------------
        // ERROR: Value invalid
        //--------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'value' ] = $this->data[ 'workplace_customers_attributes_add_value_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Value valid
        //--------------------------------------------------------------------

      }

    }

    //------------------------------------------------------------------------
    // Try to add attribute 
    //------------------------------------------------------------------------
 
    // Is request data valid
    if ( $request_data_valid === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Parameters not valid
      //----------------------------------------------------------------------

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Parameters present and valid, add item
      //----------------------------------------------------------------------

      // Add new project
      $return_data = $this->model_customers_customers->Add_Attribute_To_Customer($data['customer_guid'],  $data[ 'attribute' ]['guid'],$data['value']);


      // Test for error
      if ( $return_data === false )
      {

        //--------------------------------------------------------------------
        // ERROR: Add attribute failed
        //--------------------------------------------------------------------

        // Set error message
        $json[ 'error' ][ 'error' ] = 'Add attribute failed.';

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Add Customer's attribute successfully
        //--------------------------------------------------------------------

        // Set redirect URL
        $json[ 'redirect_url' ] = $this->url->link( 'workplace/customers/info', 'guid=' . $data[ 'customer_guid' ] , 'SSL' );

        // Set success code
        $json[ 'return_code' ] = true;

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