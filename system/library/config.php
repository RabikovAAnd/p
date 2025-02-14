<?php
class Config
{

  //----------------------------------------------------------------------------

  // Local objects
  private $db;
  private $data = array();

  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------

  public function __construct( $registry )
  {

    // Get and assign database object
    $this->db = $registry->get( 'db' );

    // Compose SQL query
    $sql = "SELECT s.language_code, s.key, s.value, s.serialized FROM setting s";

    // Query database
    $result = $this->db->query( $sql );

    // Decompose settings
    foreach ( $result->rows as $setting )
    {

      // Test for serialized value
      if ( $setting[ 'serialized' ] == 0 )
      {

        // Set value
        $this->set( $setting[ 'key' ], $setting[ 'value' ], $setting[ 'language_code' ] );

      }
      else
      {

        // Deserialize and set value
        $this->set( $setting[ 'key' ], unserialize( $setting[ 'value' ] ), $setting[ 'language_code' ] );

      }

    }

  }

  //----------------------------------------------------------------------------
  // Get key
  //----------------------------------------------------------------------------

  public function get( $key, $language_code='' )
  {

    // Compose key
    $ext_key = 'config_' . $key;

    // Test for language code is empty
    if ( $language_code != '' )
    {

      // Add language postfix
      $ext_key = $ext_key . '_' . strtolower( $language_code );
      
    }

    // Get value
    if ( isset( $this->data[ $ext_key ] ) )
    {

      // Extract value
      $value = $this->data[ $ext_key ];

    }
    else
    {

      // Trigger error
      trigger_error( 'CONFIG: Key could not be found: ' . $ext_key );

      // Set default value
      $value = null;

    }

    // Return value
    return ( $value );

  }

  //----------------------------------------------------------------------------
  // Set key
  //----------------------------------------------------------------------------

  public function set( $key, $value, $language_code='' )
  {

    // Compose key
    $ext_key = 'config_' . $key;

    // Test for language code is empty
    if ( $language_code != '' )
    {

      // Add language postfix
      $ext_key = $ext_key . '_' . strtolower( $language_code );
      
    }

    // Set value
    $this->data[ $ext_key ] = $value;

  }

  //----------------------------------------------------------------------------

  public function has( $key, $language_code='' )
  {

    // Compose key
    $ext_key = 'config_' . $key;

    // Test for language code is empty
    if ( $language_code != '' )
    {

      // Add language postfix
      $ext_key = $ext_key . '_' . strtolower( $language_code );
      
    }

    // Return status
    return isset( $this->data[ $ext_key ] );

  }

  //----------------------------------------------------------------------------
  // Load configuration from file
  //----------------------------------------------------------------------------

  public function load( $filename )
  {

    // Compose file name
    $file = DIR_CONFIG . $filename . '.php';

    // Test for file exists
    if ( file_exists( $file ) )
    {

      // Prepare configuration data array
      $_ = array();

      // Load configuration data from file
      require( $file );

      // Add configuration data
      $this->data = array_merge( $this->data, $_ );

    }
    else
    {

      // Trigger error
      trigger_error( 'CONFIG: Could not load config file: ' . $filename );
      
      // Terminate execution
      exit();

    }

  }

  //----------------------------------------------------------------------------

}
?>