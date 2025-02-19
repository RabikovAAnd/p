<?php
class ControllerAccountAddressList extends Controller
{

  private $error = array();
  
  //----------------------------------------------------------------------------
  // Default method
  //----------------------------------------------------------------------------
  
  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'account', 'address_list', 'index', $this->language->Get_Language_Code() );

    // Load data model
    $this->load->model( 'address/address' );

    $adresses = $this->model_address_address->Get_Addresses( $this->customer->Get_GUID() );
      
    foreach ( $adresses as $address ) 
    {

      $this->data['addresses'][] = array(
        'guid' => $address[ 'guid' ],
        'address_href' => $this->url->link( 'account/address/edit', 'guid=' . $address[ 'guid' ], 'SSL' ),
        'country_name' => $this->location->Get_Country_Info( $address['country_id'] )['name'],
        'zone_name' => $this->location->Get_Country_Zone_Info( $address['zone_id'] )['name'],
        'postcode' => $address[ 'postcode' ],
        'district' => $address[ 'district' ],
        'city' => $address[ 'city' ],
        'street' => $address[ 'street' ],
        'house' => $address[ 'house' ],
        'building' => $address[ 'building' ],
        'apartment' => $address[ 'apartment' ],
      );

    }

    $this->data[ 'address_form_href' ] = $this->url->link( 'account/address/add', '', 'SSL' );

    //------------------------------------------------------------------------
    // Set page data
    //------------------------------------------------------------------------
      
    // Set document properties
    $this->response->setTitle($this->messages->Get_Message('document_title_text'));
    $this->response->setDescription($this->messages->Get_Message('document_description_text'));
    $this->response->setRobots( 'index, follow' );

    // Add styles
    $this->response->addStyle( 'catalog/view/stylesheet/account/address.css' );
    $this->response->addStyle( 'catalog/view/stylesheet/account/account.css' );

    // Set page configuration
    $this->children = array(
      'common/footer',
      'account/menu',
      'common/header'
    );

  }

  //----------------------------------------------------------------------------
  //
  //----------------------------------------------------------------------------
  
  public function insert() 
  {
    
    $this->response->setTitle( $this->language->get('heading_title') );

    $this->load->model('address/address');

    if ( $this->request->Is_POST_Request() && $this->validateForm() )
    {
    
      $this->model_address_address->addAddress( $this->request->post );

      $this->session->data['success'] = $this->language->get( 'text_insert' );

      $this->response->Redirect( $this->url->link( 'account/address', '', 'SSL') );
    
    }
    
    $this->getForm();
  
  }

  //----------------------------------------------------------------------------

  public function update()
  {

    $this->response->setTitle($this->language->get('heading_title'));

    $this->load->model('address/address');

    if ( $this->request->Is_POST_Request() && $this->validateForm() )
    {

      $this->model_address_address->editAddress($this->request->get['address_id'], $this->request->post);

      $this->session->data['success'] = $this->language->get('text_update');

      $this->response->Redirect($this->url->link('account/address', '', 'SSL'));

    }

    $this->getForm();

  }

  //----------------------------------------------------------------------------

  public function delete()
  {

    $this->response->setTitle($this->language->get('heading_title'));

    $this->load->model('address/address');

    if (isset($this->request->get['address_id']) && $this->validateDelete())
    {

      $this->model_address_address->deleteAddress($this->request->get['address_id']);

      $this->session->data['success'] = $this->language->get('text_delete');

      $this->response->Redirect($this->url->link('account/address', '', 'SSL'));

    }

    $this->getList();

  }

  //----------------------------------------------------------------------------

  protected function getList()
  {
      
        $this->data['breadcrumbs'][] = array(
          'text'      => $this->language->get('text_home'),
      'href'      => $this->url->link('common/home'),
          'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
          'text'      => $this->language->get('text_account'),
      'href'      => $this->url->link('account/account', '', 'SSL'),
          'separator' => $this->language->get('text_separator')
        );

        $this->data['breadcrumbs'][] = array(
          'text'      => $this->language->get('heading_title'),
      'href'      => $this->url->link('account/address', '', 'SSL'),
          'separator' => $this->language->get('text_separator')
        );

    if (isset($this->error['warning'])) {
        $this->data['error_warning'] = $this->error['warning'];
    } else {
      $this->data['error_warning'] = '';
    }

    if (isset($this->session->data['success'])) {
      $this->data['success'] = $this->session->data['success'];

        unset($this->session->data['success']);
    } else {
      $this->data['success'] = '';
    }

      $this->data['addresses'] = array();

    $results = $this->model_address_address->getAddresses();

      foreach ($results as $result) {
      if ($result['address_format']) {
            $format = $result['address_format'];
        } else {
        $format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
      }

        $find = array(
          '{firstname}',
          '{lastname}',
          '{company}',
            '{address_1}',
            '{address_2}',
          '{city}',
            '{postcode}',
            '{zone}',
        '{zone_code}',
            '{country}'
      );

      $replace = array(
          'firstname' => $result['firstname'],
          'lastname'  => $result['lastname'],
          'company'   => $result['company'],
            'address_1' => $result['address_1'],
            'address_2' => $result['address_2'],
            'city'      => $result['city'],
            'postcode'  => $result['postcode'],
            'zone'      => $result['zone'],
        'zone_code' => $result['zone_code'],
            'country'   => $result['country']
      );

          $this->data['addresses'][] = array(
            'address_id' => $result['address_id'],
            'address'    => str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format)))),
            'update'     => $this->url->link('account/address/update', 'address_id=' . $result['address_id'], 'SSL'),
        'delete'     => $this->url->link('account/address/delete', 'address_id=' . $result['address_id'], 'SSL')
          );
      }

      $this->data['insert'] = $this->url->link('account/address/insert', '', 'SSL');
    $this->data['back'] = $this->url->link('account/account', '', 'SSL');

    $this->children = array(
      'common/footer',
      'common/header'
    );

  }

  //----------------------------------------------------------------------------

  protected function getForm()
  {
  
    $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
          'text'      => $this->language->get('text_home'),
      'href'      => $this->url->link('common/home'),
          'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
          'text'      => $this->language->get('text_account'),
      'href'      => $this->url->link('account/account', '', 'SSL'),
          'separator' => $this->language->get('text_separator')
        );

        $this->data['breadcrumbs'][] = array(
          'text'      => $this->language->get('heading_title'),
      'href'      => $this->url->link('account/address', '', 'SSL'),
          'separator' => $this->language->get('text_separator')
        );

    if (!isset($this->request->get['address_id'])) {
          $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_edit_address'),
        'href'      => $this->url->link('account/address/insert', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
          );
    } else {
          $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_edit_address'),
        'href'      => $this->url->link('account/address/update', 'address_id=' . $this->request->get['address_id'], 'SSL'),
            'separator' => $this->language->get('text_separator')
          );
    }


    if (isset($this->error['firstname'])) {
        $this->data['error_firstname'] = $this->error['firstname'];
    } else {
      $this->data['error_firstname'] = '';
    }

    if (isset($this->error['lastname'])) {
        $this->data['error_lastname'] = $this->error['lastname'];
    } else {
      $this->data['error_lastname'] = '';
    }

      if (isset($this->error['company_id'])) {
      $this->data['error_company_id'] = $this->error['company_id'];
    } else {
      $this->data['error_company_id'] = '';
    }

      if (isset($this->error['tax_id'])) {
      $this->data['error_tax_id'] = $this->error['tax_id'];
    } else {
      $this->data['error_tax_id'] = '';
    }

    if (isset($this->error['address_1'])) {
        $this->data['error_address_1'] = $this->error['address_1'];
    } else {
      $this->data['error_address_1'] = '';
    }

    if (isset($this->error['city'])) {
        $this->data['error_city'] = $this->error['city'];
    } else {
      $this->data['error_city'] = '';
    }

    if (isset($this->error['postcode'])) {
        $this->data['error_postcode'] = $this->error['postcode'];
    } else {
      $this->data['error_postcode'] = '';
    }

    if (isset($this->error['country'])) {
      $this->data['error_country'] = $this->error['country'];
    } else {
      $this->data['error_country'] = '';
    }

    if (isset($this->error['zone'])) {
      $this->data['error_zone'] = $this->error['zone'];
    } else {
      $this->data['error_zone'] = '';
    }

    if (!isset($this->request->get['address_id'])) {
        $this->data['action'] = $this->url->link('account/address/insert', '', 'SSL');
    } else {
        $this->data['action'] = $this->url->link('account/address/update', 'address_id=' . $this->request->get['address_id'], 'SSL');
    }

    if (isset($this->request->get['address_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) 
    {
      $address_info = $this->model_address_address->getAddress($this->request->get['address_id']);
    }

      if (isset($this->request->post['firstname'])) {
          $this->data['firstname'] = $this->request->post['firstname'];
      } elseif (!empty($address_info)) {
          $this->data['firstname'] = $address_info['firstname'];
      } else {
      $this->data['firstname'] = '';
    }

      if (isset($this->request->post['lastname'])) {
          $this->data['lastname'] = $this->request->post['lastname'];
      } elseif (!empty($address_info)) {
          $this->data['lastname'] = $address_info['lastname'];
      } else {
      $this->data['lastname'] = '';
    }

      if (isset($this->request->post['company'])) {
          $this->data['company'] = $this->request->post['company'];
      } elseif (!empty($address_info)) {
      $this->data['company'] = $address_info['company'];
    } else {
          $this->data['company'] = '';
      }

    if (isset($this->request->post['company_id'])) {
        $this->data['company_id'] = $this->request->post['company_id'];
      } elseif (!empty($address_info)) {
      $this->data['company_id'] = $address_info['company_id'];
    } else {
      $this->data['company_id'] = '';
    }

    if (isset($this->request->post['tax_id'])) {
        $this->data['tax_id'] = $this->request->post['tax_id'];
      } elseif (!empty($address_info)) {
      $this->data['tax_id'] = $address_info['tax_id'];
    } else {
      $this->data['tax_id'] = '';
    }

      if (isset($this->request->post['address_1'])) 
      {
          $this->data['address_1'] = $this->request->post['address_1'];
      } elseif (!empty($address_info)) {
      $this->data['address_1'] = $address_info['address_1'];
    } else {
          $this->data['address_1'] = '';
      }

      if (isset($this->request->post['address_2'])) 
      {
          $this->data['address_2'] = $this->request->post['address_2'];
      } elseif (!empty($address_info)) {
      $this->data['address_2'] = $address_info['address_2'];
    } else {
          $this->data['address_2'] = '';
      }

      if (isset($this->request->post['postcode'])) 
      {
          $this->data['postcode'] = $this->request->post['postcode'];
      } elseif (!empty($address_info)) {
      $this->data['postcode'] = $address_info['postcode'];
    } else {
          $this->data['postcode'] = '';
      }

      if (isset($this->request->post['city'])) 
      {
          $this->data['city'] = $this->request->post['city'];
      } elseif (!empty($address_info)) {
      $this->data['city'] = $address_info['city'];
    } else {
          $this->data['city'] = '';
      }

      if (isset($this->request->post['country_id'])) 
      {
          $this->data['country_id'] = $this->request->post['country_id'];
      }  elseif (!empty($address_info)) {
          $this->data['country_id'] = $address_info['country_id'];
      } else {
          $this->data['country_id'] = $this->config->get('config_country_id');
      }

      if (isset($this->request->post['zone_id'])) 
      {
          $this->data['zone_id'] = $this->request->post['zone_id'];
      }  elseif (!empty($address_info)) {
          $this->data['zone_id'] = $address_info['zone_id'];
      } else {
          $this->data['zone_id'] = '';
      }

      $this->data['countries'] = $this->location->Get_Countries( $this->language->Get_Language_Code() );

      if (isset($this->request->post['default'])) {
          $this->data['default'] = $this->request->post['default'];
      } elseif (isset($this->request->get['address_id'])) {
          $this->data['default'] = $this->customer->getAddressId() == $this->request->get['address_id'];
      } else {
      $this->data['default'] = false;
    }

      $this->data['back'] = $this->url->link('account/address', '', 'SSL');

    $this->children = array(
      'common/footer',
      'common/header'
    );

  }

  //----------------------------------------------------------------------------

  protected function validateForm()
  {
      if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
          $this->error['firstname'] = $this->language->get('error_firstname');
      }

      if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
          $this->error['lastname'] = $this->language->get('error_lastname');
      }

      if ((utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 128)) {
          $this->error['address_1'] = $this->language->get('error_address_1');
      }

      if ((utf8_strlen($this->request->post['city']) < 2) || (utf8_strlen($this->request->post['city']) > 128)) {
          $this->error['city'] = $this->language->get('error_city');
      }

    $this->load->model('localisation/country');

    $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

    if ($country_info) {
      if ($country_info['postcode_required'] && (utf8_strlen($this->request->post['postcode']) < 2) || (utf8_strlen($this->request->post['postcode']) > 10)) {
        $this->error['postcode'] = $this->language->get('error_postcode');
      }

      // VAT Validation
      $this->load->helper('vat');

      if ($this->config->get('config_vat') && !empty($this->request->post['tax_id']) && (vat_validation($country_info['iso_code_2'], $this->request->post['tax_id']) == 'invalid')) {
        $this->error['tax_id'] = $this->language->get('error_vat');
      }
    }

      if ($this->request->post['country_id'] == '') {
          $this->error['country'] = $this->language->get('error_country');
      }

      if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
          $this->error['zone'] = $this->language->get('error_zone');
      }

      if (!$this->error) {
          return true;
    } else {
          return false;
      }
  }

  //----------------------------------------------------------------------------

  protected function validateDelete()
  {
      if ($this->model_address_address->getTotalAddresses() == 1) 
      {
          $this->error['warning'] = $this->language->get('error_delete');
      }

      if ($this->customer->getAddressId() == $this->request->get['address_id']) {
          $this->error['warning'] = $this->language->get('error_default');
      }

      if (!$this->error) 
      {
          return true;
      } 
      else 
      {
          return false;
      }
  }

  //----------------------------------------------------------------------------
  //
  //----------------------------------------------------------------------------

  public function country()
  {

    $json = array();

    $this->load->model( 'localisation/country' );

    $country_info = $this->model_localisation_country->getCountry( $this->request->get[ 'country_id' ] );

    if ( $country_info ) 
    {
      
      $this->load->model( 'localisation/zone' );

      $json = array(
        'country_id'        => $country_info['country_id'],
        'name'              => $country_info['name'],
        'iso_code_2'        => $country_info['iso_code_2'],
        'iso_code_3'        => $country_info['iso_code_3'],
        'address_format'    => $country_info['address_format'],
        'postcode_required' => $country_info['postcode_required'],
        'zone'              => $this->model_localisation_zone->getZonesByCountryId( $this->request->get[ 'country_id' ] ),
        'status'            => $country_info['status']
      );
    
    }

    $this->response->Set_Json_Output( $json );
  
  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>