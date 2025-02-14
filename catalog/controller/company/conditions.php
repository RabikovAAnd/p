<?php

class ControllerCompanyConditions extends Controller
{

  //----------------------------------------------------------------------------
  // Default method
  //----------------------------------------------------------------------------

  public function index()
  {

    //------------------------------------------------------------------------
    // Set page data
    //------------------------------------------------------------------------

    // Load messages
    $this->messages->Load( $this->data, 'company', 'conditions', 'index', $this->language->Get_Language_Code() );

    // Set page data
    $this->data['text_message_header'] = $this->language->get('text_header');

    $this->data['conditions_chapter_headline_1'] = $this->language->get('conditions_chapter_headline_1');
    $this->data['conditions_chapter_content_1_1'] = $this->language->get('conditions_chapter_content_1_1');

    $this->data['conditions_chapter_headline_2'] = $this->language->get('conditions_chapter_headline_2');
    $this->data['conditions_chapter_content_2_1'] = $this->language->get('conditions_chapter_content_2_1');
    $this->data['conditions_chapter_content_2_2'] = $this->language->get('conditions_chapter_content_2_2');
    $this->data['conditions_chapter_content_2_3'] = $this->language->get('conditions_chapter_content_2_3');

    $this->data['conditions_chapter_headline_3'] = $this->language->get('conditions_chapter_headline_3');
    $this->data['conditions_chapter_content_3_1'] = $this->language->get('conditions_chapter_content_3_1');
    $this->data['conditions_chapter_content_3_2'] = $this->language->get('conditions_chapter_content_3_2');
    $this->data['conditions_chapter_content_3_3'] = $this->language->get('conditions_chapter_content_3_3');
    $this->data['conditions_chapter_content_3_4'] = $this->language->get('conditions_chapter_content_3_4');

    $this->data['conditions_chapter_headline_4'] = $this->language->get('conditions_chapter_headline_4');
    $this->data['conditions_chapter_content_4_1'] = $this->language->get('conditions_chapter_content_4_1');

    $this->data['conditions_chapter_headline_5'] = $this->language->get('conditions_chapter_headline_5');
    $this->data['conditions_chapter_content_5_1'] = $this->language->get('conditions_chapter_content_5_1');

    $this->data['conditions_chapter_headline_6'] = $this->language->get('conditions_chapter_headline_6');
    $this->data['conditions_chapter_content_6_1'] = $this->language->get('conditions_chapter_content_6_1');
    $this->data['conditions_chapter_content_6_2'] = $this->language->get('conditions_chapter_content_6_2');

    $this->data['conditions_chapter_headline_7'] = $this->language->get('conditions_chapter_headline_7');
    $this->data['conditions_chapter_content_7_1'] = $this->language->get('conditions_chapter_content_7_1');
    $this->data['conditions_chapter_content_7_2'] = $this->language->get('conditions_chapter_content_7_2');

    $this->data['conditions_chapter_headline_8'] = $this->language->get('conditions_chapter_headline_8');
    $this->data['conditions_chapter_content_8_1'] = $this->language->get('conditions_chapter_content_8_1');

    $this->data['conditions_chapter_headline_9'] = $this->language->get('conditions_chapter_headline_9');
    $this->data['conditions_chapter_content_9_1'] = $this->language->get('conditions_chapter_content_9_1');

    $this->data['conditions_chapter_headline_10'] = $this->language->get('conditions_chapter_headline_10');
    $this->data['conditions_chapter_content_10_1'] = $this->language->get('conditions_chapter_content_10_1');

    $this->data['conditions_chapter_headline_11'] = $this->language->get('conditions_chapter_headline_11');
    $this->data['conditions_chapter_content_11_1'] = $this->language->get('conditions_chapter_content_11_1');

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
    $this->response->setRobots( 'index, follow' );

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