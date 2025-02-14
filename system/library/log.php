<?php
class Log
{

  // Log file filename
  private $filename;

  // Global error buffer
  public $global_error_buffer = array();

  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------

  public function __construct()
  {

    // Compose log file name
    $this->filename = 'error_' . date( 'Ymd' ) . '.txt';

  }

  //----------------------------------------------------------------------------
  // Write message to the log file
  //----------------------------------------------------------------------------

  public function Write( $message, $category = '' )
  {

    // Compose full file name
    $file = DIR_LOGS . $this->filename;

    // Try to open file to append
    $handle = fopen( $file, 'a+' );

    // Test handle to be valid
    if ( $handle === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Can not open log file
      //------------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // File handle valid
      //------------------------------------------------------------------------

      // Test for message an array
      if ( is_array( $message ) === true )
      {
        
        //----------------------------------------------------------------------
        // Message is array
        //----------------------------------------------------------------------
              
        // Test for category specified
        if ( $category == '' )
        {

          //------------------------------------------------------------------
          // Category not specified
          //------------------------------------------------------------------

          // Write log message
          fwrite( $handle, date( 'Y-m-d G:i:s' ) . ' - ' . print_r( $message ) . "\n" );
      
          $this->global_error_buffer[] = date( 'Y-m-d G:i:s' ) . ' - ' . print_r( $message );

        }
        else
        {

          //------------------------------------------------------------------
          // Category specified
          //------------------------------------------------------------------

          // Write log message
          fwrite( $handle, date( 'Y-m-d G:i:s' ) . ' - ' . $category . ': ' . print_r( $message ) . "\n" );

          $this->global_error_buffer[] = date( 'Y-m-d G:i:s' ) . ' - ' . $category . ': ' . print_r( $message );

        }

      }
      else
      {

        //----------------------------------------------------------------------
        // Message is a string
        //----------------------------------------------------------------------

        // Test for category specified
        if ( $category == '' )
        {

          //--------------------------------------------------------------------
          // Category not specified
          //--------------------------------------------------------------------

          // Write log message
          fwrite( $handle, date( 'Y-m-d G:i:s' ) . ' - ' . $message . "\n" );

          $this->global_error_buffer[] = date( 'Y-m-d G:i:s' ) . ' - ' . $message;

        }
        else
        {

          //--------------------------------------------------------------------
          // Category specified
          //--------------------------------------------------------------------

          // Write log message
          fwrite( $handle, date( 'Y-m-d G:i:s' ) . ' - ' . $category . ': ' . $message . "\n" );

          $this->global_error_buffer[] = date( 'Y-m-d G:i:s' ) . ' - ' . $category . ': ' . $message;
        
        }

      }

      // Close file
      fclose( $handle );

    }

  }

  //----------------------------------------------------------------------------
  // Log debug message
  //----------------------------------------------------------------------------

  public function Log_Debug( $message )
  {

    // Log debug message
    $this->write( $message, "DEBUG" );
    
  }

  //----------------------------------------------------------------------------
  // Log information message
  //----------------------------------------------------------------------------

  public function Log_Info( $message )
  {

    // Log information message
    $this->write( $message, "INFO" );
    
  }

  //----------------------------------------------------------------------------
  // Log notification message
  //----------------------------------------------------------------------------

  public function Log_Notice( $message )
  {

    // Log information message
    $this->write( $message, "NOTICE" );
    
  }

  //----------------------------------------------------------------------------
  // Log error message
  //----------------------------------------------------------------------------

  public function Log_Error( $message, $calltrace = false )
  {

    // Log error message
    $this->write( $message, "ERROR" );

    // Test for calltrace enabled
    if ( $calltrace == true )
    {

      //------------------------------------------------------------------------
      // Calltrace enable
      //------------------------------------------------------------------------

      // Log backtrace
      $this->write( debug_backtrace()[ 1 ][ 'function' ], "TRACE" );
      $this->write( debug_backtrace()[ 2 ][ 'function' ], "TRACE" );

    }

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>