<?php
class Session
{

  public $data = array();

  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------

  public function __construct()
  {

    // Test for session identifier exista
    if ( !session_id() )
    {

      ini_set( 'session.use_cookies', 'On' );
      ini_set( 'session.use_trans_sid', 'Off' );

      session_set_cookie_params( 0, '/' );
      session_start();

    }

    // Restore session data
    $this->data =& $_SESSION;

  }

  //----------------------------------------------------------------------------
  // Get session ID
  //----------------------------------------------------------------------------

  function getId()
  {

    // Return session identifier
    return( session_id() );

  }

  //----------------------------------------------------------------------------
  // Return status
  //----------------------------------------------------------------------------
  
  public function Is_Exists( $key = '' )
  {
   
    // Return status
    return( isset( $_SESSION[ $key ] ) === true );

  }
 
  //----------------------------------------------------------------------------
  // Get value
  //----------------------------------------------------------------------------

  public function Get( $key = '' )
  {
    
    // Test for key setted
    if ( isset( $_SESSION[ $key ] ) === false )
    {

      //------------------------------------------------------------------------
      // Value not setted, return empty string
      //------------------------------------------------------------------------
      
      // Set default value
      $value = '';
      
    }
    else
    {
      
      //------------------------------------------------------------------------
      // Value setted, return value
      //------------------------------------------------------------------------
   
      // Get value from session
      $value = $_SESSION[ $key ];
    
    }
   
    // Return value
    return( $value );

  }

  //----------------------------------------------------------------------------
  // Get value
  //----------------------------------------------------------------------------

  public function Set( $key = '', $value = '' )
  {
    
    // Set value in session
    $_SESSION[ $key ] = $value;

  }
  
  //----------------------------------------------------------------------------
  // Delete
  //----------------------------------------------------------------------------

  public function Delete( $key = '' )
  {

    // Test for key setted
    if ( isset( $_SESSION[ $key ] ) === true )
    {

      //------------------------------------------------------------------------
      // Value setted, unset it
      //------------------------------------------------------------------------

      // Get value from session
      unset( $_SESSION[ $key ] );

    }

  }
  
}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>