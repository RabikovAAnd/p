<?php
class ControllerCompanyPrivacy extends Controller
{

  //----------------------------------------------------------------------------

  public function index()
  {

    //--------------------------------------------------------------------------
    // Set page data
    //--------------------------------------------------------------------------

    // Load messages
    $this->messages->Load( $this->data, 'company', 'privacy', 'index', $this->language->Get_Language_Code() );

    // Set data
    $this->data['text_message_header'] = $this->language->get( 'text_header' );

    $this->data[ 'privacy_chapter_headline_1' ] = $this->language->get( 'privacy_chapter_headline_1' );
    $this->data[ 'privacy_chapter_content_1_1' ] = $this->language->get( 'privacy_chapter_content_1_1' ); 

    $this->data[ 'privacy_chapter_headline_2' ] = $this->language->get( 'privacy_chapter_headline_2' );
    $this->data[ 'privacy_chapter_content_2_1' ] = $this->language->get( 'privacy_chapter_content_2_1' );

    $this->data[ 'privacy_chapter_headline_3' ] = $this->language->get( 'privacy_chapter_headline_3' );
    $this->data[ 'privacy_chapter_content_3_1' ] = $this->language->get( 'privacy_chapter_content_3_1' );

    $this->data[ 'privacy_chapter_headline_4' ] = $this->language->get( 'privacy_chapter_headline_4' );
    $this->data[ 'privacy_chapter_content_4_1' ] = $this->language->get( 'privacy_chapter_content_4_1' );

    $this->data[ 'privacy_chapter_headline_5' ] = $this->language->get( 'privacy_chapter_headline_5' );
    $this->data[ 'privacy_chapter_content_5_1' ] = $this->language->get( 'privacy_chapter_content_5_1' );

    $this->data[ 'privacy_chapter_headline_6' ] = $this->language->get( 'privacy_chapter_headline_6' );
    $this->data[ 'privacy_chapter_content_6_1' ] = $this->language->get( 'privacy_chapter_content_6_1' );

    $this->data[ 'privacy_chapter_headline_7' ] = $this->language->get( 'privacy_chapter_headline_7' );
    $this->data[ 'privacy_chapter_content_7_1' ] = $this->language->get( 'privacy_chapter_content_7_1' );

    $this->data[ 'privacy_chapter_headline_8' ] = $this->language->get( 'privacy_chapter_headline_8' );
    $this->data[ 'privacy_chapter_content_8_1' ] = $this->language->get( 'privacy_chapter_content_8_1' );
    $this->data[ 'privacy_chapter_content_8_2' ] = $this->language->get( 'privacy_chapter_content_8_2' );

    $this->data[ 'privacy_chapter_headline_9' ] = $this->language->get( 'privacy_chapter_headline_9' );
    $this->data[ 'privacy_chapter_content_9_1' ] = $this->language->get( 'privacy_chapter_content_9_1' );
    $this->data[ 'privacy_chapter_content_9_2' ] = $this->language->get( 'privacy_chapter_content_9_2' );

    $this->data[ 'privacy_chapter_headline_10' ] = $this->language->get( 'privacy_chapter_headline_10' );
    $this->data[ 'privacy_chapter_content_10_1' ] = $this->language->get( 'privacy_chapter_content_10_1' );
    $this->data[ 'privacy_chapter_content_10_2' ] = $this->language->get( 'privacy_chapter_content_10_2' );
    $this->data[ 'privacy_chapter_content_10_3' ] = $this->language->get( 'privacy_chapter_content_10_3' );
    $this->data[ 'privacy_chapter_content_10_4' ] = $this->language->get( 'privacy_chapter_content_10_4' );

    $this->data[ 'privacy_chapter_headline_11' ] = $this->language->get( 'privacy_chapter_headline_11' );
    $this->data[ 'privacy_chapter_content_11_1' ] = $this->language->get( 'privacy_chapter_content_11_1' );
    $this->data[ 'privacy_chapter_content_11_2' ] = $this->language->get( 'privacy_chapter_content_11_2' );
    $this->data[ 'privacy_chapter_content_11_3' ] = $this->language->get( 'privacy_chapter_content_11_3' );

    $this->data[ 'privacy_chapter_headline_12' ] = $this->language->get( 'privacy_chapter_headline_12' );
    $this->data[ 'privacy_chapter_content_12_1' ] = $this->language->get( 'privacy_chapter_content_12_1' );
    $this->data[ 'privacy_chapter_content_12_2' ] = $this->language->get( 'privacy_chapter_content_12_2' );
    $this->data[ 'privacy_chapter_content_12_3' ] = $this->language->get( 'privacy_chapter_content_12_3' );

    $this->data[ 'privacy_chapter_headline_13' ] = $this->language->get( 'privacy_chapter_headline_13' );
    $this->data[ 'privacy_chapter_content_13_1' ] = $this->language->get( 'privacy_chapter_content_13_1' );
    $this->data[ 'privacy_chapter_content_13_2' ] = $this->language->get( 'privacy_chapter_content_13_2' );
    $this->data[ 'privacy_chapter_content_13_3' ] = $this->language->get( 'privacy_chapter_content_13_3' );
    $this->data[ 'privacy_chapter_content_13_4' ] = $this->language->get( 'privacy_chapter_content_13_4' );

    $this->data[ 'privacy_chapter_headline_14' ] = $this->language->get( 'privacy_chapter_headline_14' );
    $this->data[ 'privacy_chapter_content_14_1' ] = $this->language->get( 'privacy_chapter_content_14_1' );
    $this->data[ 'privacy_chapter_content_14_2' ] = $this->language->get( 'privacy_chapter_content_14_2' );
    $this->data[ 'privacy_chapter_content_14_3' ] = $this->language->get( 'privacy_chapter_content_14_3' );

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
    $this->response->setRobots( 'noindex, follow' );
    
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