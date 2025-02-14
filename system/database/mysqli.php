<?php
final class DBMySQLi
{

  // Database object
  private $link;

  //----------------------------------------------------------------------------
	// Constructor
	//----------------------------------------------------------------------------
	
  public function __construct( $hostname, $username, $password, $database )
  {

    // Try to connect database
    $this->link = new mysqli( $hostname, $username, $password, $database );

    // Test for database connection error
    if ( mysqli_connect_error() )
    {

      throw new ErrorException( 'Error: Could not make a database link (' . mysqli_connect_errno() . ') ' . mysqli_connect_error() );

    }

    // Set default charset
    $this->link->set_charset( "utf8" );

  }

  //----------------------------------------------------------------------------
  // Destructor
  //----------------------------------------------------------------------------

  public function __destruct()
  {

    // Close database
    $this->link->close();

  }

  //----------------------------------------------------------------------------
  // Query database method
  //----------------------------------------------------------------------------

  public function query( $sql )
  {

    // Create result
    $result = new stdClass();

    // Try to query database
    $query = $this->link->query( $sql );

    // Test for no error present
    if ( $this->link->errno == 0 )
    {

      //------------------------------------------------------------------------
      // Query processed
      //------------------------------------------------------------------------

      // Test for query return data
      if ( isset( $query->num_rows ) === true )
      {

        //----------------------------------------------------------------------
        // Query return data
        //----------------------------------------------------------------------

        // Set rows count
        $result->num_rows = $query->num_rows;

        $data = array();

        // Fetch rows
        while ( $row = $query->fetch_array() )
        {

          // Add fetched row
          $data[] = $row;

        }
        
        // Set rows
        $result->row = isset( $data[ 0 ] ) ? $data[ 0 ] : array();
        $result->rows = $data;
        $result->data = $data;

        // Unset data
        unset( $data );

        // Close database query
        $query->close();

        // Set success code
        $result->return_code = true;

      }
      else
      {

        //----------------------------------------------------------------------
        // Query not return data
        //----------------------------------------------------------------------

        // Set success code
        $result->return_code = true;

      }

    }
    else
    {

      //------------------------------------------------------------------------
      // ERROR: SQL query failed
      //------------------------------------------------------------------------
      
      throw new ErrorException( 'Error: ' . $this->link->error . '<br />Error No: ' . $this->link->errno . '<br />' . $sql );
      
      // Terminate execution
//      exit();

      // Set error code
      $result->return_code = false;

    }

    // Return result
    return( $result );

  }
 
  //----------------------------------------------------------------------------
  // Escape SQL string method
  //----------------------------------------------------------------------------

  public function escape( $value )
  {

    return( $this->link->real_escape_string( $value ) );

  }

  //----------------------------------------------------------------------------
	// Get affected row count method
	//----------------------------------------------------------------------------

  public function countAffected()
  {

    return( $this->link->affected_rows );

  }

  //----------------------------------------------------------------------------
  // Get last id
  //----------------------------------------------------------------------------

  public function getLastId()
  {

    return( $this->link->insert_id );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>