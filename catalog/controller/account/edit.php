<?php
class ControllerAccountEdit extends Controller
{

  private $error = array();

  //----------------------------------------------------------------------------
  // Default method
  //----------------------------------------------------------------------------
  
  public function index()
  {

    // Test for customer logged
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

      // Load messages
      $this->messages->Load( $this->data, 'account', 'edit', 'index', $this->language->Get_Language_Code() );

      //------------------------------------------------------------------------
      // Render page
      //------------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle($this->messages->Get_Message('document_title_text'));
      $this->response->setDescription($this->messages->Get_Message('document_description_text'));
      $this->response->setKeywords( '' );
      $this->response->setRobots( 'index, follow' );

      // Add styles
      $this->response->addStyle( 'catalog/view/stylesheet/account/account.css' );
      $this->response->addStyle( 'catalog/view/stylesheet/account/edit.css' );

      // Set page configuration
      $this->children = array(
        'common/footer',
        'account/menu',
        'common/header'
      );

      $this->data[ 'customer_data' ] = $this->customer->Get_Contact_Information( $this->customer->Get_GUID() );
      $this->data[ 'customer_country' ] = $this->location->Get_Country_By_ISO2(  $this->data[ 'customer_data' ]['registration_country'], $this->language->Get_Language_Code()  );

      // Set submit button link
      $this->data[ 'account_edit_save_button_href' ] = $this->url->link( 'account/edit/submit', '', 'SSL' );

    }

  }

  //----------------------------------------------------------------------------
  // Submit changes
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function submit()
  {

    // Init json data
    $json = array();

    // Test for customer logged
    if ( $this->customer->Is_Logged() === false ) 
    {

      //------------------------------------------------------------------------
      // Customer not logged in
      //------------------------------------------------------------------------

      // Set error code
      $json[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'account', 'edit', 'submit', $this->language->Get_Language_Code() );

      $this->data['firstname'] =$this->request->Get_POST_Parameter_As_String('firstname');
      $this->data['lastname'] = $this->request->Get_POST_Parameter_As_String('lastname');
      $this->data['email'] = $this->request->Get_POST_Parameter_As_String('email');
      $this->data['middlename'] = $this->request->Get_POST_Parameter_As_String('middlename');
      $this->data['phone'] = $this->request->Get_POST_Parameter_As_String('phone');
      $this->data['company_name'] = $this->request->Get_POST_Parameter_As_String('company_name');
      $this->data['company_register_id'] = $this->request->Get_POST_Parameter_As_String('company_register_id');
      $this->data['company_tax_id'] = $this->request->Get_POST_Parameter_As_String('company_tax_id');
      $this->data['legal_entity'] =$this->customer->Get_Contact_Information( $this->customer->Get_GUID() )[ 'legal_entity' ];

      if ( count( $this->validationCheck() ) == 0 ) 
      {

        // Update customer data
        $this->customer->Update( $this->customer->Get_GUID(), $this->data );

        // Set success code
        $json[ 'return_code' ] = true;
        $json[ 'animation' ] = [$this->data['account_edit_save_button_text'], $this->data['account_edit_save_button_success_text']];
      } 
      else 
      {

   
        $json[ 'error' ] = $this->validationCheck();
   
        // Set error code
        $json[ 'return_code' ] = false;
    
      }
    
    }
    
    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------

  protected function validationCheck()
  {

    // Load messages
    $this->messages->Load( $this->data, 'account', 'edit', 'validationCheck', $this->language->Get_Language_Code() );

        if($this->request->Is_POST_Parameter_Exists('firstname'))
        {
            if ((utf8_strlen($this->request->Get_POST_Parameter_As_String('firstname')) < 1)
                || (utf8_strlen($this->request->Get_POST_Parameter_As_String('firstname')) > 32)) {
                $this->error['firstname'] = $this->data['account_edit_' . 'firstname_error'];
            }
        }
        else
        {
            $this->error['firstname'] = $this->data['firstname'];
        }

        if($this->request->Is_POST_Parameter_Exists('lastname'))
        {
            if ((utf8_strlen($this->request->Get_POST_Parameter_As_String('lastname')) < 1)
                || (utf8_strlen($this->request->Get_POST_Parameter_As_String('lastname')) > 32)) {
                $this->error['lastname'] = $this->data['account_edit_' . 'lastname_error'];
            }
        }
        else
        {
            $this->error['lastname'] = $this->data['lastname'];
        }

        if($this->request->Is_POST_Parameter_Exists('phone'))
        {
            if (utf8_strlen($this->request->Get_POST_Parameter_As_String('phone')) > 32) {
                $this->error['phone'] = $this->data['account_edit_' . 'telephone_error'];
            }
        }
        else
        {
            $this->error['phone'] = $this->data['phone'];
        }

        if ($this->customer->Get_Contact_Information( $this->customer->Get_GUID() )[ 'legal_entity' ] == '1')
        {
            if (($this->request->Get_POST_Parameter_As_String('company_register_id') == '')
                || ( !is_numeric($this->request->Get_POST_Parameter_As_String('company_register_id'))))
            {
                $this->error['company_register_id'] = $this->data['account_edit_' . 'company_register_id_error'];
            }

            $this->load->model('localisation/country');

            $country_info = $this->model_localisation_country->getCountry($this->data['country_id']);

//            if ($country_info) {
//                // VAT Validation
//                $this->load->helper('vat');
//
//                if ($this->config->get('config_vat') && $this->request->Get_POST_Parameter_As_String('tax_id')
//                    && (vat_validation($country_info['iso_code_2'], $this->request->Get_POST_Parameter_As_String('tax_id')) == 'invalid')) {
//                    $this->error['tax_id'] = $this->data['account_edit_' . 'vat_error'];
//                }
//            }

            if (($this->request->Get_POST_Parameter_As_String('company_tax_id') == '')
                || ( !is_numeric($this->request->Get_POST_Parameter_As_String('company_tax_id'))))
            {
                $this->error['company_tax_id'] = $this->data['account_edit_' . 'company_tax_id_error'];
            }

        }

    return $this->error;

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>