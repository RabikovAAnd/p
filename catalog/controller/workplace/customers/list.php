<?php
class ControllerWorkplaceCustomersList extends Controller
{

  public $page_length = 30;
  public $current_page = 1;

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'customers', 'index', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'customers/customers' );

    // Get customers count
    $this->data[ 'customer_count' ] = $this->model_customers_customers->Search_Customers_Count();
    $this->data[ 'page_count' ] = intdiv( $this->data[ 'customer_count' ], $this->page_length );

    // Get customers
    $customers = $this->model_customers_customers->Get_List_Of_Customers(
      $this->page_length,
      1,
      '',
      true,
      false,
      false
    );

    // Iterate over all customers
    foreach ( $customers as $customer )
    {

      $this->data[ 'customers' ][] = array(
        'guid' => $customer[ 'guid' ],
        'id' => $customer[ 'id' ],
        'lastname' => $customer[ 'lastname' ],
        'name' => $customer[ 'name' ],
        'status' => $customer[ 'status' ],
        'href' => $this->url->link( 'workplace/customers/info', 'guid=' . $customer[ 'guid' ], 'SSL' ),
        'company_name' => $customer[ 'company_name' ],
        'registration_country' => $customer['registration_country']
      );

    }

    // Links
    $this->data[ 'customers_add_individual_link' ] = $this->url->link( 'workplace/customers/individual/create', '', 'SSL' );
    $this->data[ 'customers_add_legal_entity_link' ] = $this->url->link( 'workplace/customers/corporate/create', '', 'SSL' );

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

  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Search()
  {

    // Initialise json data
    $json = array();
/*
    // Test for customer not logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $this->response->Redirect( $this->url->link( 'account/login', '', 'SSL' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------
*/

      // Initialise json
      $json['return_code'] = false;

      // Test for input parameter valis
      if (
        ( $this->request->Is_POST_Parameter_Exists( 'search' ) === true ) &&
        ( $this->request->Is_POST_Parameter_Exists( 'firstname' ) === true ) &&
        ( $this->request->Is_POST_Parameter_Exists( 'lastname' ) === true ) &&
        ( $this->request->Is_POST_Parameter_Exists( 'manufacturer' ) === true ) &&
        ( $this->request->Is_POST_Parameter_Exists( 'page' ) === true )
      )
      {

        //-----------------------------------------------------------------------
        // Parameters valid
        //-----------------------------------------------------------------------

        // Load data models
        $this->load->model( 'customers/customers' );

        // Get items
        $this->data[ 'customer_count' ] = $this->model_customers_customers->Search_Customers_Count(
          $this->request->Get_POST_Parameter_As_String( 'search' ),
          $this->request->Get_POST_Parameter_As_Boolean( 'firstname' ),
          $this->request->Get_POST_Parameter_As_Boolean( 'lastname' ),
          $this->request->Get_POST_Parameter_As_Boolean( 'manufacturer' )
        );

        $json[ 'page_count' ] = intdiv( $this->data[ 'customer_count' ], $this->page_length );
        $json[ 'customer_count' ] = $this->data[ 'customer_count' ];

        if( $this->data[ 'customer_count' ] !=0 )
        {

          $customers =  $this->model_customers_customers->Get_List_Of_Customers(
            $this->page_length,
            $this->request->Get_POST_Parameter_As_Integer( 'page' ),
            $this->request->Get_POST_Parameter_As_String( 'search' ),
            $this->request->Get_POST_Parameter_As_Boolean( 'firstname' ),
            $this->request->Get_POST_Parameter_As_Boolean( 'lastname' ),
            $this->request->Get_POST_Parameter_As_Boolean( 'manufacturer' )
          );

          if( $customers != [] )
          {

            foreach ( $customers as $customer )
            {

              $json['customers'][] = array(
                'guid' => $customer[ 'guid' ],
                'id' => $customer[ 'id' ],
                'lastname' => $customer[ 'lastname' ],
                'name' => $customer[ 'name' ],
                'status' => $customer[ 'status' ],
                'href' => $this->url->link( 'workplace/customers/info', 'guid=' . $customer[ 'guid' ], 'SSL' ),
                'company_name' => $customer[ 'company_name' ],
                'registration_country' =>  $customer['registration_country']
              );

            }

            // Set success code
            $json[ 'return_code' ] = true;

          }

        }

      }

//    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------
  //
  //----------------------------------------------------------------------------

  public function Set_Page()
  {

    // Initialise json data
    $json = array();
/*
    // Test for customer not logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Redirect to login page
      $this->response->Redirect( $this->url->link( 'account/login', '', 'SSL' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------
*/
      $json[ 'return_code' ] = false;

      if ( 
        $this->request->Is_GET_Parameter_Exists( 'search' ) && 
        $this->request->Is_GET_Parameter_Exists( 'page' ) 
      )
      {

        // Load data models
        $this->load->model( 'customers/customers' );

        // Get items
        $search_customers_count = $this->model_customers_customers->Search_Customers_Count($this->request->Get_GET_Parameter_As_String('search'));

        if( $search_customers_count > 0 )
        {

          $json[ 'page_count' ] = intdiv( $search_customers_count, $this->page_length );

          $customers = $this->model_customers_customers->Get_List_Of_Customers($this->page_length, $this->request->Get_GET_Parameter_As_String('page'), $this->request->Get_GET_Parameter_As_String('search'));

          foreach ( $customers as $customer )
          {

            $json['customers'][] = array(
              'guid' => $customer[ 'guid' ],
              'lastname'    => $customer[ 'lastname' ],
              'name'    => $customer[ 'name' ],

              'company_name' => $customer['company_name']
            );

          }

          $json[ 'return_code' ] = true;

        }

      }

//    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>