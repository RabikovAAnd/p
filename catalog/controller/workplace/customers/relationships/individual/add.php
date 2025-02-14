<?php
class ControllerWorkplaceCustomersRelationshipsIndividualAdd extends Controller
{
  public $page_length = 30;

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for customer GUID parameter exists
    if ($this->request->Is_GET_Parameter_GUID('guid') === false) 
    {

      //----------------------------------------------------------------------
      // ERROR: customer GUID parameter not found
      //----------------------------------------------------------------------

      //! @todo ANVILEX KM: Redirect to project not found page
      $this->response->Redirect($this->url->link( 'workplace/customers/list', '', 'SSL' ) );

    } 
    else 
    {

      // Get customer GUID parameter
      $this->data['customer_guid'] = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'customers_relationships_individual_add', 'index', $this->language->Get_Language_Code() );

      // Load data model
      $this->load->model('customers/customers');


    // Get customers
    $customers = $this->model_customers_customers->Get_List_Of_Customers(
      $this->page_length,
      1,
      '',
      true,
      true,
      false,
      0
    );

    // Iterate over all customers
    foreach ( $customers as $customer )
    {

      $this->data[ 'customers' ][] = array(
        'guid' => $customer[ 'guid' ],
        'id' => $customer[ 'id' ],
        'lastname' => $customer[ 'lastname' ],
        'firstname' => $customer[ 'name' ],
        'middlename' => $customer[ 'middlename' ],
        'status' => $customer[ 'status' ],
        'company_name' => $customer[ 'company_name' ],
        'registration_country' => $customer['registration_country']
      );

    }

      // Compose links
      $this->data['add_customer_button_href'] = $this->url->link('workplace/customers/relationships/individual/add/Add', 'guid=' .  $this->data['customer_guid'], 'SSL');
      $this->data['cancel_button_href'] = $this->url->link('workplace/customers/info', 'guid=' .  $this->data['customer_guid']  , 'SSL');

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

  //----------------------------------------------------------------------------
  // Search query
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------


  public function Search()
  {

    // Initialise json data
    $json = array();

   
      // Test for input parameter valis
      if (
        ( $this->request->Is_POST_Parameter_Exists( 'search' ) === true )
      )
      {

        //-----------------------------------------------------------------------
        // Parameters valid
        //-----------------------------------------------------------------------

        // Load data models
        $this->load->model( 'customers/customers' );

       

        $customers =  $this->model_customers_customers->Get_List_Of_Customers(
          $this->page_length,
          1,
          $this->request->Get_POST_Parameter_As_String( 'search' ),
          true,
          true,
          false,
          0
        );

        if( $customers != [] )
        {

          foreach ( $customers as $customer )
          {

            $json['customers'][] = array(
              'guid' => $customer[ 'guid' ],
              'id' => $customer[ 'id' ],
              'lastname' => $customer[ 'lastname' ],
              'firstname' => $customer[ 'name' ],
              'middlename' => $customer[ 'middlename' ],
              'status' => $customer[ 'status' ],
              'company_name' => $customer[ 'company_name' ],
              'registration_country' => $customer['registration_country']
            );

          }

          // Set success code
          $json[ 'return_code' ] = true;

        }

        
      }

    // Render page
    $this->response->Set_Json_Output( $json );

  }


  //----------------------------------------------------------------------------
  // Add customer to customer
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Add()
  {

    

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'customers_relationships_individual_add', 'Add', $this->language->Get_Language_Code() );

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
      // Check parameter: Parent customer GUID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Parent customer GUID parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'guid' ] = $this->data[ 'workplace_customers_relationships_individual_add_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        // Get customer information
        $parent_customer = $this->customer->Get_Contact_Information( $this->request->Get_GET_Parameter_As_GUID( 'guid' ));

