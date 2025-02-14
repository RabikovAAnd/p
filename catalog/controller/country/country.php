<?php
class ControllerCountryCountry extends Controller
{

  //----------------------------------------------------------------------------
  // Show country selection page
  //----------------------------------------------------------------------------
  
  public function index()
  {
    //------------------------------------------------------------------------
    // Set page data
    //------------------------------------------------------------------------

    // Load messages
    $this->messages->Load( $this->data, 'country', 'country', 'index', $this->language->Get_Language_Code() );

    //--------------------------------------------------------------------------

    $this->data[ 'countries' ] = array();

    // Get countries
    $countries = $this->location->Get_Countries( $this->language->Get_Language_Code() );

    // Process all countries
    foreach ( $countries as $country )
    {

      // Test country status
      if ( $country[ 'status' ] )
      {

        $this->data[ 'countries' ][] = array(
          'country_name' => $country[ 'name' ],
          'country_iso' => $country[ 'iso_code_2' ],
          'country_link' => $this->url->link( 'country/country/select', 'country_code=' . $country[ 'iso_code_2' ] ),
          'country_path' => '/shop/image/flags/' . strtolower( $country[ 'iso_code_2' ] ) . ".png",
          'country_active' => ( $this->location->Get_Country_Code() == $country[ 'iso_code_2' ] )

        );  

      }

    }

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
    $this->response->setKeywords( '' );
    $this->response->setRobots( 'index, follow' );

    $this->response->addStyle( 'catalog/view/stylesheet/common/country.css' );

    // Set page children
    $this->children = array(
      'common/footer',
      'common/header'
    );

  }

  //----------------------------------------------------------------------------
  // Set new country method
  //----------------------------------------------------------------------------

  public function select()
  {

    // Get country identifier
    if ( $this->request->Is_GET_Parameter_Exists( 'country_code' ) )
    {

      // Store country to the session
      $this->location->Set_Country_Code( $this->request->Get_GET_Parameter_As_String( 'country_code' ) );

//      if ( $this->request->Get_Request_Prereferer() == '' )
      if ( $this->session->Get( 'request_prereferer' ) == '' )
      {

        // Redirect back to home page
        $this->response->Redirect( $this->url->link( 'common/home', '', '' ) );

      }
      else
      {
 
        // Redirect back to referer page
//        $this->response->Redirect( $this->request->Get_Request_Prereferer() );
        $this->response->Redirect( $this->session->data[ 'request_prereferer' ] );

      }
 
    }
    else
    {

      // Redirect back to country selection page
      $this->response->Redirect( $this->url->link( 'country/country', '', '' ) );

    }

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>