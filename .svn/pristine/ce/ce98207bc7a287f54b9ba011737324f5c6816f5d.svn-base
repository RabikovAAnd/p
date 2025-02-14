<?php
class Messages
{

  //----------------------------------------------------------------------------
  // Private variables
  //----------------------------------------------------------------------------

  // Reference to the database global object
  private $db;

  // Reference to the global log object
  private $log;

  // Module name
  private $module = '';

  // Controller name
  private $controller = '';

  // Method name
  private $method = '';

  // List of the messages
  private $messages = array();

  // List of structured messages
  private $structured_messages = array();

  private $acl;

  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------

  public function __construct( $registry )
  {

    // Store global objects
    $this->db = $registry->get( 'db' );
    $this->log = $registry->get( 'log' );

    // TEMPORARY CODE
//    $this->acl = $registry->get( 'acl' );

  }

  //----------------------------------------------------------------------------
  // Load messages from database
  //----------------------------------------------------------------------------

  public function Load( &$data, $module, $controller, $method, $language_code )
  {

    // Store message location
    $this->module = $module;
    $this->controller = $controller;
    $this->method = $method;

    // Test input parameters
    if (
      ( isset( $module ) === false ) ||
      ( isset( $controller ) === false ) ||
      ( isset( $method ) === false ) ||
      ( isset( $language_code ) === false )
    )
    {

      //------------------------------------------------------------------------
      // ERROR: Invalid input data
      //------------------------------------------------------------------------

      // ERROR: Invalid input data
      $this->log->write( 'LANGUAGE : Bad request. Module = ' . $module . ', controller = ' . $controller . ', method = ' . $method . ', language = ' . $language_code );

    }
    else
    {

      //------------------------------------------------------------------------
      // Input data valid
      //------------------------------------------------------------------------

      // Compose SQL query
      $sql =
        "SELECT " .
          "`messages`.`module`, " .
          "`messages`.`controller`, " .
          "`messages`.`method`, " .
          "`messages`.`element`, " .
          "`messages`.`name`, " .
          "`messages`.`text` " .
        "FROM " .
          "`messages` " .
        "WHERE " .
          "`messages`.`module`='" . $module . "' AND " .
          "`messages`.`controller`='" . $controller . "' AND " .
          "`messages`.`method`='" . $method . "' AND " .
          "`messages`.`language_code`='" . $language_code . "'";

      // Execute SQL query
      $query = $this->db->query( $sql );

      // Process all messages
      foreach ( $query->rows as $row )
      {

        // Compose message key
        if ( $row[ 'element' ] == '' )
        {
          $message_key = $module . "_" . $controller . "_" . $row[ 'name' ];
        }
        else
        {
          $message_key = $module . "_" . $controller . "_" . $row[ 'element' ] . "_" . $row[ 'name' ];
        }

        // Add message
        $this->messages[ $message_key ] = $row[ 'text' ];

        //----------------------------------------------------------------------
        // Process structured messages
        //----------------------------------------------------------------------

        // Add structured message
        $this->structured_messages[ $message_key ][ 'key' ] = $message_key;

        $this->structured_messages[ $message_key ][ 'module' ] = $row[ 'module' ];
        $this->structured_messages[ $message_key ][ 'controller' ] = $row[ 'controller' ];
        $this->structured_messages[ $message_key ][ 'method' ] = $row[ 'method' ];
        $this->structured_messages[ $message_key ][ 'element' ] = $row[ 'element' ];
        $this->structured_messages[ $message_key ][ 'name' ] = $row[ 'name' ];
        $this->structured_messages[ $message_key ][ 'text' ] = $row[ 'text' ];

      }

    }

    // Merge loaded messages to existing messages
    $data = array_merge( $data, $this->messages );

    //--------------------------------------------------------------------------
/*
$this->log->Log_Debug( 'ENDPOINT M: ' . $this->acl->endpoint_name );

    if ( $this->acl->endpoint_name != '' )
    {

      $sql =
        "UPDATE " .
          "`messages` " .
        "SET " .
          "`messages`.`endpoint`='" . $this->acl->endpoint_name . "' " .
        "WHERE " .
          "`messages`.`module`='" . $module . "' AND " .
          "`messages`.`controller`='" . $controller . "' AND " .
          "`messages`.`method`='" . $method . "'";

      // Execute SQL query
      $query = $this->db->query( $sql );

    }
*/    
  }

  //----------------------------------------------------------------------------
  // Get structured messages
  //----------------------------------------------------------------------------

  public function Get_Messages()
  {

    // Return structured Messages
    return( $this->structured_messages );

  }

  //--------------------------------------------------------------------------
  // Get local message
  //--------------------------------------------------------------------------

  public function Get_Message( $name = '' )
  {

    // Compose key
    $key = $this->module . "_" . $this->controller . "_" . $name;

    // Return message referenced by key
    return( $this->Get_Message_By_Key( $key ) );

  }

  //--------------------------------------------------------------------------
  // Get message from database
  //--------------------------------------------------------------------------

  public function Get_Message_From_Database( $module, $controller, $method, $element, $name, $language_code )
  {
    
    // Compose SQL query
    $sql =
      "SELECT " .
        "`messages`.`text` " .
      "FROM " .
        "`messages` " .
      "WHERE " .
        "`messages`.`module`='" . $module . "' AND " .
        "`messages`.`controller`='" . $controller . "' AND " .
        "`messages`.`method`='" . $method . "' AND " .
        "`messages`.`element`='" . $element . "' AND " .
        "`messages`.`name`='" . $name . "' AND " .
        "`messages`.`language_code`='" . $language_code . "'";

    // Execute SQL query
    $query = $this->db->query( $sql );

    return( '' );

  }
  
  //--------------------------------------------------------------------------
  // Get global message
  //--------------------------------------------------------------------------
  //! @note ANVILEX KM: This method not used, remove it. 
  //--------------------------------------------------------------------------

  public function Get_Global_Message( $module = '', $controller = '', $method = '', $name = '', $language_code = '' )
  {

    // Compose key
    $key = $module . '_' . $controller . '_' . $name;

    // Return message referenced by key
    return( $this->Get_Message_By_Key( $key ) );

  }

  //----------------------------------------------------------------------------
  // Get message by key
  //----------------------------------------------------------------------------

  private function Get_Message_By_Key( $key = '' )
  {

    // Test for key exists
    if ( array_key_exists( $key, $this->messages ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Message not found
      //------------------------------------------------------------------------

      // Log notice
      $this->log->Log_Notice( 'LANGUAGE : Message not found: ' . $key );

      // Return key as message
      $message = '{' . $key . '}';

    }
    else
    {

      //------------------------------------------------------------------------
      // Message found, return it
      //------------------------------------------------------------------------

      // Get message
      $message = $this->messages[ $key ];

    }

    // Return message
    return( $message );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
