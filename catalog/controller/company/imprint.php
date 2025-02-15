<?php
class ControllerCompanyImprint extends Controller
{

  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'company', 'imprint', 'index', $this->language->Get_Language_Code() );

    // Get language code
    $language_code = $this->language->Get_Language_Code();

    // Set documet properties
    $this->response->setTitle( $this->language->get( 'company_imprint_document_title' ) );
    $this->response->setDescription( $this->language->get( 'company_imprint_document_meta_description' ) );
    $this->response->setRobots( 'noindex, follow' );

    // Set page data
    $this->data[ 'text_message_header' ] = $this->language->get( 'company_imprint_page_headline' );

    //--------------------------------------------------------------------------
    
    $this->data[ 'company_legal_address_headline_text' ] = $this->language->get( 'company_imprint_legal_address_headline' );

    $this->data[ 'company_name_value' ] = $this->config->get( 'shop_headquarter_company_name', $language_code );
    $this->data[ 'company_address_line_1_value' ] = $this->config->get( 'shop_headquarter_address', $language_code );
    $this->data[ 'company_address_line_2_value' ] = $this->config->get( 'shop_headquarter_postcode', $language_code ) . ' ' . $this->config->get( 'shop_headquarter_city', $language_code );
    $this->data[ 'company_address_country_value' ] = $this->config->get( 'shop_headquarter_country', $language_code );

    //--------------------------------------------------------------------------

    $this->data[ 'company_legal_information_headline_text' ] = $this->language->get( 'company_imprint_legal_information_headline' );

    $this->data[ 'company_legal_form_text' ] = $this->language->get( 'company_imprint_legal_form_key' );
    $this->data[ 'company_legal_form_value' ] = $this->config->get( 'shop_company_legal_form', $language_code );

    $this->data[ 'commercial_register_name_text' ] = $this->language->get( 'company_imprint_company_register_court_name_key' );
    $this->data[ 'commercial_register_name_value' ] = $this->config->get( 'shop_company_register_court', '' );

    $this->data[ 'commercial_register_number_text' ] = $this->language->get( 'company_imprint_company_register_court_number_key' );
    $this->data[ 'commercial_register_number_value' ] = $this->config->get( 'shop_company_register_number' );

    //--------------------------------------------------------------------------

    $this->data[ 'company_contact_headline_text' ] = $this->language->get( 'company_imprint_company_contact_information_headline' );

    $this->data[ 'company_contact_email_text' ] = $this->language->get( 'company_imprint_company_contact_email_key' );
    $this->data[ 'company_contact_email_value' ] = $this->config->get( 'shop_company_contact_email' );

    $this->data[ 'company_contact_contact_form_text' ] = $this->language->get( 'company_imprint_company_contact_form_key' );
    $this->data[ 'company_contact_contact_form_value' ] = 'http://www.anvilex.com/test/index.php?route=company/contact';
    $this->data[ 'company_contact_contact_form_href' ] = 'http://www.anvilex.com/test/index.php?route=company/contact';

    //--------------------------------------------------------------------------

    $this->data[ 'company_tax_information_headline_text' ] = $this->language->get( 'company_imprint_company_tax_information_headline' );

    $this->data[ 'company_vat_number_text' ] = $this->language->get( 'company_imprint_company_vat_number_key' );
    $this->data[ 'company_vat_number_value' ] = $this->config->get( 'shop_company_vat_id' );

    //--------------------------------------------------------------------------

    $this->data[ 'company_authorized_representative_person_headline_text' ] = $this->language->get( 'company_imprint_company_authorized_representative_person_headline' );
    $this->data[ 'company_authorized_representative_person_key' ] = $this->language->get( 'company_imprint_company_authorized_representative_person_key' );
    $this->data[ 'company_authorized_representative_person_value' ] = $this->config->get( 'company_authorized_representative_person', $language_code );

    //--------------------------------------------------------------------------

    $this->data[ 'company_responsible_for_content_person_headline_text' ] = $this->language->get( 'company_imprint_company_responsible_for_content_headline' );
    $this->data[ 'company_responsible_for_content_person_value' ] = $this->config->get( 'company_responsible_for_content_person', $language_code );

    //--------------------------------------------------------------------------

    $this->data[ 'online_dispute_resolution_headline_text' ] = $this->language->get( 'company_imprint_online_dispute_resolution_headline' );
    $this->data[ 'online_dispute_resolution_text' ] = $this->language->get( 'company_imprint_online_dispute_resolution_key' );
    $this->data[ 'online_dispute_resolution_value' ] = 'https://ec.europa.eu/odr';
    $this->data[ 'online_dispute_resolution_href' ] = 'https://ec.europa.eu/odr';
    $this->data[ 'online_dispute_resolution_disclouse_text' ] = $this->language->get( 'company_imprint_online_dispute_resolution_disclouse' );

    //--------------------------------------------------------------------------
      
    // Set page sections
    $this->children = array(
      'common/footer',
      'common/header'
    );

	}

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>