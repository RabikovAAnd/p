<?php
class ControllerLanguageLanguage extends Controller
{

  //----------------------------------------------------------------------------
  // Show language selection page
  //----------------------------------------------------------------------------

  public function index()
  {

    //------------------------------------------------------------------------
    // Set page data
    //------------------------------------------------------------------------

    // Load messages
    $this->messages->Load( $this->data, 'language', 'language', 'index', $this->language->Get_Language_Code() );

    // Get languages
    $languages = $this->language->Get_Languages();

    // Create languages array
    $this->data[ 'languages' ] = array();

    // Process all languages
    foreach ( $languages as $language )
    {

      // Compose language item
      $this->data[ 'languages' ][] = array(
        'language_name'  => $this->data[ 'language_language_language_button_' . strtolower( $language[ 'name' ] ) ] ,
        'language_link'  => $this->url->link( 'language/language/select', 'language_code=' . $language[ 'code' ] ),
        'language_active' => ( $this->language->Get_Language_Code() == $language[ 'code' ] )
      );

    }

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle($this->messages->Get_Message('document_title_text'));
    $this->response->setDescription($this->messages->Get_Message('document_description_text'));
    $this->response->setKeywords('');
    $this->response->setRobots('index, follow');

    // Add stylesheets
    $this->response->addStyle( 'catalog/view/stylesheet/common/language.css' );

    // Set page children
    $this->children = array(
      'common/footer',
      'common/header'
    );

  }

  //----------------------------------------------------------------------------
  // Set new language method
  //----------------------------------------------------------------------------

  public function select()
  {

    // Test for language code parameter present
    if ( $this->request->Is_GET_Parameter_Exists( 'language_code' ) === false )
    {

      //------------------------------------------------------------------------
      // Parameter not exists
      //------------------------------------------------------------------------

      // Redirect back to language selection page
      $this->response->Redirect( $this->url->link( 'language/language', '', '' ) );

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter exists
      //------------------------------------------------------------------------

      // Store language to the session
      $this->language->Set_Language_Code( $this->request->Get_GET_Parameter_As_String( 'language_code' ) );

//      if ( $this->request->Get_Request_Prereferer() == '' )
      if ( $this->session->Get( 'request_prereferer' ) == '' )
      {

        //----------------------------------------------------------------------
        // No fallback page defined
        //----------------------------------------------------------------------

        // Redirect back to home page
        $this->response->Redirect( $this->url->link( 'common/home', '', '' ) );

      }
      else
      {

        //----------------------------------------------------------------------
        // Fallback page defined, redirect to it
        //----------------------------------------------------------------------

        // Redirect back to referer page
//        $this->response->Redirect( $this->request->Get_Request_Prereferer() );
        $this->response->Redirect( $this->session->data[ 'request_prereferer' ] );

      }

    }

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>