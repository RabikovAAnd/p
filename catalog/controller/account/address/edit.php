<?php
class ControllerAccountAddressEdit extends Controller
{

  private $error = array();

  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for customer not logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------
      
//      $this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

      // Redirect to login page
      $this->response->Redirect($this->url->link('account/login', '', 'SSL'));

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------
      
      // Try to get parameter "guid"
//      if ( isset( $this->request->get[ 'guid' ] ) === false )
      if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
      {
  
        //------------------------------------------------------------------------
        // ERROR: Parameter not set
        //------------------------------------------------------------------------
  
        // Load messages
        $this->messages->Load( $this->data, 'account', 'address_form_edit', 'index', $this->language->Get_Language_Code() );
  
        $this->data[ 'address_href' ] = $this->url->link( 'account/address', '', 'SSL' );
        $this->data[ 'countries' ] = $this->location->Get_Countries( $this->language->Get_Language_Code() );
        $this->data[ 'zones' ] = $this->location->Get_Zones( $this->language->Get_Language_Code() );

        //----------------------------------------------------------------------
        // Render page
        //----------------------------------------------------------------------

        $this->response->setTitle( $this->language->get( 'heading_title' ) );

        // Add styles
        $this->response->addStyle( 'catalog/view/stylesheet/account/account.css' );
        $this->response->addStyle( 'catalog/view/stylesheet/account/address.css' );
  
        $this->children = array(
          'common/footer',
          'account/menu',
          'common/header'
        );
    
      }
      else
      {
  
        //------------------------------------------------------------------------
        // Parameter found, continue processing
        //------------------------------------------------------------------------
        
        //------------------------------------------------------------------------
        // Set page data
        //------------------------------------------------------------------------
        
        // Load messages
        $this->messages->Load( $this->data, 'account', 'address_form_edit', 'index', $this->language->Get_Language_Code() );

        // Load model
        $this->load->model( 'address/address' );

        // Get address GUID
        $address_guid = $this->request->Get_GET_Parameter_As_String( 'guid' );
  
        $this->data[ 'address' ] = $this->model_address_address->Get_Address( $address_guid );
        
        $this->data[ 'address_href' ] = $this->url->link( 'account/address', '', 'SSL' );
        
        $this->data['countries'] = $this->location->Get_Countries( $this->language->Get_Language_Code() );
        $this->data['zones'] = $this->location->Get_Zones( $this->language->Get_Language_Code() );

        $this->data[ 'account_address_form_edit_save_button_href' ] = $this->url->link( 'account/address/edit/update', '', 'SSL' );
        $this->data[ 'account_address_form_edit_delete_button_href' ] = $this->url->link( 'account/address/edit/inactivate', '', 'SSL' );

        //-----------------------------------------------------------------------
        // Render page
        //-----------------------------------------------------------------------

        // Set document properties
        $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
        $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
        $this->response->setKeywords( '' );
        $this->response->setRobots( 'index, follow' );

        // Add styles
        $this->response->addStyle( 'catalog/view/stylesheet/account/account.css' );
        $this->response->addStyle( 'catalog/view/stylesheet/account/address.css' );

        // Set page configuration
        $this->children = array(
          'common/footer',
          'account/menu',
          'common/header'
        );

      }

    }

  }

  //----------------------------------------------------------------------------

  protected function parametersExists(): bool
  {

    return (
      $this->request->Is_POST_Parameter_Exists('country_id') &&
      $this->request->Is_POST_Parameter_Exists('zone_id') &&
      $this->request->Is_POST_Parameter_Exists('postcode') &&
      $this->request->Is_POST_Parameter_Exists('city') &&
      $this->request->Is_POST_Parameter_Exists('street') &&
      $this->request->Is_POST_Parameter_Exists('house') &&
      $this->request->Is_POST_Parameter_Exists('building') &&
      $this->request->Is_POST_Parameter_Exists('apartment')
    );

  }

    //----------------------------------------------------------------------------

    protected function dataVerification()
    {

        // Load messages
        $this->messages->Load( $this->data, 'account', 'address_form_edit', 'dataVerification', $this->language->Get_Language_Code() );

//
//        if (($this->request->Get_POST_Parameter_As_String('customer_id') == '')
//            || ( !is_numeric($this->request->Get_POST_Parameter_As_String('customer_id')))) {
//            $this->error['customer_id'] = $this->data['account_address_form_' . 'customer_id_error'];
//        }
        if (($this->request->Get_POST_Parameter_As_String('country_id') == '0')
            || ( !is_numeric($this->request->Get_POST_Parameter_As_String('country_id')))) {
            $this->error['country_id'] = $this->data['account_address_form_edit_' . 'country_id_error'];
        }

        if (($this->request->Get_POST_Parameter_As_String('zone_id') == '0')
            || ( !is_numeric($this->request->Get_POST_Parameter_As_String('zone_id')))) {
            $this->error['zone_id'] = $this->data['account_address_form_edit_' . 'zone_id_error'];
        }
        if ($this->request->Get_POST_Parameter_As_String('postcode') == '') {
            $this->error['postcode'] = $this->data['account_address_form_edit_' . 'postcode_error'];
        }
        if ($this->request->Get_POST_Parameter_As_String('city') == '') {
            $this->error['city'] = $this->data['account_address_form_edit_' . 'city_error'];
        }
        if ($this->request->Get_POST_Parameter_As_String('street') == '') {
            $this->error['street'] = $this->data['account_address_form_edit_' . 'street_error'];
        }
        if ($this->request->Get_POST_Parameter_As_String('house') == '') {
            $this->error['house'] = $this->data['account_address_form_edit_' . 'house_error'];
        }

        return $this->error;

    }

  //----------------------------------------------------------------------------
  // Inactivate address
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function inactivate()
  {

    // Init json data
    $json = array();

    if (!$this->customer->Is_Logged()) 
    {

//      $this->session->data[ 'redirect' ] = $this->url->link( 'account/address', '', 'SSL' );

      $this->response->Redirect( $this->url->link( 'account/login', '', 'SSL') );

    }
    else
    {

      $this->load->model( 'address/address' );

      if ( $this->request->Is_POST_Parameter_Exists( 'guid' ) === false ) 
      {

        $json[ 'return_code' ] = false;

      }
      else
      {

        $guid = $this->request->post[ 'guid' ];

        // Set redirect link
        $json[ 'redirect_url' ] = $this->url->link( 'account/address', '', 'SSL' );

        // Set success code
        $json[ 'return_code' ] = $this->model_address_address->Inactivate( $guid );

      }

    }

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------
  // Update address
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function update() 
  {

    // Init json data
    $json = array();

    // Test for customer not logged in
    if ( $this->customer->Is_Logged() === false ) 
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // ???
//      $this->session->data['redirect'] = $this->url->link( 'account/address', '', 'SSL' );

      // Set redirect link
      $json[ 'redirect_url' ] = $this->url->link( 'account/login', '', 'SSL' );

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      $json[ 'return_code' ] = false;

      if ( $this->parametersExists() ) 
      {

        if( count( $this->dataVerification() ) === 0 )
        {

          $guid = $this->request->post[ 'guid' ];

          $data[ 'country_id' ] = $this->request->post[ 'country_id' ];
          $data[ 'zone_id' ] = $this->request->post[ 'zone_id' ];
          $data[ 'postcode' ] = $this->request->post[ 'postcode' ];
          $data[ 'city' ] = $this->request->post[ 'city' ];
          $data[ 'street' ] = $this->request->post[ 'street' ];
          $data[ 'house' ] = $this->request->post[ 'house' ];
          $data[ 'building' ] = $this->request->post[ 'building' ];
          $data[ 'apartment' ] = $this->request->post[ 'apartment' ];

          $this->load->model( 'address/address' );

          $json[ 'redirect_url' ] = $this->url->link( 'account/address/list', '', 'SSL' );

          $json[ 'return_code' ] = $this->model_address_address->Update( $this->customer->Get_GUID(), $guid, $data );


        }
        else
        {

          $json['error'] = $this->dataVerification();

        }

      }

    }

    // Send json data
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------

  public function country()
  {

    $json = array();

    $country_info = $this->location->Get_Country_Info($this->request->get['country_id']);

    if ($country_info)
    {

      $this->load->model('localisation/zone');

      $json = array(
        'country_id'        => $country_info['country_id'],
        'name'              => $country_info['name'],
        'iso_code_2'        => $country_info['iso_code_2'],
        'iso_code_3'        => $country_info['iso_code_3'],
        'address_format'    => $country_info['address_format'],
        'postcode_required' => $country_info['postcode_required'],
        'zone'              => $this->location->Get_Country_Zones($this->request->get['country_id']),
        'status'            => $country_info['status']
      );

    }

    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------

  public function set_zones()
  {

    $json = array();

    $json['zone'] = $this->location->Get_Zones();

    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------

  public function set_country_by_zone()
  {

    $json = array();

    $zone_info = $this->location->Get_Country_Zone_Info($this->request->get['zone_id']);

    $this->load->model('localisation/zone');

    $json['country_id'] = $zone_info['country_id'];

    $this->response->Set_Json_Output( $json );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>