        // Test for information invalid
        if( $parent_customer[ 'return_code' ] === false )
        {

          //----------------------------------------------------------------------
          // ERROR: Parent customer GUID parameter not found
          //----------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'guid' ] = $this->data[ 'workplace_customers_relationships_individual_add_guid_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          // Test for information invalid
          if( $parent_customer[ 'legal_entity' ] != '1' )
          {

            //----------------------------------------------------------------------
            // ERROR: Parent customer not legal entity
            //----------------------------------------------------------------------

            // Set error message text
            $json[ 'error' ][ 'guid' ] = $this->data[ 'workplace_customers_relationships_individual_add_guid_error' ];

            // Clear request data valid status
            $request_data_valid = false;

          }
          else
          {

            //----------------------------------------------------------------------
            // Parent customer are legal entity
            //----------------------------------------------------------------------

            $data['parent_guid'] = $parent_customer[ 'guid' ];

            // Set request data valid status
            $request_data_valid = $request_data_valid && true;

          }


        }

      }

      //------------------------------------------------------------------------
      // Check parameter: Customer GUID
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_GUID( 'customer_guid' ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Customer parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'customer_guid' ] = $this->data[ 'workplace_customers_relationships_individual_add_customer_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Customer parameter found
        //----------------------------------------------------------------------

        // Get project information
        $customer = $this->customer->Get_Contact_Information( $this->request->Get_POST_Parameter_As_GUID( 'customer_guid' ));

        // Test for information invalid
        if( $customer[ 'return_code' ] === false )
        {

          //----------------------------------------------------------------------
          // ERROR: Customer not valid
          //----------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'customer_guid' ] = $this->data[ 'workplace_customers_relationships_individual_add_customer_guid_error' ];

          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          // Test for information invalid
          if( $customer[ 'legal_entity' ] != '0' )
          {

            //----------------------------------------------------------------------
            // ERROR: Customer not legal entity
            //----------------------------------------------------------------------

            // Set error message text
            $json[ 'error' ][ 'customer_guid' ] = $this->data[ 'workplace_customers_relationships_individual_add_customer_guid_error' ];

            // Clear request data valid status
            $request_data_valid = false;

          }
          else
          {

            //--------------------------------------------------------------------
            // Customer valid
            //--------------------------------------------------------------------

            $data[ 'customer_guid' ] = $customer[ 'guid' ];

            // Set request data valid status
            $request_data_valid = $request_data_valid && true;

          }

        }

      }

      //------------------------------------------------------------------------
      // Check for Parent Customer and Customer are the same
      //------------------------------------------------------------------------

      if ( $request_data_valid === true )
      {

        if ($data['parent_guid'] == $data['customer_guid'])
        {

          //----------------------------------------------------------------------
          // ERROR: Parent Customer and Customer are the same
          //----------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'same_guid' ] = $this->data[ 'workplace_customers_relationships_individual_add_same_guid_error' ];
  
          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //----------------------------------------------------------------------
          // Parent Customer and Customer are NOT the same
          //----------------------------------------------------------------------

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }
      }


      //------------------------------------------------------------------------
      // Check for Customer's Customer already exist
      //------------------------------------------------------------------------

      if ( $request_data_valid === true )
      {

        if ($this->model_customers_customers->Is_Exist_Customers_Customer($data['parent_guid'], $data['customer_guid']))
        {

          //----------------------------------------------------------------------
          // ERROR: Customer's customer already exists
          //----------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'customer_exists' ] = $this->data[ 'workplace_customers_relationships_individual_add_customer_exists_error' ];
  
          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //----------------------------------------------------------------------
          // Customer's customer not exists
          //----------------------------------------------------------------------

          // Set request data valid status
          $request_data_valid = $request_data_valid && true;

        }
      }


      //------------------------------------------------------------------------
      // Try to add Customer 
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
        $return_data = $this->model_customers_customers->Add_Customer_To_Customer($data['parent_guid'], $data['customer_guid']);

        // Test for error
        if ( $return_data === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Create Customer failed
          //--------------------------------------------------------------------

          // Set error message
          $json[ 'error' ][ 'error' ] = 'Create Customer failed.';

          // Set error code
          $json[ 'return_code' ] = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Create Customer successfully
          //--------------------------------------------------------------------

          // Set redirect URL
          $json[ 'redirect_url' ] = $this->url->link( 'workplace/customers/info', 'guid=' . $data[ 'parent_guid' ] , 'SSL' );

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