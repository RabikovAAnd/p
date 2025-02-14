<?php
class Url
{

  // Private properties
  private $url;
  private $ssl;
//  private $rewrite = array();
  private $country_code = '';
  private $language_code = '';

  //----------------------------------------------------------------------------
  // Constructor method
  //----------------------------------------------------------------------------

  public function __construct( $url, $ssl = '', $country_code = '', $language_code = '' )
  {

    $this->url = $url;
    $this->ssl = $ssl;
    $this->country_code = $country_code;
    $this->language_code = $language_code;

  }

  //----------------------------------------------------------------------------
  //! @todo ANVILEX KM: This rewrite functionality not used, remove it. User only by SEO
/*
  public function addRewrite( $rewrite )
  {

    $this->rewrite[] = $rewrite;

  }
*/
  //----------------------------------------------------------------------------
  // Set country
  //----------------------------------------------------------------------------

  public function Set_Country( $country_code = '' )
  {
    
    // Set country code
    $this->country_code = $country_code;

  }

  //----------------------------------------------------------------------------
  // Set language
  //----------------------------------------------------------------------------

  public function Set_Language( $language_code = '' )
  {
    
    // Set language code
    $this->language_code = $language_code;
    
  }
    
  //----------------------------------------------------------------------------
  // Generate link
  //----------------------------------------------------------------------------

  public function Link( $route, $parameters = '', $connection = 'NONSSL' )
  {

    // Test connection type
    if ( $connection ==  'NONSSL' )
    {

      //------------------------------------------------------------------------
      // Not secure HTTP request
      //------------------------------------------------------------------------

      // Use HTTP server
      $url = $this->url;

    }
    else
    {

      //------------------------------------------------------------------------
      // Secure HTTPS request
      //------------------------------------------------------------------------

      // Use HTTPS server
      $url = $this->ssl;

    }

    // Compose URL
    $url .= 'index.php?route=' . trim( $route );
//    $url .= 'index.php?route=' . $this->country_code . '/' . $this->language_code . '/'. $route;

    //--------------------------------------------------------------------------
    // Process arguments
    //--------------------------------------------------------------------------

    // Trim parameters string
    $trimmed_parameters = trim( $parameters );

    // Test for arguments present
    if ( $trimmed_parameters !== '' )
    {

      // Append parameters
      //! @note ANVILEX KM: Not clear why replase "&" to "&amp;" ???
//      $url .= str_replace( '&', '&amp;', '&' . ltrim( $args, '&' ) );
      $url .= '&' . ltrim( $trimmed_parameters, '&' );

    }

    // Return URL
    return ( $url );

  }

}
//----------------------------------------------------------------------------
// End of file
//----------------------------------------------------------------------------
?>