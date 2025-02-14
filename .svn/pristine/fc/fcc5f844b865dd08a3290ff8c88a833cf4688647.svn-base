<?php
class ControllerCompanyRevocation extends Controller
{

  //----------------------------------------------------------------------------
  
  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'company', 'revocation', 'index', $this->language->Get_Language_Code() );

    // Set data
    $this->data[ 'text_message_header' ] = $this->language->get( 'text_header' );

    $this->data[ 'revocation_chapter_headline_1' ] = $this->language->get( 'revocation_chapter_headline_1' );
    $this->data[ 'revocation_chapter_content_1_1' ] = $this->language->get( 'revocation_chapter_content_1_1' );
    $this->data[ 'revocation_chapter_content_1_2' ] = $this->language->get( 'revocation_chapter_content_1_2' );

    $this->data[ 'revocation_chapter_headline_2' ] = $this->language->get( 'revocation_chapter_headline_2' );

    $this->data[ 'revocation_chapter_headline_2_1' ] = $this->language->get( 'revocation_chapter_headline_2_1' );
    $this->data[ 'revocation_chapter_content_2_1_1' ] = $this->language->get( 'revocation_chapter_content_2_1_1' );
    $this->data[ 'revocation_chapter_content_2_1_2' ] = $this->language->get( 'revocation_chapter_content_2_1_2' );
    $this->data[ 'revocation_chapter_content_2_1_3' ] = $this->language->get( 'revocation_chapter_content_2_1_3' );

    $this->data[ 'revocation_chapter_headline_2_2' ] = $this->language->get( 'revocation_chapter_headline_2_2' );
    $this->data[ 'revocation_chapter_content_2_2_1' ] = $this->language->get( 'revocation_chapter_content_2_2_1' );
    $this->data[ 'revocation_chapter_content_2_2_2' ] = $this->language->get( 'revocation_chapter_content_2_2_2' );
    $this->data[ 'revocation_chapter_content_2_2_3' ] = $this->language->get( 'revocation_chapter_content_2_2_3' );
    $this->data[ 'revocation_chapter_content_2_2_4' ] = $this->language->get( 'revocation_chapter_content_2_2_4' );

    $this->data[ 'revocation_chapter_headline_2_3' ] = $this->language->get( 'revocation_chapter_headline_2_3' );

    $this->data[ 'revocation_chapter_headline_3' ] = $this->language->get( 'revocation_chapter_headline_3' );
    $this->data[ 'revocation_chapter_headline_3_1' ] = $this->language->get( 'revocation_chapter_headline_3_1' );
    $this->data[ 'revocation_chapter_content_3_1_1' ] = $this->language->get( 'revocation_chapter_content_3_1_1' );
    $this->data[ 'revocation_chapter_content_3_1_2' ] = $this->language->get( 'revocation_chapter_content_3_1_2' );
    $this->data[ 'revocation_chapter_content_3_1_3' ] = $this->language->get( 'revocation_chapter_content_3_1_3' );

    $this->data[ 'revocation_chapter_headline_3_2' ] = $this->language->get( 'revocation_chapter_headline_3_2' );
    $this->data[ 'revocation_chapter_content_3_2_1' ] = $this->language->get( 'revocation_chapter_content_3_2_1' );

    $this->data[ 'revocation_chapter_headline_3_3' ] = $this->language->get( 'revocation_chapter_headline_3_3' );

    $this->data[ 'revocation_chapter_headline_4' ] = $this->language->get( 'revocation_chapter_headline_4' );
    $this->data[ 'revocation_chapter_content_4_1' ] = $this->language->get( 'revocation_chapter_content_4_1' );
    $this->data[ 'revocation_chapter_content_4_2' ] = $this->language->get( 'revocation_chapter_content_4_2' );

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle($this->messages->Get_Message('document_title_text'));
    $this->response->setDescription($this->messages->Get_Message('document_description_text'));
    $this->response->setKeywords('');
    $this->response->setRobots('index, follow');
    
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