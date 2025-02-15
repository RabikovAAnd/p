<?php
class Language
{

  //----------------------------------------------------------------------------
  // Private variables
  //----------------------------------------------------------------------------

  private $config;
  private $cache;
  private $session;
  private $db;
  private $log;

  private $module;
  private $controller;
  private $method;

  private $language_code;
  private $direction;

  private $data = array();

  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------

  public function __construct( $registry, $language_code = 'XX' )
  {

    $this->config = $registry->get( 'config' );
    $this->cache = $registry->get( 'cache' );
    $this->session = $registry->get( 'session' );
    $this->db = $registry->get( 'db' );
    $this->log = $registry->get( 'log' );

    $this->language_code = 'XX';
    $this->direction = 'ltr';

    // Set new language code
    $this->Set_Language_Code( $language_code );

  }

  //----------------------------------------------------------------------------
  // Set language code
  //----------------------------------------------------------------------------

  public function Set_Language_Code( $language_code = '' )
  {

    // Test for manguage code is empty
    if ( $language_code === '' )
    {

      //------------------------------------------------------------------------
      // Language code empty
      //------------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // Language code valid
      //------------------------------------------------------------------------

      //! @todo ANVILEX KM: Test for language code exists

      // Store language
      $this->language_code = strtoupper( $language_code );

      // Store language code in session
      $this->session->Set( 'language_code', $this->language_code );

    // Log debug message
//    $this->log->write( 'LANGUAGE : New language : ' . $language_code );

    }

  }

  //----------------------------------------------------------------------------
  // Get language code
  //----------------------------------------------------------------------------

  public function Get_Language_Code()
  {

    // Test for language code setted
    if ( $this->session->Is_Exists( 'language_code' ) === false )
    {

      //------------------------------------------------------------------------
      // Return default language code
      //------------------------------------------------------------------------

      // Return default language
      $this->language_code = 'EN';

      // Store language code in session
      $this->session->Set( 'language_code', $this->language_code );

      // Return default language
      $language_code = $this->language_code;

    }
    else
    {

      //------------------------------------------------------------------------
      // Language code present in session
      //------------------------------------------------------------------------

      // Get language code from session
      $language_code = $this->session->Get( 'language_code' );

    }

    // Return language code
    return( strtoupper( $language_code ) );

  }

  //----------------------------------------------------------------------------
  // Get language direction
  //----------------------------------------------------------------------------

  public function Get_Language_Direction()
  {

    // Return language direction
    return( $this->direction );

  }

  //----------------------------------------------------------------------------
  // Get language information
  //----------------------------------------------------------------------------

  public function Get_Language_Info( $language_code )
  {

    // Compose SQL query
    $sql_query = 
      "SELECT " .
        "* " .
      "FROM " .
        "languages " .
      "WHERE " .
        "code = '" . $language_code . "'";

    // Execute SQL query
    $result = $this->db->query( $sql_query );

    // Return language
    return ( $result->row );

  }

  //----------------------------------------------------------------------------
  // Get list of languages
  //----------------------------------------------------------------------------

  public function Get_Languages()
  {

    // Get language data from cache
//    $language_data = $this->cache->get( 'languages' );

    // Test for cache data valid
//    if ( !$language_data )
//    {

      //------------------------------------------------------------------------
      // Cache miss, try to load languages from database
      //------------------------------------------------------------------------

      // Create array
      $language_data = array();

      // Compose SQL query
      $sql_query = 
        "SELECT " .
          "code, " .
          "guid, " .
          "name, " .
          "locale " .
        "FROM " .
          "language " .
        "WHERE " . 
          "enabled='1' " .
        "ORDER BY " .
          "name";

      // Execute SQL query
      $results = $this->db->query( $sql_query );

      // Iterate over all languages
      foreach ( $results->rows as $result )
      {

        // Compose language item
        $language_data[ $result[ 'code' ] ] = array(
          'code' => $result[ 'code' ],
          'name' => $result[ 'name' ],
          'guid' => $result[ 'guid' ],
          'locale' => $result[ 'locale' ]
        );

      }

      // Set cache
//      $this->cache->set( 'languages', $language_data );

//    }

    // Return list of languages
    return( $language_data );

  }

  //----------------------------------------------------------------------------
  // Check language code validity
  //----------------------------------------------------------------------------

  public function Is_Language_Code_Valid()
  {

    return( true );

  }

  //----------------------------------------------------------------------------
  // Get string method
  //----------------------------------------------------------------------------
  //! @todo ANVILEX KM : Deprecated

  public function get( $key )
  {

    // Log error message
    $this->log->Log_Notice( 'LANGUAGE : Old style getting message method used for key: ' . $key );

    // Test for string exists
    if ( isset( $this->data[ $key ] ) == false )
    {

      //------------------------------------------------------------------------
      // String not exists in cache
      //------------------------------------------------------------------------

      // Compose SQL query
      $sql = 
        "SELECT " .
          "text " . 
        "FROM " . 
          "system_messages " .
        "WHERE " .
          "name='" . $key . "' AND " .
          "language_code='" . $this->language_code . "'";

      // Execute SQL query
      $result = $this->db->query( $sql );

      // Test record count
      if ( $result->num_rows != 1 )
      {

        // Log error message
        $this->log->Log_Notice( 'LANGUAGE : Message not found: ' . $key );

        // Set default value
        $message = '{' . $key . '}';

      }
      else
      {

        // Extract message
        $message = $result->row[ 'text' ];

      }

    }
    else
    {

      //------------------------------------------------------------------------
      // String cache pass, get from cache
      //------------------------------------------------------------------------

      // Compose message
      $message = isset( $this->data[ $key ] ) ? $this->data[ $key ] : '{' . $key . '}';

    }

    // Return message
    return ( $message );

  }

}
//----------------------------------------------------------------------------
// End of file
//----------------------------------------------------------------------------
?>
