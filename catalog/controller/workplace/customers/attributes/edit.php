<?php
class ControllerWorkplaceCustomersAttributesEdit extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for index GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'index_guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: index GUID parameter not found
      //----------------------------------------------------------------------

      //! @todo ANVILEX KM: Redirect to item not found page

    }
    else
    {

      //----------------------------------------------------------------------
      // index GUID parameter found, continue processing
      //----------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'customers_attributes_edit', 'index', $this->language->Get_Language_Code() );

      // Load data model
      $this->load->model( 'customers/customers' );

      // Get index GUID parameter
      $index_guid = $this->request->Get_GET_Parameter_As_GUID( 'index_guid' );
      $this->data[ 'attribute' ]=$this->model_customers_customers->Get_Customer_Attribute( $index_guid, $this->language->Get_Language_Code() );
     
      if ( $this->data[ 'attribute' ]['valid'] == false )
      {
        //----------------------------------------------------------------------
        // ERROR: attribute parameter not found
        //----------------------------------------------------------------------

      }else
      {

      
        // Compose links
        $this->data[ 'edit_button_href' ] = $this->url->link( 'workplace/customers/attributes/edit/Edit', 'index_guid=' .  $this->data[ 'attribute' ][ 'index_guid' ], 'SSL' );
        $this->data[ 'cancel_button_href' ] = $this->url->link( 'workplace/customers/info', 'guid=' .  $this->data[ 'attribute' ][ 'customer_guid' ] . '#attribute' . $this->data[ 'attribute' ]['index_guid'], 'SSL' );

        //--------------------------------------------------------------------
        // Set page data
        //--------------------------------------------------------------------

        // Set document properties
        $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
        $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
        $this->response->setKeywords( '' );
        $this->response->setRobots( 'index, follow' );

        // Add styles
        $this->response->addStyle( 'catalog/view/stylesheet/workplace/add_assembly_unit.css' );

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
  // Update attribute
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Edit()
  {

    // Init json data
    $json = array();

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'customers_attributes_edit', 'Edit', $this->language->Get_Language_Code() );

    // Load data models
      $this->load->model( 'customers/customers' );

    // Init unit data
    $data = array();

    // Set request data valid status
    $request_data_valid = true;


    //------------------------------------------------------------------------
    // Check parameter: Index GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if( $this->request->Is_GET_Parameter_GUID( 'index_guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Index GUID parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'index_guid' ] = $this->data[ 'workplace_customers_attributes_edit_index_guid_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Index GUID parameter found
      //----------------------------------------------------------------------

      // Get index GUID
      $index_guid = $this->request->Get_GET_Parameter_As_GUID( 'index_guid' );
      $attribute = $this->model_customers_customers->Get_Customer_Attribute( $index_guid, $this->language->Get_Language_Code() );

      // Test for information invalid
      if( $attribute['valid'] === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Attribute not valid
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'index_guid' ] = $this->data[ 'workplace_customers_attributes_index_guid_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        // Store subitem index guid
        $data[ 'attribute' ] = $attribute;

      }

    }


    //------------------------------------------------------------------------
    // Check parameter: Attribute value
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Exists( 'value' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Attribute value parameter not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'value' ] = $this->data[ 'workplace_customers_attributes_edit_value_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Attribute value parameter found
      //----------------------------------------------------------------------

      if ( $this->request->Is_POST_Parameter_Certain_Size_String( 'value', 1, $this->model_customers_customers->Get_Customer_Attribute_Value_Maximum_String_Size() ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Attribute value parameter not valid
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'value' ] = $this->data[ 'workplace_customers_attributes_edit_value_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Attribute value parameter valid
        //----------------------------------------------------------------------

        // Store data
        $data[ 'value' ] = $this->request->Get_POST_Parameter_As_String( 'value' );

      }

    }





    //------------------------------------------------------------------------
    // Try to Update Attribute value
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
      // Parameters present and valid, add subitem
      //----------------------------------------------------------------------

      // Update  Attribute value
      $return_data = $this->model_customers_customers->Edit_Attribute( $data[ 'attribute' ][ 'index_guid' ], $data[ 'value' ]);

      // Test for error
      if ( $return_data[ 'return_code' ] === false )
      {

        //--------------------------------------------------------------------
        // ERROR: Save changes failed
        //--------------------------------------------------------------------

        // Set error message
        $json[ 'error' ][ 'error' ] = 'Create and add subitem failed.';

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Save changes successful
        //--------------------------------------------------------------------

        // Set redirect URL
        $json[ 'redirect_url' ] = $this->url->link( 'workplace/customers/info', 'guid=' . $data[ 'attribute' ][ 'customer_guid' ] . '#attribute' . $data[ 'attribute' ][ 'index_guid' ], 'SSL' );

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