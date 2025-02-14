<?php
class DB
{

  // Database driver
  private $driver;

  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------

  public function __construct( $driver, $hostname, $username, $password, $database )
  {

    // Compose database driver file name
    $file = DIR_DATABASE . $driver . '.php';

    // Text for database driver file exists
    if ( file_exists( $file ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Database driver file not found
      //------------------------------------------------------------------------

      exit( 'Error: Could not load database driver type ' . $driver . '!' );

    }
    else
    {

      //------------------------------------------------------------------------
      // Database driver file found
      //------------------------------------------------------------------------

      // Load database driver file
      require_once( $file );

      // Compose database driver class
      $class = 'DB' . $driver;

      // Create database driver class
      $this->driver = new $class( $hostname, $username, $password, $database );

    }

  }

  //----------------------------------------------------------------------------
  // Query database
  //----------------------------------------------------------------------------

  public function query( $sql )
  {

    // Query database
    return( $this->driver->query( $sql ) );

  }

  //----------------------------------------------------------------------------
  // Escape string
  //----------------------------------------------------------------------------

  public function escape( $value )
  {

    // Escape string
    return( $this->driver->escape( $value ) );

  }

  //----------------------------------------------------------------------------
  // Get affected records
  //----------------------------------------------------------------------------

  public function countAffected()
  {

    // Return affected row count
    return( $this->driver->countAffected() );

  }

  //----------------------------------------------------------------------------
  // Get last id
  //----------------------------------------------------------------------------

  public function getLastId()
  {

    // Return last ID
    return( $this->driver->getLastId() );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>